<?php

namespace App\Http\Controllers\Admin;

use App\Common\FileHandler;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insurance;
use App\Models\download;

use Illuminate\Support\Facades\Validator;

class DownloadsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {
            $viewData = array(
                'pageName' => 'Add Downloads',
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
                        'name' => 'Add New Downloads',
                        'class' => 'active',
                        'url' => 'javascript:;'
                    )
                )
            );
            return view('admin.insurance1.addeditinsurance')->with($viewData);
    }
    
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
                'pageName' => 'Add Downloads',
                'breadCrumbs' => array(
                    (object)array(
                        'name' => 'Dashboard',
                        'class' => '',
                        'url' => route('admin.dashboard')
                    ),
                    (object)array(
                        'name' => 'Downloads',
                        'class' => '',
                        'url' => route('admin.download.index')
                    ),
                    (object)array(
                        'name' => 'Add New Downloads',
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'buttontext' => 'required|max:255',
            'buttontext' => 'required|max:255',


        ]);       
        $download = new download;
        $download->title = $request->download_title;
        $download->buttontext = $request->download_buttontext;
        $download->path = $request->download_path;
        $download->save();
        return Redirect()->route("admin.download.index")->with('Success');
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
        $menu = Insurance::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Page',
            'menu' => $menu,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'menu',
                    'class' => '',
                    'url' => route('admin.menu.index')
                ),
                (object)array(
                    'name' => 'Update menu',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.menu.addeditmenu')->with($viewData);
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
        $menu = Insurance ::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        $menu->name = $request->name;
        $menu->save();
        return Redirect()->route("admin.menu.index")->with('success', 'Insaurance updated successfully');
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
        return Redirect()->route("admin.menu.index")->with('success', 'Insurance deleted successfully');
    }
}

