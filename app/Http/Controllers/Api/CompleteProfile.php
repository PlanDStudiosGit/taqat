<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CompleteProfile extends Controller
{
    public function fandlname(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            // 'last_name' => 'required'
        ]);

        if ($validator->fails()) {

            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        } else {

            $input = $request->all();
            $id = Auth::user()->id;

            $first_name = $input['first_name'];
            $last_name = $input['last_name'];


            $profile_status =  DB::table('users')->where('id', $id)->value('profile_status');
            if ($profile_status < 1) {
                $profile_status = 1;
            }

            $fullname = $first_name . ' ' . $last_name;
            DB::table('users')
                ->where('id', $id)
                ->update(['first_name' => $first_name, 'first_name' => $first_name, 'last_name' => $last_name, 'profile_status' => $profile_status]);

            $newuser = User::findOrFail($id);
            $response = [
                'success' => true,
                'user' => $newuser,
            ];

            return response()->json($response, 200);
        }
    }

    ////////////////////////////////////  GSM AND ID  ///////////////////////////////////

    public function gsmandid(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'country_code' => 'required',
            'id_number' => 'required'
        ]);

        if ($validator->fails()) {

            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        } else {

            $input = $request->all();
            $id = Auth::user()->id;

            $phone_number = $input['phone_number'];
            $id_number = $input['id_number'];
            $country_code = $input['country_code'];

            // dd($input);

            $profile_status =  DB::table('users')->where('id', $id)->value('profile_status');
            if ($profile_status < 2) {
                $profile_status = 2;
            }

            DB::table('users')
                ->where('id', $id)
                ->update(['gsm_no' => $phone_number, 'countrycode' => $country_code, 'id_no' => $id_number, 'profile_status' => $profile_status]);

            $newuser = User::findOrFail($id);
            $response = [
                'success' => true,
                'user' => $newuser,
            ];

            return response()->json($response, 200);
        }
    }


    public function docs(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'id_card_front' => 'required',
            // 'id_card_back' => 'required'
        ]);

        if ($validator->fails()) {

            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        } else {

            $input = $request->all();

            
            //
            
            $id = Auth::user()->id;
            $user = User::find($id);

            if ($request->file('sponsor_id')) {
                $sponsor_id = $input['sponsor_id'];
                $sponsor_id_original = $sponsor_id->getClientOriginalName();
                $sponsor_id_unique = time() . '_' . $sponsor_id_original;
                $destinationsponsorid = public_path('/images/users/user_sponsor_id');
                $sponsor_id->move($destinationsponsorid, $sponsor_id_unique);
                $sponsor_id_nospace = preg_replace('/\s+/', '', $sponsor_id_unique);
                $user->sponsor_id = $sponsor_id_nospace;
            }

            if ($request->file('salary_certificate')) {
                $salary_certificate = $input['salary_certificate'];
                $salary_certificate_original = $salary_certificate->getClientOriginalName();
                $salary_certificate_unique = time() . '_' . $salary_certificate_original;
                $destinationsal = public_path('/images/users/user_salary_certificate');
                $salary_certificate->move($destinationsal, $salary_certificate_unique);
                $salary_certificate_nospace = preg_replace('/\s+/', '', $salary_certificate_unique);
                $user->salary_certificate = $salary_certificate_nospace;
            }

            if ($request->file('marriage_certificate')) {
                $marriage_certificate = $input['marriage_certificate'];
                $marriage_certificate_original = $marriage_certificate->getClientOriginalName();
                $marriage_certificate_unique = time() . '_' . $marriage_certificate_original;
                $destinationmarr = public_path('/images/users/user_marriage_certificate');
                $marriage_certificate->move($destinationmarr, $marriage_certificate_unique);
                $marriage_certificate_nospace = preg_replace('/\s+/', '', $marriage_certificate_unique);
                $user->marriage_certificate = $marriage_certificate_nospace;
            }

            // $profile_status =  DB::table('users')->where('id', $id)->value('profile_status');
            $profile_status = 3;
            $user->profile_status = $profile_status;

            $user->save();

            // DB::table('users')
            // ->where('id', $id)
            // ->update(['sponsor_id' => $sponsor_id_nospace,'salary_certificate' => $salary_certificate_nospace,'marriage_certificate' => $marriage_certificate_nospace, 'profile_status' => $profile_status]);

            $newuser = User::findOrFail($id);
            $response = [
                'success' => true,
                'user' => $newuser,
            ];

            return response()->json($response, 200);
        }
    }

    public function docsRequired(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'salary_certificate' => 'required',
            'marriage_certificate' => 'required'
        ]);

        if ($validator->fails()) {

            $response = [
                'success' => false,
                'message' => $validator->errors()->first()
            ];
            return response()->json($response, 400);
        } else {
            $input = $request->all();
            $id = Auth::user()->id;
            $user = User::find($id);


            if ($request->file('salary_certificate')) {
                $salary_certificate = $input['salary_certificate'];
                $salary_certificate_original = $salary_certificate->getClientOriginalName();
                $salary_certificate_unique = time() . '_' . $salary_certificate_original;
                $destinationsal = public_path('/images/users/user_salary_certificate');
                $salary_certificate->move($destinationsal, $salary_certificate_unique);
                $salary_certificate_nospace = preg_replace('/\s+/', '', $salary_certificate_unique);
                $user->salary_certificate = $salary_certificate_nospace;
            }

            if ($request->file('marriage_certificate')) {
                $marriage_certificate = $input['marriage_certificate'];
                $marriage_certificate_original = $marriage_certificate->getClientOriginalName();
                $marriage_certificate_unique = time() . '_' . $marriage_certificate_original;
                $destinationmarr = public_path('/images/users/user_marriage_certificate');
                $marriage_certificate->move($destinationmarr, $marriage_certificate_unique);
                $marriage_certificate_nospace = preg_replace('/\s+/', '', $marriage_certificate_unique);
                $user->marriage_certificate = $marriage_certificate_nospace;
            }

            // $profile_status =  DB::table('users')->where('id', $id)->value('profile_status');
            $profile_status = 3;
            $user->profile_status = $profile_status;

            $user->save();

            $newuser = User::findOrFail($id);
            $response = [
                'success' => true,
                'user' => $newuser,
            ];

            return response()->json($response, 200);
        }
    }

    public function onlysponsorid(Request $request,$id)
    {

        // dd($request->sponsor_id);
        // die;
        $validator = Validator::make($request->all(), [
            'sponsor_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        } else {

            $input = $request->all();
            $id = Auth::user()->id;
            $user = User::find($id);

            if ($request->file('sponsor_id')) {
                $sponsor_id = $input['sponsor_id'];
                $sponsor_id_original = $sponsor_id->getClientOriginalName();
                $sponsor_id_unique = time() . '_' . $sponsor_id_original;
                $destinationsponsorid = public_path('/images/users/user_sponsor_id');
                $sponsor_id->move($destinationsponsorid, $sponsor_id_unique);
                $sponsor_id_nospace = preg_replace('/\s+/', '', $sponsor_id_unique);
                $user->sponsor_id = $sponsor_id_nospace;
            }

            
            $user->save();

            $newuser = User::findOrFail($id);
            $response = [
                'success' => true,
                'user' => $newuser,
            ];

            return response()->json($response, 200);
        }
    }
}
