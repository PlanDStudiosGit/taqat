<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Common\FileHandler;
use App\Models\termsandconditions;


class TermsandconditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Pages',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Pages',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.pages.pages')->with($viewData);
    }





    public function tabledata(Request $request)
    {
        $input = $request->all();
        $query = termsandconditions::query();

        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredServices = $query->get();
        foreach ($filteredServices as $service) {
            $service->actions =
                '<a class="edit_service" href="' . route('admin.pages.edit', ['id' => $service->id]) . '">
                        <img src="' . asset('img/edit-solid.svg') . '" alt="edit icon">
                    </a>
                    
                    
                    <a class="delete_service" href="' . route('admin.pages.destroy', ['id' => $service->id]) . '">
                        <img src="' . asset('img/delete-solid.svg') . '" alt="edit icon">
                    </a>
                    
                    ';

                    


        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => termsandconditions::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredServices
        ];
        return response()->json($data);
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $viewData = array(
            'pageName' => 'Pages',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'pages',
                    'class' => '',
                    'url' => route('admin.pages.create')
                ),
                (object)array(
                    'name' => 'Create',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.pages.addeditpages')->with($viewData);
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
            'title' => 'required | regex:/^[a-zA-Z_ ]+$/',
            'slug' => 'required | string',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.pages.create")->with('error', $validator->errors());
        }
        $featuredImage = null;
        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = FileHandler::uploadImage($file);
                if (!$featuredImage) {
                    return Redirect()->route("admin.pages.create")->with('error', 'Something went wrong. Please try again');
                }
            } else {
                return Redirect()->route("admin.pages.create")->with('error', 'Featured image is not valid');
            }
        }

        $title = $request->title;
        $slug = $request->slug;
        $desc = $request->description;


        $terms = new termsandconditions;
        $terms->title = $title;
        $terms->slug = $slug;
        $terms->description = $desc;
        $terms->save();

        return Redirect()->route("admin.pages.index")->with('success', 'service added successfully');
    }









    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = termsandconditions::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Pages',
            'service' => $service,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'pages',
                    'class' => '',
                    'url' => route('admin.pages.index')
                ),
                (object)array(
                    'name' => 'Update',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.pages.addeditpages')->with($viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function updates(Request $request, $id)
    {


        $service = termsandconditions::find($id);


        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = FileHandler::uploadImage($file);
                if (!$featuredImage) {
                    return Redirect()->route("admin.pages.update", ['id' => $id])->with('error', 'Something went wrong. Please try again');
                } else {
                    $service->featured_image = $featuredImage;
                }
            } else {
                return Redirect()->route("admin.pages.update", ['id' => $id])->with('error', 'Featured image is not valid');
            }
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required | regex:/^[a-zA-Z_ ]+$/',
            'slug' => 'required | string',
            'description' => 'required',
        ]);

        $service->title = $request->title;
        $service->slug = $request->slug;
        $service->description = $request->description;
        $service->save();
        return Redirect()->route("admin.pages.index")->with('success', 'service updated successfully');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        termsandconditions::destroy($id);
        return Redirect()->route("admin.pages.index")->with('success', 'service deleted successfully');
    }
}
