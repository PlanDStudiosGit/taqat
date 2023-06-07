<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{


    public function test()
    {
        return Auth::user();
    }



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'username' => 'required',
            'email' => 'required',
            'password' => 'required'

        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        } else {

            $input = $request->all();
            $username = $input['username'];
            $email = $input['email'];

            $usernameexist = User::where('name', '=', $username)->count();
            $useremailexist = User::where('email', '=', $email)->count();

            if ($usernameexist > 0) {
                $response = [
                    'success' => false,
                    'name' => $username,
                    'message' => 'username already exist',
                ];

                return response()->json($response, 400);
            } else {
                if ($useremailexist > 0) {
                    $response = [
                        'success' => false,
                        'name' => $username,
                        'message' => 'email already exist',
                    ];

                    return response()->json($response, 400);
                } else {

                    // $input['password'] = bcrypt($input['password']);
                    $user = new User;
                    $user->name = $username;
                    $user->email = $email;
                    $user->password = bcrypt($input['password']);;
                    $user->save();

                    $token = $user->createToken('auth_token')->plainTextToken;
                    $name = $request->username;


                    $response = [
                        'success' => true,
                        'access_token' => $token,
                        'name' => $name,
                        'message' => 'user register successfully',
                    ];

                    return response()->json($response, 200);
                }
            }




        }
    }


  public function login(Request $request)
    {
        // return $_POST;exit;
        $validator = Validator::make($request->all(), [

            // 'username' => 'required',
            'in' => 'required',
            'password' => 'required'

        ]);

        // $input = $request->all();

        $in = $request->in;
        $password = $request->password;

        // return $validator->errors();
        // exit;

        // $user = Auth::user();





        if (Auth::attempt(['email' => $in, 'password' => $password]) || Auth::attempt(['name' => $in, 'password' => $password])) {

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            // $email = $request->email;

            $response = [
                'success' => true,
                'token' => $token,
                'user' => $user,
                'message' => 'user login successfully',
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Sorry, we cannot find an account with those credentials. Please check your credentials and try again',
                
            ];
            return response()->json($response, 400);
        }
    }


}
