<?php

namespace App\Http\Controllers\Admin;

use App\Common\FileHandler;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insurance;
use Illuminate\Support\Facades\Validator;

class Insurance1Controller extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function tabledata(Request $request) {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        {
            $viewData = array(
                'pageName' => 'Add Insurance',
                'breadCrumbs' => array(
                    (object)array(
                        'name' => 'Dashboard',
                        'class' => '',
                        'url' => route('admin.dashboard')
                    ),
                    (object)array(
                        'name' => 'Menu',
                        'class' => '',
                        'url' => route('admin.menu.index')
                    ),
                    (object)array(
                        'name' => 'Add New Insurance',
                        'class' => 'active',
                        'url' => 'javascript:;'
                    )
                )
            );
            return view('admin.insurance1.addeditinsurance')->with($viewData);
    }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $insurance = Insurance::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Insurance',
            'insurance' => $insurance,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Update Insurance',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.insurance.addeditinsurance')->with($viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'section1_title1' => 'max:255',
            'section1_title2' => 'max:255',
            'section1_description' => 'max:255',
            'section1_image' => 'file|mimes:jpg,jpeg,png|max:1024',
            'section2_title' => 'max:255',
            'section2_description' =>  'max:255',
            'section2_buttontext' => 'max:255',
            'section3_title' => 'max:255',
            'section3_description' => 'max:255',
            'section3_image' =>'file|mimes:jpg,jpeg,png|max:1024',
            'section3_buttontext' => 'max:255',
            'section4_main_title' => 'max:255',
            'section4_1_image'=>'file|mimes:jpg,jpeg,png|max:1024',
            'section4_1_title' =>'max:255',
            'section4_1_decription'=>'max:255',
            'section4_1_buttontext'=>'max:255',
            'section4_2_image'=>'file|mimes:jpg,jpeg,png|max:1024',
            'section4_2_title'=>'max:255',
            'section4_2_decription'=>'max:255',
            'section4_2_buttontext'=>'max:255',
            'section4_3_image'=>'file|mimes:jpg,jpeg,png|max:1024',
            'section4_3_title'=>'max:255',
            'section4_3_decription'=>'max:255',
            'section4_3_buttontext' =>'max:255',
            'section4_4_image' =>'file|mimes:jpg,jpeg,png|max:1024',
            'section4_4_title'=>'max:255',
            'section4_4_decription'=>'max:255',
            'section4_4_buttontext'=>'max:255'
            
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.insurance.update", ['id' =>$id])->with('error', $validator->errors());
        }
        $insuranceData = $request->all();
        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = FileHandler::uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.insurance.create")->with('error', 'Something went wrong. Please try again');
                }
            }else {
                return Redirect()->route("admin.insurance.create")->with('error', 'Featured image is not valid');
            }
        }
      
        Insurance::where('id', $id)->update($insuranceData);
        return Redirect()->route("admin.insurance.update", ['id' =>$id])->with('success', 'Insurance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
