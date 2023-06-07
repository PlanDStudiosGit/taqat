<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\LaborHiringMail;
use App\Models\labor_hiring;
use App\Models\LaborModel;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class LaborHiringController extends Controller
{
    public function index(Request $request)
    {

        $input = $request->all();

        $labor_id = $input['labor_id'];
        $hiring_sponsor_id = $input['hiring_sponsor_id'];
        
        $labor_service = LaborModel::where('id', $labor_id)->select('occupation')->first();
        $laborservice = $labor_service->occupation;
        $oldsponsor = LaborModel::where('id', $labor_id)->select('user_id')->first();
        $olsponsor = $oldsponsor->user_id;
        $oldsponsor_first_name = User::where('id',$olsponsor)->first()->first_name;  
        $oldsponsor_last_name = User::where('id',$olsponsor)->first()->last_name;
        $oldsponsor_full_name = $oldsponsor_first_name .' '. $oldsponsor_last_name;  
        $oldsponsor_email = User::where('id',$olsponsor)->first()->email; 
        $hiring_sponsor_email = User::where('id',$hiring_sponsor_id)->first()->email;
        


        $labor_hiring = new labor_hiring;
        $labor_hiring->labor_id = $labor_id;
        $labor_hiring->sponsor_id = $olsponsor;
        $labor_hiring->service = $laborservice;
        $labor_hiring->hiring_sponsor_id = $hiring_sponsor_id;

        $request_check = labor_hiring::where('labor_id', $labor_id)
        ->where('hiring_sponsor_id',$hiring_sponsor_id)->first();

        $notification = new Notification;
        $notification->from_id = $hiring_sponsor_id;
        $notification->to_id = $olsponsor;
        $notification->labor_id = $labor_id;
        $notification->service_id = $laborservice;

        if ($request_check) {
            $response = [
                'success' => false,
                'message' => 'Request already sent',
            ];
            return response()->json($response);
        } else {

            if($hiring_sponsor_id == $olsponsor){
                $response = [
                    'success' => false,
                    'message' => 'You cannot hire your own labor',
                ]; 
                return response()->json($response);
            }

            $result = $labor_hiring->save();
            $notification->save();
            
            if ($result) {

                $sender=DB::table('notifications')->where('from_id',$hiring_sponsor_id)->first();
                $sender1=DB::table('users')->where('id',$sender->from_id)->first();
        
                $labor=DB::table('notifications')->where('labor_id',$labor_id)->first();
                $labor1=DB::table('labor_details')->where('id',$labor->labor_id)->first();
        
                $body = $sender1->name . " wants to hire your labor " . $labor1->fullname;
                // dd($body);

                // $sponsor_to = Notification::where();

                try {
                    $SERVER_API_KEY = 'AAAAFCuOrB4:APA91bFbLQqL9aDz2BsWD42NdqBbY6jmGtH9T7IIDX6t6bGl06cpg1Gb_agzrvw8dkr0i69Yw9jWYtgmmOvXw3W3NheHIphWDo2XEeDfxTqP15wJiYnZsJ9mTWANbT4La2bzpxQ6WRgc';


                    $body = [
                        "to" => "/topics/client_" . $olsponsor,
                        // "content_available" => true,
                        "notification" => [
                            "title" => 'New hire request',
                            "body" => $body,
                        ],
                    ];

                    $dataString = json_encode($body);

                    $headers = [
                        'Authorization: key=' . $SERVER_API_KEY,
                        'Content-Type: application/json',
                    ];
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                    curl_exec($ch);

                    // $response = curl_exec($ch);

                    $mailData = [
                        'sender_name' => $sender1->name,
                        'labor_name' => $labor1->fullname,
                        'oldsponsor' => $oldsponsor_full_name
                    ];

                    Mail::to($oldsponsor_email)->send(new LaborHiringMail($mailData,$hiring_sponsor_email));
                    // dd('email send successfully');

                    $response = [
                        'success' => true,
                        'message' => 'Request sent successfully',
                        'email' => 'Email Send successfully'
                    ]; 
                    return response()->json($response);
                } catch (\Exception $e) {
                    // \Log::info($e->getMessage());
                    return 'error';
                }

                $response = [
                    'success' => true,
                    'message' => 'request send successfully',
                ];
                return response()->json($response);
            } 
        }        
    }
}
