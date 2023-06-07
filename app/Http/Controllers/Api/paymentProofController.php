<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\labor_hiring;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class paymentProofController extends Controller
{
    public function index(Request $request)
    {

        $labor_hiring_id = $request->id;
        $validator = Validator::make($request->all(), [
            'payment_proof' => 'required | mime:png,jpg,jpeg,pdf'
        ]);


        if ($request->file('payment_proof')) {
            $payment_proof = $request->payment_proof;
            $payment_proof_original = $payment_proof->getClientOriginalName();
            $payment_proof_unique = time() . '_' . $payment_proof_original;
            $destinationaddr = public_path('/images/users/paymentProofs');
            $payment_proof->move($destinationaddr, $payment_proof_unique);
            $payment_proof_nospace = preg_replace('/\s+/', '', $payment_proof_unique);
        }

        // dd($payment_proof_nospace,$labor_hiring_id);


        // if ($validator->fails()) {
        //     $response = [
        //         'success' => 'validation error',
        //         'message' => $validator->errors()
        //     ];
        //     return response()->json($response);
        // } 
        // else {

        $result = labor_hiring::where('id', $labor_hiring_id)
            ->update([
                'payment_proof_doc' => $payment_proof_nospace
            ]);

        if ($result) {
            $response = [
                'success' => 'true',
                'message' => 'Document uploaded successfully',
                'payment_proof_doc' => $payment_proof_nospace
            ];
            return response()->json($response);
        } else {
            $response = [
                'success' => 'false',
                'message' => 'Something went wrong'
            ];
            return response()->json($response);
        }
        // }
    }
}
