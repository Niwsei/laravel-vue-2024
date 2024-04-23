<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transection;

class ReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api'); //user ມີ Token ມາຫລືບໍ່
    }


        public function created_report(Request $request){

            $month_type = $request->month_type;
            $dmy = $request->dmy;
    
            $m = explode("-", $dmy)[1];
            $y = explode("-", $dmy)[0];

            $sum_income = 0;
            $sum_expense = 0;

            $labels = [];
            $income = [];
            $expense = [];


            if ($month_type == "m") {
                #ຊອກຫາວິນທີສຸດທ້າຍຂອງເດືອນ
                $last_day = date("t" , strtotime($dmy));
                for ($i = 1 ; $i <= $last_day ; $i++){
                    array_push($labels , "ວັນທີ" .$i);
                }
               /*  return $labels; */

               // ບວກລາຍຮັບທັງຫມົດ
                $sum_income = Transection::whereMonth("created_at" , $m)
                ->whereYear("created_at" , $y)
                ->where("tran_type" , "income")
                ->sum("price");
                //ເພີ່ມລາຍການລາຍຮັບ
                for ($i = 1 ; $i <= $last_day ; $i++){
                    array_push($labels , "ວັນທີ" .$i);
                    $inc = Transection::whereMonth("created_at" , $m)
                    ->whereYear("created_at" , $y)
                    ->whereDay("created_at" , $i)
                    ->where("tran_type" , "income")
                    ->sum("price");

                    array_push($income , $inc);
                }

                 // ບວກລາຍ...ທັງຫມົດ
                 $sum_expense = Transection::whereMonth("created_at" , $m)
                 ->whereYear("created_at" , $y)
                 ->where("tran_type" , "expense")
                 ->sum("price");
                 //ເພີ່ມລາຍການລາຍຮັບ
                 for ($i = 1 ; $i <= $last_day ; $i++){
               /*       array_push($labels , "ວັນທີ" .$i); */
                     $exp = Transection::whereMonth("created_at" , $m)
                     ->whereYear("created_at" , $y)
                     ->whereDay("created_at" , $i)
                     ->where("tran_type" , "expense")
                     ->sum("price");
 
                     array_push($expense , $exp);
                 }

           
            } else if ($month_type == "y") {
                
    #ຊອກຫາວິນທີສຸດທ້າຍຂອງເດືອນ
 $last_day = date("t" , strtotime($dmy));
 for ($i = 1 ; $i <= 12 ; $i++){
     array_push($labels , "ເດືອນ" .$i);
 }
/*  return $labels; */

// ບວກລາຍຮັບທັງຫມົດ
 $sum_income = Transection::whereYear("created_at" , $y)
 ->where("tran_type" , "income")
 ->sum("price");
 //ເພີ່ມລາຍການລາຍຮັບ
 for ($i = 1 ; $i <= $last_day ; $i++){
 /*     array_push($labels , "ວັນທີ" .$i); */
     $inc = Transection::whereYear("created_at" , $y)
     ->whereDay("created_at" , $i)
     ->where("tran_type" , "income")
     ->sum("price");
     array_push($income , $inc);
 }

  // ບວກລາຍ...ທັງຫມົດ
  $sum_expense = Transection::whereYear("created_at" , $y)
  ->where("tran_type" , "expense")
  ->sum("price");
  //ເພີ່ມລາຍການລາຍຮັບ
  for ($i = 1 ; $i <= $last_day ; $i++){
 /*      array_push($labels , "ວັນທີ" .$i); */
      $exp = Transection::whereYear("created_at" , $y)
      ->whereDay("created_at" , $i)
      ->where("tran_type" , "expense")
      ->sum("price");

      array_push($expense , $exp);
  }
                
        
            }

            $response = [
                "labels" => $labels,
                "income" => $income,
                "expense"  => $expense,
                "sum_income" => $sum_income,
                "sum_expense" => $sum_expense
            ];

            return response()->json($response);
        }
    }


 