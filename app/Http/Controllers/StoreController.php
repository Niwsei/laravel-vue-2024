<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Store;

class StoreController extends Controller
{
    //
    public function  __construct(){
        $this->middleware('auth:api'); //user ມີ Token ມາຫລືບໍ່
    }


    public function index(){
        $store =  Store::orderBy('id', 'asc')->get();
        return $store;

    }

    public function add(Request $request) {
        

            try {
    //ເພີ່ມ new thead
              $store = new Store([
                'name' => $request->name,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
              ]);

              $store->save();
              $success = true;
              $message =  'ບັນທຶກຂໍ້ມູນ ສຳເລັດ!';

                }   
     catch (\Illuminate\Database\QueryException $ex) {
    
                $success = false;
                $message = $ex->getMessage();
            }
    
            $response = [
                'success' => $success,
                'message' => $message
            ];
    
            return response()->json($response);
    
        
    }

    public function edit($id) {
            $store = Store::find($id);
            return $store;
    }


    public function update($id , Request $request) {



        try {
         
            $store = Store::find($id);
            $store->update([
                'name' => $request->name,
               /*  'name' => $request->name, */
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]);

                      $success = true;
                      $message =  'ອັບເດດ ສຳເລັດ!';
        
                        }   
             catch (\Illuminate\Database\QueryException $ex) {
            
                        $success = false;
                        $message = $ex->getMessage();
                    }
            
                    $response = [
                        'success' => $success,
                        'message' => $message
                    ];
            
                    return response()->json($response);
            
                
            }

            public function delete($id) {
                try {
         
                    $store = Store::find($id);
                    $store->delete();

                   
                              $success = true;
                              $message =  'ລົບຂໍ້ມູນ ສຳເລັດ!';
                
                                }   
                     catch (\Illuminate\Database\QueryException $ex) {
                    
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

