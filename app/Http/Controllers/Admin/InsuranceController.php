<?php

namespace App\Http\Controllers\Admin;

use App\Common\FileHandler;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insurance;
use App\Models\download;
use App\Models\FAQ;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Validator;

class InsuranceController extends Controller {
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
        // echo "<pre>";
        // print_r($id);
        // echo "</pre>";

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
        $insurance = Insurance::findOrFail($id);
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
            return redirect()->to("admin.insurance.edit", ['id' => $insurance->id])->with('error', $validator->errors());
        }

        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = $this->uploadImage($file);
                if(!$featuredImage) {
                    return redirect()->to("admin.insurance.edit", ['id' => $insurance->id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $insurance->featured_image = $featuredImage;
                }
            }else {
                return Redirect()->route("admin.insurance.update", ['id' => $id])->with('error', 'Featured image is not valid');
            }
        }
       
        $insurance->section1_title1=$request->section1_title1;
        $insurance->section1_title2=$request->section1_title2;
        $insurance->section1_description=$request->section1_description;
        $insurance->section1_image=$request->section1_image;
        $insurance->section2_title=$request->section2_title;
        $insurance->section2_description=$request->section2_description;
        $insurance->section2_buttontext=$request->section2_buttontext;
        $insurance->section3_title=$request->section3_title;
        $insurance->section3_description=$request->section3_description;
        $insurance->section3_image=$request->section3_image;
        $insurance->section3_buttontext=$request->section3_buttontext;
        $insurance->section4_main_title=$request->section4_main_title;
        $insurance->section4_1_title=$request->section4_1_title;
        $insurance->section4_1_decription=$request->section4_1_decription;
        $insurance->section4_1_buttontext=$request->section4_1_buttontext;
        $insurance->section4_2_image=$request->section4_2_image;
        $insurance->section4_2_title=$request->section4_2_title;
        $insurance->section4_2_decription=$request->section4_2_decription;
        $insurance->section4_2_buttontext=$request->section4_2_buttontext;
        $insurance->section4_3_image=$request->section4_3_image;
        $insurance->section4_3_title=$request->section4_3_title;
        $insurance->section4_3_decription=$request->section4_3_decription;
        $insurance->section4_3_buttontext=$request->section4_3_buttontext;
        $insurance->section4_4_image=$request->section4_4_image;
        $insurance->section4_4_title=$request->section4_4_title;
        $insurance->section4_4_decription=$request->section4_4_decription;
        $insurance->section4_4_buttontext=$request->section4_4_buttontext;
        $insurance->save();
        return Redirect()->route("admin.insurance.update", ['id' => $id])->with('success', 'success');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Insurance::destroy($id);
    }
}

