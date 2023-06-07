<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\FileHandler;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller {
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
        $settings = Setting::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Settings',
            'settings' => $settings,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Update Settings',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.settings.addeditsettings')->with($viewData);
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
            'home_banner_line1' => 'max:255',
            'home_banner_line2' => 'max:255',
            'phone_number' => 'max:20',
            'email' => 'max:255',
            'homepage_meta_title' => 'max:255',
            'homepage_meta_description' => 'max:255',
            'blog_page_meta_title' => 'max:255',
            'blog_page_meta_description' => 'max:255',
            'contact_page_meta_title' => 'max:255',
            'contact_page_meta_description' => 'max:255',
            'logo' => 'file|mimes:jpg,jpeg,png|max:1024',
            'home_banner_image' => 'file|mimes:jpg,jpeg,png|max:1024',
            'home_banner_image_mobile' => 'file|mimes:jpg,jpeg,png|max:1024',
            'favicon' => 'file|mimes:jpg,jpeg,png|max:200',

        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.setting.update", ['id' =>$id])->with('error', $validator->errors());
        }
        $settingsData = $request->all();
        unset($settingsData['_token']);
        if ($request->hasfile('logo')) {
            $file = $request->file('logo');
            if ($file->isValid()) {
                $logo = FileHandler::uploadImage($file);
                if(!$logo) {
                    return Redirect()->route("admin.setting.update", ['id' =>$id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $settingsData['logo'] = $logo;
                }
            }else {
                return Redirect()->route("admin.setting.update", ['id' =>$id])->with('error', 'Logo image is not valid');
            }
        }

        if ($request->hasfile('home_banner_image')) {
            $file = $request->file('home_banner_image');
            if ($file->isValid()) {
                $home_banner_image = FileHandler::uploadImage($file);
                if(!$home_banner_image) {
                    return Redirect()->route("admin.setting.update", ['id' =>$id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $settingsData['home_banner_image'] = $home_banner_image;
                }
            }else {
                return Redirect()->route("admin.setting.update", ['id' =>$id])->with('error', 'Homepage Banner Image is not valid');
            }
        }
  
        if ($request->hasfile('home_banner_image_mobile')) {
            $file = $request->file('home_banner_image_mobile');
            if ($file->isValid()) {
                $home_banner_image_mobile = FileHandler::uploadImage($file);
                if(!$home_banner_image_mobile) {
                    return Redirect()->route("admin.setting.update", ['id' =>$id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $settingsData['home_banner_image_mobile'] = $home_banner_image_mobile;
                }
            }else {
                return Redirect()->route("admin.setting.update", ['id' =>$id])->with('error', 'Homepage Mobile Banner Image is not valid');
            }
        }

        if ($request->hasfile('favicon')) {
            $file = $request->file('favicon');
            if ($file->isValid()) {
                $favicon = FileHandler::uploadImage($file);
                if(!$favicon) {
                    return Redirect()->route("admin.setting.update", ['id' =>$id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $settingsData['favicon'] = $favicon;
                }
            }else {
                return Redirect()->route("admin.setting.update", ['id' =>$id])->with('error', 'Favicon Image is not valid');
            }
        }
        Setting::where('id', $id)->update($settingsData);
        return Redirect()->route("admin.setting.update", ['id' =>$id])->with('success', 'Settings updated successfully');
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
