<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Store;

use App\Models\Transection;

class StoreController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api'); //user ມີ Token ມາຫລືບໍ່
    }


    public function index()
    {


        $sort = \Request::get('sort');
        $perpage = \Request::get('perpage');
        $search = \Request::get('search');


        $store = Store::orderBy('id', $sort)
            // ຄົ້ນຫາຂໍ້ມູນ ໃນ field ດຽວ
            //  ->where('name' , 'LIKE', "%{$search}%")


            // ຄົ້ນຫາຂໍ້ມູນ ໃນ ຫລາຍ field
            ->where(
                function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('price_buy', 'LIKE', "%{$search}%");
                    /* ->orWhere('price_buy' , 'LIKE', "%{$search}%"); */
                }
            )
            ->paginate($perpage)->toArray();
        return array_reverse($store);


        /*  $store =  Store::orderBy('id', 'asc')->get();
         return $store; */



    }

    public function add(Request $request)
    {
        try {
            //ເພີ່ມ new thead

            /*  return $request->file('image'); */
            $upload_path = "assets/img";
            if ($request->file('image')) {
                $generate_new_name_img = time() . "." . $request->image->getClientOriginalExtension();

                $request->image->move(public_path($upload_path), $generate_new_name_img);
            } else {
                $generate_new_name_img = '';
            }

            //ເພີ່ມຂໍ້ມູນໃນຕາຕະລາງ
            $store = new Store([
                'name' => $request->name,
                'image' => $generate_new_name_img,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]);

            $store->save();

            $product_id = $store->id; // ດຶງ id ທີບັນທຶກໄວ້ລ່າສຸດ

            //ບັນທຶກການຊື້ສິນຄ້າ
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



            $tran = new Transection([
                'tran_id' => "EXP" . $number,
                'tran_type' => "expense",
                'product_id' => $product_id,
                'amount' => $request->amount,
                'price' => $request->amount * $request->price_buy,
                'tran_detail' => "ຊື້ສິນຄ້າໃຫມ່ >" . $request->name,
            ]);
            $tran->save();
            //

            $success = true;
            $message = 'ບັນທຶກຂໍ້ມູນ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);


    }

    public function edit($id)
    {
        $store = Store::find($id);
        return $store;
    }


    public function update($id, Request $request)
    {
        try {


            $store = Store::find($id);
            $upload_path = "assets/img";
            if ($request->file('image')) {


                //ລົບຮູບພາບເກົ່າ
                if ($store->image) {
                    if (file_exists($upload_path . "/" . $store->image)) {
                        unlink($upload_path . "/" . $store->image);
                    }

                }


                $generate_new_name_img = time() . "." . $request->image->getClientOriginalExtension();

                $request->image->move(public_path($upload_path), $generate_new_name_img);



                $store->update([
                    'name' => $request->name,
                    'image' => $generate_new_name_img,
                    'amount' => $request->amount,
                    'price_buy' => $request->price_buy,
                    'price_sell' => $request->price_sell,
                ]);

            } else {
                if ($request->image) { //ກໍລະນີທີ່ບໍ່ມີການເປ໊ນເເປງຮູບພາບ
                    $store->update([
                        'name' => $request->name,
                        /*  'image' => $generate_new_name_img, */
                        'amount' => $request->amount,
                        'price_buy' => $request->price_buy,
                        'price_sell' => $request->price_sell,
                    ]);

                } else {
                    //ລົບຮູບພາບເກົ່າ
                    if ($store->image) {
                        if (file_exists($upload_path . "/" . $store->image)) {
                            unlink($upload_path . "/" . $store->image);
                        }

                    }
                    $store->update([
                        'name' => $request->name,
                        'image' => '',
                        'amount' => $request->amount,
                        'price_buy' => $request->price_buy,
                        'price_sell' => $request->price_sell,
                    ]);


                }
            }





            $success = true;
            $message = 'ອັບເດດ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);


    }

    public function delete($id)
    {
        try {

            $store = Store::find($id);
            $store->delete();


            $success = true;
            $message = 'ລົບຂໍ້ມູນ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }
}

