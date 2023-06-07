<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function minSalary(){
        $min_salary = Setting::first()->min_salary;

        $response = [
            'success' => true,
            'min_salary' => $min_salary
        ];

        return response()->json($response);
    }
}
