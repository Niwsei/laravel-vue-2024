<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Bill;
use App\Models\BillList;
use App\Models\Store;


class TranSectionController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api'); //user ມີ Token ມາຫລືບໍ່
    }

    public function index(Request $request)
    {

        $sort = \Request::get('sort');
        $perpage = \Request::get('perpage');
        $month_type = $request->month_type;
        $dmy = $request->dmy;

        $m = explode("-", $dmy)[1];
        $y = explode("-", $dmy)[0];


        /*  return $y; */

        if ($month_type == "m") {
            $tran = Transection::orderBy("id", $sort)
                ->whereYear("created_at", $y)
                ->whereMonth("created_at", $m)
                ->paginate($perpage)
                ->toArray();

        } elseif ($month_type == "y") {

            $tran = Transection::orderBy("id", $sort)
            ->whereYear("created_at", $y)
            ->paginate($perpage)
            ->toArray();

        }
        return array_reverse($tran);

    }


    public function add(Request $request)
    {
        try {


            //ບິນທຶກຂໍ້ມູນໃບບິນ

            $bill_id = '';
            $read_tran = Bill::all()->sortByDesc('id')->take(1)->toArray();
            foreach ($read_tran as $new) {
                $bill_id = $new['bill_id'];
            }

            if ($bill_id != '') {
                $bill_id = (int) $bill_id + 1;
                $length = 5;
                $bill_id = substr(str_repeat(0, $length) . $bill_id, -$length);
            } else {
                $bill_id = 1;
                $length = 5;
                $bill_id = substr(str_repeat(0, $length) . $bill_id, -$length);
            }

            $bill = new Bill([
                'bill_id' => $bill_id,
                'customer_name' => $request->customer_name,
                'customer_tel' => $request->customer_tel
            ]);
            $bill->save();







            foreach ($request->listorder as $item) {

                $number = '';
                $read_tran = Transection::all()->sortByDesc('id')->take(1)->toArray(); //take(1)เเม่นกานดึงเอา1ลายกาน . toArray() เเม่นกานดึงเเบบ array

                foreach ($read_tran as $new) {
                    $number = $new['tran_id'];
                }

                if ($number != '') {
                    $number1 = str_replace("INC", "", $number);
                    $number2 = str_replace("EXP", "", $number1);
                    $number3 = (int) $number2 + 1;

                    $length = 5;
                    $number = substr(str_repeat(0, $length) . $number3, -$length);
                } else {
                    $number3 = 1;
                    $length = 5;
                    $number = substr(str_repeat(0, $length) . $number3, -$length);
                }

                if ($request->acc_type == "income") {
                    $tnum = "INC";

                } elseif ($request->accepts_type == "expense") {
                    $tnum = "EXP";

                }

                $tran = new Transection([
                    'tran_id' => $tnum . $number,
                    'tran_type' => $request->acc_type,
                    'product_id' => $item['id'],
                    'amount' => $item['order_amount'],
                    'price' => $item['order_amount'] * $item['price_sell'],
                    'tran_detail' => $item['name'],
                ]);
                $tran->save();

                //save listBill
                $bill_list = new BillList([
                    'bill_id' => $bill_id,
                    'name' => $item['name'],
                    'amount' => $item['order_amount'],
                    'price' => $item['price_sell']
                ]);
                $bill_list->save();




                // ອັບເດດຕັດສະຕ໊ອກ
                $store = Store::find($item['id']);
                $store_update = Store::find($item['id']);
                $store_update->update([
                    'amount' => $store->amount - $item["order_amount"]
                ]);

            }
            $success = true;
            $message = 'ບັນທຶກຂໍ້ມູນ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
            $bill_id = null;
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'bill_id' => $bill_id
        ];

        return response()->json($response);


    }


}
