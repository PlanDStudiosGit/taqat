<?php

namespace App\Http\Controllers\Admin;

use App\Common\FileHandler;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use App\Models\LaborModel;
use App\Models\services;
use Illuminate\Support\Facades\DB;

class SearchLaborController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = services::get();
        $labor = LaborModel::get();
        $viewData = array(
            'pageName' => 'Search Labor',
            'services' => $services,
            'labor' => $labor,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'search-labor',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.search-labor.search-labor')->with($viewData);
    }

    public function search(Request $request)
    {
        $pass_no = $request->pass_no;
        $service = $request->service;
        $nationality = $request->nationality;
        $religion = $request->religion;
        $job_type = $request->job_type;
        

        

        $labors = LaborModel::where('nationality', $nationality)
        ->orWhere('passport_no', $pass_no)
            ->orWhere('religion', $religion)
            ->orWhere('job_type', $job_type)->get();

       
        $services = services::get();

        $labor = LaborModel::get();


        $viewData = array(
            'pageName' => 'Search Labor',
            'services' => $services,
            'labor' => $labor,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'search-labor',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.search-labor.search-labor', compact('labors'))->with($viewData, $labors);
    }
}
