<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaborModel;
use Illuminate\Http\Request;
use App\Models\labor_hiring;

class DashboardApi extends Controller
{
    public function index(){
       $user = Auth('sanctum')->user();
       $labors_added = LaborModel::where('user_id',$user->id)->count();
       $hire_count = labor_hiring::where('hiring_sponsor_id',$user->id)->count();

        $response = [
            'success' => true,
            'labors_added' => $labors_added,
            'user' => $user,
	    'hire_count' => $hire_count
        ];

        return response()->json($response);
    }
}
