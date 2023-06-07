<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\HiringRequestAcceptedMail;
use App\Mail\InvoiceMail;
use App\Mail\LaborHiringMail;
use App\Models\invoiceDetailsModel;
use App\Models\invoiceModel;
use App\Models\labor_hiring;
use App\Models\LaborModel;
use App\Models\LaborTransferModel;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Facade\FlareClient\View;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public function index()
    {
        $id =  Auth::user()->id;
        // dd($id);

        $notification = DB::table('notifications')
            ->join('users as from_users', 'notifications.from_id', '=', 'from_users.id')
            ->join('users as to_users', 'notifications.to_id', '=', 'to_users.id')
            ->join('labor_details', 'notifications.labor_id', '=', 'labor_details.id')
            ->join('ourservices', 'notifications.service_id', '=', 'ourservices.id')
            // ->where('from_users.id', '=', $id)
            ->where('to_users.id', '=', $id)
            ->select('notifications.id', 'notifications.type', 'notifications.seen', 'notifications.created_at', 'to_users.name as to_name', 'from_users.name as from_name', 'labor_details.fullname', 'labor_details.labor_photo', 'ourservices.title')
            ->orderBy('id', 'DESC')
            ->get();


        $response = [
            'notification' => $notification,
        ];

        return response()->json($response);
    }

    public function update_notification_status(Request $request)
    {
        $id = $request->id;

        $query = DB::table('notifications')
            ->where('id', $id)
            ->update(['seen' => 'yes']);

        $response = [
            'status' => 'true',
            'message' => 'status updated'
        ];

        return response()->json($response);
    }

    public function clearnotification()
    {
        $id = Auth::user()->id;
        $sponsor = Notification::where('to_id', $id)->delete();

        $response = [
            'status' => 'true',
            'message' => 'Cleared notifications'
        ];

        return response()->json($response);
    }

    public function deletenotification(Request $request)
    {
        $id = $request->id;
        $notification = Notification::findorfail($id);
        // dd($notification);
        $notification->delete();

        $response = [
            'status' => 'true',
            'message' => 'Notification deleted successfully'
        ];

        return response()->json($response);
    }

    //////////////// REQUESTS ///////////////

    public function sentrequest()
    {

        $id =  Auth::user()->id;
        $from_notification = DB::table('labor_hirings')
            ->join('users as from_users', 'labor_hirings.hiring_sponsor_id', '=', 'from_users.id')
            ->join('labor_details', 'labor_hirings.labor_id', '=', 'labor_details.id')
            ->join('users as to_users', 'labor_hirings.sponsor_id', '=', 'to_users.id')
            ->join('ourservices', 'labor_hirings.service', '=', 'ourservices.id')
            ->where('from_users.id', '=', $id)
            ->select('to_users.first_name', 'to_users.last_name', 'labor_hirings.id', 'labor_hirings.created_at', 'labor_hirings.labor_status', 'labor_details.nationality', 'labor_details.labor_sponsorship_transfer_fee', 'labor_details.labor_photo', 'labor_details.fullname', 'ourservices.title')
            ->orderBy('labor_hirings.updated_at', 'DESC')
            ->get();

        $response = [
            'notification' => $from_notification,
        ];

        return response()->json($response);
    }


    public function recievedrequest()
    {
        $id =  Auth::user()->id;
        $to_notification = DB::table('labor_hirings')
            ->join('users as to_users', 'labor_hirings.sponsor_id', '=', 'to_users.id')
            ->join('users as from_users', 'labor_hirings.hiring_sponsor_id', '=', 'from_users.id')
            ->join('labor_details', 'labor_hirings.labor_id', '=', 'labor_details.id')
            ->join('ourservices', 'labor_hirings.service', '=', 'ourservices.id')
            ->where('to_users.id', '=', $id)
            ->select('from_users.first_name', 'from_users.last_name', 'labor_hirings.id', 'labor_details.nationality', 'labor_hirings.labor_status', 'labor_details.fullname', 'labor_details.labor_sponsorship_transfer_fee', 'labor_details.labor_photo', 'labor_hirings.created_at', 'ourservices.title')
            ->orderBy('labor_hirings.updated_at', 'DESC')
            ->get();

        $response = [
            'notification' => $to_notification,
        ];



        return response()->json($response);
    }

    public function updaterequest(Request $request)
    {


        $id = $request->id;
        $status = $request->status;


        $hiring_req = DB::table('labor_hirings')
            ->join('labor_details', 'labor_hirings.labor_id', '=', 'labor_details.id')
            ->join('ourservices', 'labor_details.occupation', '=', 'ourservices.id')
            ->select('labor_details.fullname','labor_details.labor_sponsorship_transfer_fee', 'ourservices.title', 'labor_hirings.hiring_sponsor_id')
            ->where('labor_hirings.id', $id)
            ->first();

        if ($hiring_req) {
            $labor_name = $hiring_req->fullname;
            $lb_service = $hiring_req->title;
            $sender_id = $hiring_req->hiring_sponsor_id;
        }

        $query = labor_hiring::where('id', $id)->update(['labor_status' => $status]);

        if ($status == '1') {

            $labor_check = DB::table('labor_hirings')
                ->where('id', $id)
                ->first();

            DB::table('labor_hirings')
                ->where('id', $id)
                ->update(['labor_status' => '1']);

            DB::table('labor_hirings')
                ->where('labor_status', '0')
                ->update(['labor_status' => '3']);

            $labor_id = $labor_check->labor_id;
            $labor_first_name = LaborModel::where('id', $labor_id)->first()->labor_first_name;
            $labor_last_name = LaborModel::where('id', $labor_id)->first()->labor_last_name;
            $labor_sponsorship_fee = LaborModel::where('id', $labor_id)->first()->labor_sponsorship_transfer_fee;

            $labor_full_name = $labor_first_name . ' ' . $labor_last_name;

            $sponsor_id = $labor_check->sponsor_id;
            $sponsor_first_name = User::where('id', $sponsor_id)->first()->first_name;
            $sponsor_last_name = User::where('id', $sponsor_id)->first()->last_name;
            $sponsor_full_name = $sponsor_first_name . ' ' . $sponsor_last_name;
            $sponsor_email = User::where('id', $sponsor_id)->first()->email;
            
            $from_user_id = $labor_check->hiring_sponsor_id;
            $hiring_sponsor_first_name = User::where('id', $from_user_id)->first()->first_name;
            $hiring_sponsor_last_name = User::where('id', $from_user_id)->first()->last_name;
            $hiring_sponsor__full_name = $hiring_sponsor_first_name . ' ' . $hiring_sponsor_last_name;
            $hiring_sponsor_email = User::where('id', $from_user_id)->first()->email;
            $hiring_sponsor_phone = User::where('id', $from_user_id)->first()->gsm_no;

            $service = $labor_check->service;
            
            $notification = new Notification;
            $notification->labor_id = $labor_id;
            $notification->from_id = $from_user_id;
            $notification->to_id = $sponsor_id;
            $notification->service_id = $service;
            $notification->type = 'accept';
            $notification->save();

            $body = 'Your request for ' . $labor_name . ' as ' . $lb_service . ' is accepted';
            $sender_id = $sender_id;
            
            try {
                $SERVER_API_KEY = 'AAAAFCuOrB4:APA91bFbLQqL9aDz2BsWD42NdqBbY6jmGtH9T7IIDX6t6bGl06cpg1Gb_agzrvw8dkr0i69Yw9jWYtgmmOvXw3W3NheHIphWDo2XEeDfxTqP15wJiYnZsJ9mTWANbT4La2bzpxQ6WRgc';
                
                $body = [
                    "to" => "/topics/client_" . $sender_id,
                    "notification" => [
                        "title" => 'Hire request accepted',
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
                
                
                ////  EMAIL SENDING WHEN REQUEST ACCEPTED  ////
                
                $mailData = [
                    'hiring_sponsor' => $hiring_sponsor__full_name,
                    'labor_name' => $labor_full_name,
                    'oldsponsor' => $sponsor_full_name
                ];


                // Mail::to($hiring_sponsor_email)->send(new HiringRequestAcceptedMail($mailData, $sponsor_email));


                $myinvoice = invoiceModel::first();
                $labor_sponsorship_fee = $labor_sponsorship_fee;
                $taqat_percent = Setting::first()->taqat_sponsorship_fee;
                $taqat_bank_name = Setting::first()->taqat_bank_name;
                $taqat_bank_account = Setting::first()->taqat_bank_account;
                $taqat_whatsapp = Setting::first()->taqat_whatsapp;
                $characters = 'ABCDEFGHI0123456789JKLMNOPQRSTUVWXYZ';
                $invoice_id = 'TLH' . '_' . Str::upper(Str::random(4));
                
                $invoiceData = [
                    'hiring_sponsor' => $hiring_sponsor__full_name,
                    'labor_name' => $labor_full_name,
                    'oldsponsor' => $sponsor_full_name,
                    'hiring_sponsor_email' => $hiring_sponsor_email,
                    'hiring_sponsor_phone' => $hiring_sponsor_phone,
                    'date' => Carbon::today()->format('m/d/Y'),
                    'labor_sponsorship_fee' => $labor_sponsorship_fee,
                    'taqat_percent' => $taqat_percent,
                    'taqat_bank_name' => $taqat_bank_name,
                    'taqat_bank_account' => $taqat_bank_account,
                    'taqat_whatsapp' => $taqat_whatsapp,
                    'invoice_number' => $invoice_id
                ];
  
                $total_amount = $invoiceData['labor_sponsorship_fee'] * ($invoiceData['taqat_percent'] / 100)+  $invoiceData['labor_sponsorship_fee'];
                $taqat_payment = $invoiceData['labor_sponsorship_fee'] * ($invoiceData['taqat_percent'] / 100);


                $pdfData['invoiceData'] = $invoiceData;

                $pdfpath = public_path('pdf/laborTransferInvoices');
                if (!file_exists($pdfpath)) {
                    mkdir($pdfpath, 0755, true);
                }
                $filePath = $pdfpath . '/' . $invoice_id.'.pdf';
                $pdf = Pdf::loadView('admin.user_invoice.user_invoice', $pdfData);
                $pdfContent = $pdf->output();
                file_put_contents($filePath, $pdfContent);

                // $pdfUrl = url('pdf/laborTransferInvoices/' . $invoice_id . '.pdf');
                $pdfUrl = $invoice_id . '.pdf';


                //  Mail::to($hiring_sponsor_email)->send(new InvoiceMail($invoiceData, $myinvoice,$pdfUrl));
                 Mail::to('saylikhan97@gmail.com')->send(new InvoiceMail($invoiceData, $myinvoice,$pdfUrl,$taqat_payment));  

                  $labor_transfer_inovice = new LaborTransferModel;
                $labor_transfer_inovice->invoice_id = $invoice_id;
                $labor_transfer_inovice->new_sponsor_id = $from_user_id;
                $labor_transfer_inovice->old_sponsor_id = $sponsor_id;
                $labor_transfer_inovice->labor_id = $labor_id;
                $labor_transfer_inovice->total_amount = $total_amount;
                $labor_transfer_inovice->taqat_payment = $taqat_payment;
                $labor_transfer_inovice->invoice_link = $pdfUrl;
                // $labor_transfer_inovice->invoice_date = $invoiceData['date'];
                // $labor_transfer_inovice->paid_date = $invoiceData['hiring_sponsor'];
                // $labor_transfer_inovice->invoice_proof = $invoiceData['hiring_sponsor'];
                $labor_transfer_inovice->save();
                

                ////  INVOICE MAIL HIRING SPONSOR END ////

                $response = [
                    'status' => 'true',
                    'message' => 'Request accepted',
                    'email' => $labor_first_name . ' ' . $labor_last_name
                ];
                return response()->json($response);
                // return $response;
            } catch (\Exception $e) {
                // \Log::info($e->getMessage());
                return $e;
            }
        }

        if ($status == '2') {

            $labor_check = DB::table('labor_hirings')
                ->where('id', $id)
                ->first();

            $labor_id = $labor_check->labor_id;
            $sponsor_id = $labor_check->hiring_sponsor_id;
            $to_user_id = $labor_check->sponsor_id;
            $service = $labor_check->service;

            // dd($labor_id, $sponsor_id);  

            $query = DB::table('labor_hirings')
                ->where('id', $id)
                ->update(['labor_status' => '2']);

            $notification = new Notification;
            $notification->labor_id = $labor_id;
            $notification->from_id = $to_user_id;
            $notification->to_id = $sponsor_id;
            $notification->service_id = $service;
            $notification->type = 'cancel';
            $notification->save();

            $body = 'Your request for ' . $labor_name . ' as ' . $lb_service . ' is rejected';
            $sender_id = $sender_id;

            try {
                $SERVER_API_KEY = 'AAAAFCuOrB4:APA91bFbLQqL9aDz2BsWD42NdqBbY6jmGtH9T7IIDX6t6bGl06cpg1Gb_agzrvw8dkr0i69Yw9jWYtgmmOvXw3W3NheHIphWDo2XEeDfxTqP15wJiYnZsJ9mTWANbT4La2bzpxQ6WRgc';

                $body = [
                    "to" => "/topics/client_" . $sender_id,
                    "notification" => [
                        "title" => 'Hire request rejected',
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
                $response = [
                    'status' => 'true',
                    'message' => 'Request rejected'
                ];
                return response()->json($response);
                // return $response;
            } catch (\Exception $e) {
                // \Log::info($e->getMessage());
                return 'error';
            }
        }
    }

    public function unreadNotification()
    {
        $to_id = Auth::user()->id;
        $unreadNotifications = Notification::where('seen', 'no')->where('to_id', $to_id)->count();
        $response = [
            "success" => 'true',
            "count" => $unreadNotifications
        ];
        return response()->json($response);
    }


    public function labor_user_detail(Request $request)
    {
        $id = $request->id;
        $labor_hirings = DB::table('labor_hirings')->where('id', $id)->first();
        $labor_hirings_proof_doc = DB::table('labor_hirings')->where('id', $id)->first()->payment_proof_doc;
        $labor_hirings_payment_status = DB::table('labor_hirings')->where('id', $id)->first()->payment_status;

        $labor_detail = DB::table('labor_details')->where('id', $labor_hirings->labor_id)->first();
        $user_detail = DB::table('users')->where('id', $labor_hirings->hiring_sponsor_id)->first();


        $response = [
            "success" => 'true',
            "labor" => $labor_detail,
            "user_detail" => $user_detail,
            "payment_proof_doc" => $labor_hirings_proof_doc,
            "payment_status" => $labor_hirings_payment_status

        ];
        return response()->json($response);
    }

    public function userinvoice(){
        return view('admin.user_invoice.user_invoice');
    }

 
}
