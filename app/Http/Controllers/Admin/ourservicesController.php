<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ourservices;
use App\Common\FileHandler;
use App\Models\services;
use App\Models\servicesmodel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ourservicesController extends Controller
{


    public function index()
    {
        $viewData = array(
            'pageName' => 'Services',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Services',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.service.service')->with($viewData);
    }





    public function tabledata(Request $request)
    {
        $input = $request->all();
        $query = services::query();

        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredServices = $query->get();

        foreach ($filteredServices as $service) {
            $service->actions = '<a class="edit_ourservice" href="' . route('admin.ourservices.edit', ['id' => $service->id]) . '">
                        <img src="' . asset('img/edit-solid.svg') . '" alt="edit icon">
                    </a>
                    
                    <a class="delete_service" href="' . route('admin.ourservices.destroy', ['id' => $service->id]) . '">
                        <img src="' . asset('img/delete-solid.svg') . '" alt="delete icon">
                    </a>
                    
                    ';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => services::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredServices
        ];
        return response()->json($data);
    }


    public function create()
    {
        $viewData = array(
            'pageName' => 'Create Service',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Create Service',
                    'class' => '',
                    'url' => route('admin.ourservices.index')
                ),
                (object)array(
                    'name' => 'Create',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.service.addeditservice')->with($viewData);
    }





    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required | regex:/^[a-zA-Z_ ]+$/',
            'slug' => 'required',

        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.ourservices.create")->with('error', $validator->errors());
        }
        $featuredImage = null;
        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = FileHandler::uploadImage($file);
                if (!$featuredImage) {
                    return Redirect()->route("admin.ourservices.create")->with('error', 'Something went wrong. Please try again');
                }
            } else {
                return Redirect()->route("admin.ourservices.create")->with('error', 'Featured image is not valid');
            }
        }

        $title = $request->title;
        $slug = $request->slug;



        $service = new services;
        $service->title = $title;
        $service->slug = $slug;




        if (services::where('title', $request->title)->exists()) {

            return Redirect()->route("admin.ourservices.index")->with('success', 'Service already exist');
        } else {

            $service->save();
            return Redirect()->route("admin.ourservices.index")->with('success', 'Service added successfully');
        }
    }



    public function edit($id)
    {
        $service = services::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Service',
            'service' => $service,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Service',
                    'class' => '',
                    'url' => route('admin.ourservices.index')
                ),
                (object)array(
                    'name' => 'Update',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.service.addeditservice')->with($viewData);
    }




    public function updates(Request $request, $id)
    {


        $service = services::find($id);


        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = FileHandler::uploadImage($file);
                if (!$featuredImage) {
                    return Redirect()->route("admin.ourservices.update", ['id' => $id])->with('error', 'Something went wrong. Please try again');
                } else {
                    $service->featured_image = $featuredImage;
                }
            } else {
                return Redirect()->route("admin.ourservices.update", ['id' => $id])->with('error', 'Featured image is not valid');
            }
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|regex:/^[a-zA-Z_ ]+$/',
            'slug' => 'required|alpha',

        ]);

        $service->title = $request->title;
        $service->slug = $request->slug;




        $service->save();
        return Redirect()->route("admin.ourservices.index")->with('success', 'service updated successfully');
    }


    public function destroy($id)
    {

        services::destroy($id);
        return Redirect()->route("admin.ourservices.index")->with('success', 'service deleted successfully');
    }

    public function checkNumber(Request $request)
    {
        $title = $request->title;
        $exists = DB::table('ourservices')->where('title', $title)->exists();
    
        return response()->json(['exists' => $exists]);
    }


}
