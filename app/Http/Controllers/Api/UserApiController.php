<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaborModel;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function index(){
       $user_id = auth('sanctum')->user()->id;
       $query = LaborModel::where('user_id',$user_id);
    //    $query->join('ourservices', 'labor_details.occupation', '=', 'ourservices.id');
       $labors = $query->get();
       $response = [
        "success" => true,
        "labors" => $labors
       ];
       return response()->json($response);

    }
}
