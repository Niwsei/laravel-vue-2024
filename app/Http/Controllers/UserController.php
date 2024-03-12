<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use JWTAuth;


class UserController extends Controller
{
    //

    public function  __construct(){
        $this->middleware('auth:api' , ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {

        try {

            // ກວດສອບອີເມລ ບ່ໃຫ້ຊ້ຳກັນ

            $check_email = User::where('email' , $request->from_email);

            if($check_email->count()){
                $success = false;
                $message = 'ອິເມລນີ້:'. $request->from_email . 'ໄດ້ຖຶກລົງທະບຽນເເລ້ວ!'; 
            }
            else {
                
            $user = new User([
                'name' => $request->from_user_name,
                'email' => $request->from_email,
                'password' => hash::make($request->from_password)
            ]);

            $user->save();
            $success = true;
            $message = 'ບັນທຶກສຳເລັດ!';

            }


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

    public function login(Request $request) {
            $user_login = [
                'email' => $request->login_email,
                'password' => $request->login_password
            ];

            $token = JWTAUTH::attempt($user_login); //ກວດສອບ email , password ເເລ້ວສ້າງ token ຂຶ້ນມາ
            $user = Auth::user(); /*  ຫລັງຈາກ login ສຳເລັດເເມ່ນ ດຶງຂໍ້ມູນ User ທີ່  login ອອກມາ */

            if($token) {
                return response()->json([
                    'success' => true,
                    'message' => 'ສຳເລັດ!',
                    'user' => $user,
                    'token' => $token
                ]);
            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => 'ອີເມລ ຫຼື ລະຫັດຜ່ານບໍ່ຖຶກຕ້ອງ!',

                ]);
            }
    }

    public function logout() {
        $token = JWTAuth::getToken();
        $invalidate = JWTAuth::invalidate($token);

        if($invalidate){
            return response()->json([
                'success' => true,
                'message' => 'ສຳເລັດ!',
            ]);
        }
    }
}
