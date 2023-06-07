<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaborModel;
use App\Models\User;
use App\Models\services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class LaborApiController extends Controller
{
    public function laborone(Request $request, $id = null)
    {

        if (!$id == null) { {
                $labor_id = $id;
                $input = $request->all();

                if ($request->has('labor_photo')) {
                    $labor_photo = $input['labor_photo'];
                    // dd($labor_photo);
                    $labor_photo_original = $labor_photo->getClientOriginalName();
                    $labor_photo_unique = time() . '_' . $labor_photo_original;
                    $destinationPath = public_path('/images/labors/labors_profile_photo');
                    $labor_photo_nospace = preg_replace('/\s+/', '', $labor_photo_unique);
                    $labor_photo->move($destinationPath, $labor_photo_nospace);

                }
                $labor_first_name = $input['first_name'];
                $labor_last_name = $input['last_name'];
                $fullname = $labor_first_name . ' ' . $labor_last_name;
                $labor_passport_no = $input['passport_no'];
                $labor_nationality = $input['nationality'];
                $labor_religion = $input['religion'];


                // $labor_photo = $input['id_card_front'];


                // if (LaborModel::where('passport_no', $labor_passport_no)->exists()) {
                //     $response = [
                //         'success' => false,
                //         'message' => "passport number already exist",
                //     ];

                //     return response()->json($response);
                // } else {

                $user_id = Auth('sanctum')->user()->id;
                DB::table('labor_details')
                    ->where('id', $labor_id)
                    ->update(['labor_first_name' => $labor_first_name, 'labor_last_name' => $labor_last_name, 'fullname' => $fullname, 'labor_photo' => $labor_photo_nospace, 'passport_no' => $labor_passport_no, 'nationality' => $labor_nationality, 'religion' => $labor_religion, 'user_id' => $user_id]);

                $labor = LaborModel::findOrFail($labor_id);

                $response = [
                    'success' => true,
                    'labor' => $labor,

                ];

                return response()->json($response);
                // }
            }
        } else {
            $validator = Validator::make($request->all(), [
                'labor_photo' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'passport_no' => 'required',
                'nationality' => 'required',
                'religion' => 'required'
            ]);

            if ($validator->fails()) {

                $response = [
                    'success' => false,
                    'message' => $validator->errors()
                ];
                return response()->json($response, 400);
            } else {
                $input = $request->all();
                $labor = new LaborModel;

                $labor_photo = $input['labor_photo'];
                $labor_first_name = $input['first_name'];
                $labor_last_name = $input['last_name'];
                $fullname = $labor_first_name . ' ' . $labor_last_name;
                $labor_passport_no = $input['passport_no'];
                $labor_nationality = $input['nationality'];
                $labor_religion = $input['religion'];

                // $labor_profile_status =  DB::table('labor_details')->where('id', $id)->value('labor_profile_status');

                $labor_profile_status = 1;
                if ($labor_profile_status < 1) {
                    $labor_profile_status = 1;
                }
                // $labor_photo = $input['id_card_front'];
                $labor_photo_original = $labor_photo->getClientOriginalName();
                $labor_photo_unique = time() . '_' . $labor_photo_original;
                $destinationPath = public_path('/images/labors/labors_profile_photo');
                $labor_photo->move($destinationPath, $labor_photo_unique);

                $labor_photo_nospace = preg_replace('/\s+/', '', $labor_photo_unique);

                $labor->labor_photo = $labor_photo_nospace;
                $labor->labor_first_name = $labor_first_name;
                $labor->labor_last_name = $labor_last_name;
                $labor->fullname = $fullname;
                $labor->passport_no = $labor_passport_no;

                if (LaborModel::where('passport_no', $labor_passport_no)->exists()) {
                    $response = [
                        'success' => false,
                        'message' => "passport number already exist",

                    ];

                    return response()->json($response);
                } else {

                    $labor->nationality = $labor_nationality;
                    $labor->religion = $labor_religion;
                    $labor->labor_profile_status = $labor_profile_status;

                    $user_id = Auth('sanctum')->user()->id;
                    $labor->user_id = $user_id;

                    $labor->save();

                    $response = [
                        'success' => true,
                        'labor' => $labor,

                    ];

                    return response()->json($response);
                }
            }
        }
    }

    //////////////////////////////// LABOR TWO //////////////////

    public function labortwo(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'gender' => 'required',
            'experience' => 'required',
            'dob' => 'required',

        ]);

        if ($validator->fails()) {

            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        } else {
            $input = $request->all();

            $gender = $input['gender'];
            $experience = $input['experience'];
            $dob = $input['dob'];

            $profile_status =  DB::table('labor_details')->where('id', $id)->value('labor_profile_status');
            if ($profile_status < 2) {
                $profile_status = 2;
            }

            DB::table('labor_details')
                ->where('id', $id)
                ->update(['gender' => $gender, 'experience' => $experience, 'dob' => $dob, 'labor_profile_status' => $profile_status]);


            $newulabor = LaborModel::findOrFail($id);

            $response = [
                'success' => true,
                'labor' => $newulabor,

            ];

            return response()->json($response);
        }
    }



    ////////////////////////////////  laborthree //////////////////

    public function laborthree(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'monthly_salary' => 'required',
            'location' => 'required',
            'occupation' => 'required',
            'marital_status' => 'required',

        ]);

        if ($validator->fails()) {

            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        } else {
            $input = $request->all();

            $monthly_salary = $input['monthly_salary'];
            $location = $input['location'];
            $occupation = $input['occupation'];
            $marital_status = $input['marital_status'];

            $profile_status =  DB::table('labor_details')->where('id', $id)->value('labor_profile_status');
            if ($profile_status < 3) {
                $profile_status = 3;
            }



            DB::table('labor_details')
                ->where('id', $id)
                ->update(['monthly_salary' => $monthly_salary, 'location' => $location, 'occupation' => $occupation, 'marital_status' => $marital_status, 'labor_profile_status' => $profile_status]);


            $newulabor = LaborModel::findOrFail($id);

            $response = [
                'success' => true,
                'labor' => $newulabor,

            ];

            return response()->json($response);
        }
    }


    ////////////////////////////////  laborfour //////////////////

    public function laborfour(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'couple_worker' => 'required',
            'app_type' => 'required',
            'education' => 'required',
            'job_type' => 'required',
            'labor_sponsor_transfer_fee' => 'required',

        ]);

        if ($validator->fails()) {

            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        } else {
            $input = $request->all();

            $couple_worker = $input['couple_worker'];
            $app_type = $input['app_type'];
            $education = $input['education'];
            $job_type = $input['job_type'];
            $labor_sponsor_transfer_fee = $input['labor_sponsor_transfer_fee'];

            $profile_status =  DB::table('labor_details')->where('id', $id)->value('labor_profile_status');
            if ($profile_status < 4) {
                $profile_status = 4;
            }



            DB::table('labor_details')
                ->where('id', $id)
                ->update(['couple_worker' => $couple_worker, 'application_type' => $app_type, 'education' => $education, 'job_type' => $job_type, 'labor_sponsorship_transfer_fee' => $labor_sponsor_transfer_fee, 'labor_profile_status' => $profile_status]);


            $newulabor = LaborModel::findOrFail($id);

            $response = [
                'success' => true,
                'labor' => $newulabor,

            ];

            return response()->json($response);
        }
    }


    /////////// SEARCH ////////////
    public function search(Request $request)
    {

        $name = strtolower($request->fullname);
        $gender = strtolower($request->gender);
        // $labor_hiring_fees = strtolower($request->labor_hiring_fees);
        $occupation = strtolower($request->occupation);
        $nationality = strtolower($request->nationality);
        $most_recent = strtolower($request->recent);
        $start = $request->start;
        $end = $request->end;
        $min = $request->min;
        $max = $request->max;
        $range = [$min, $max];

        if ($min == "" && $max == "") {
            $range = "";
        }

        try {
            $query = DB::table('labor_details');
            $query->select('labor_details.*', 'ourservices.title');
            $query->join('ourservices', 'labor_details.occupation', '=', 'ourservices.id');

            $query->when($name, function ($q, $name) {
                $q->where('fullname', 'LIKE', '%' . $name . '%');
            })->when($gender, function ($q, $gender) {
                $q->where('gender', $gender);
            })->when($nationality, function ($q, $nationality) {
                $q->where('nationality', $nationality);
            })->when($most_recent, function ($q, $most_recent) {
                $q->orderBy('labor_details.id', $most_recent);
            })->when($occupation, function ($q, $occupation) {
                $q->where('ourservices.id', $occupation);
            })->when($range, function ($q, $range) {
                $q->whereBetween('labor_sponsorship_transfer_fee', [$range[0], $range[1]]);
            });

            $query->skip($start)->take($end);
            // dd($name, $query->toSql());  


            // dd($name, $query->toSql());
            $labors = $query->get();
        } catch (\Exception $e) {
            // Handle the exception here, e.g. log the error, return an error response, etc.
            // For example, you can log the error using Laravel's log helper:
            Log::error('Error executing query: ' . $e->getMessage());
            // You can also return an error response to the client:
            return response()->json(['error' => 'Error executing query: ' . $e->getMessage()], 500);
        }

        // dd($name, $query->toSql());

        if (count($labors) > 0) {

            $response = [
                'success' => true,
                'labors' => $labors
            ];
            return response()->json($response);
        } else {
            $response = [
                'success' => false,
                'message' => "No Record Found",
            ];

            return response()->json($response);
        }
    }
    ////////////END SEARCH /////////// 

    public function services()
    {
        // $service = services::find($id)->get();
        $services = services::get();
        $response = [
            'success' => true,
            'services' => $services,
        ];
        return response()->json($response);
    }

    public function minmax()
    {
        $min = DB::table('labor_details')->min('labor_sponsorship_transfer_fee');
        $max = DB::table('labor_details')->max('labor_sponsorship_transfer_fee');

        // dd('min = '.$min,'max = ' .$max);

        $response = [
            'success' => true,
            'min' => $min,
            'max' => $max
        ];

        return response()->json($response);
    }
}


 // $query = LaborModel::query();
        // if ($name != '') {
        //     $query->where('fullname', 'like', '%' . $name . '%');
        // }
        // if ($gender != '') {
        //     $query->where('gender', $gender);
        // }
        // if ($labor_hiring_fees != '') {
        //     $query->where('monthly_salary', $labor_hiring_fees);
        // }
        // if ($nationality != '') {
        //     $query->where('nationality', $nationality);
        // }
        // if ($occupation != '') {
        //     $query->where('occupation', $occupation);
        // }

        // dd($name,$gender,$labor_hiring_fees,$nationality,$occupation, $query->toSql());

        // $user = $query->get();
        // return $user;

        // $query = LaborModel::query();
        // $query->when($name, function ($query, $name) {
        //     $query->where('fullname', 'LIKE', '%' . $name . '%');
        // })
        //     ->when($labor_hiring_fees, function ($query, $labor_sponsorship_transfer_fee) {
        //         $query->where('labor_sponsorship_transfer_fee', '=', $labor_sponsorship_transfer_fee);
        //     })
        //     ->when($gender, function ($query, $gender) {
        //         $query->where('gender', $gender);
        //     })
        //     ->when($nationality, function ($query, $nationality) {
        //         $query->where('nationality', $nationality);
        //     })
        //     ->when($occupation, function ($query, $occupation) {
        //         $query->where('occupation', $occupation);
        //     });