<?php

namespace App\Http\Controllers\Admin;

use App\Common\FileHandler;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Service',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Service',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.service.service')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = Service::query();

        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredServices = $query->get();
        foreach($filteredServices as $service) {
            $service->actions = '<a class="edit_service" href="'.route('admin.service.edit', ['id' => $service->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => Service::count(),
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
            'pageName' => 'Add Service',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Service',
                    'class' => '',
                    'url' => route('admin.service.index')
                ),
                (object)array(
                    'name' => 'Add New Service',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.service.addeditservice')->with($viewData);
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
            'featured_image' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'order_no' => 'required|gt:0',
            'description' => 'required',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.service.create")->with('error', $validator->errors());
        }
        $featuredImage = null;
        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = FileHandler::uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.service.create")->with('error', 'Something went wrong. Please try again');
                }
            }else {
                return Redirect()->route("admin.service.create")->with('error', 'Featured image is not valid');
            }
        }
        $service = new Service;
        $service->title = $request->title;
        $service->order_no = $request->order_no;
        $service->description = $request->description;
        $service->featured_image = $featuredImage;
        $service->meta_title = $request->meta_title;
        $service->meta_description = $request->meta_description;
        $service->save();
        return Redirect()->route("admin.service.index")->with('success', 'service added successfully');
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
        $service = Service::findOrFail($id);
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
                    'url' => route('admin.service.index')
                ),
                (object)array(
                    'name' => 'Update Service',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.service.addeditservice')->with($viewData);
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
        $service = Service::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'featured_image' => 'file|mimes:jpg,jpeg,png|max:5120',
            'order_no' => 'required|gt:0',
            'description' => 'required',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.service.update", ['id' =>$id])->with('error', $validator->errors());
        }

        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = FileHandler::uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.service.update", ['id' =>$id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $service->featured_image = $featuredImage;
                }
            }else {
                return Redirect()->route("admin.service.update", ['id' =>$id])->with('error', 'Featured image is not valid');
            }
        }

        $service->title = $request->title;
        $service->order_no = $request->order_no;
        $service->description = $request->description;
        $service->meta_title = $request->meta_title;
        $service->meta_description = $request->meta_description;
        $service->save();
        return Redirect()->route("admin.service.index")->with('success', 'service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::destroy($id);
        return Redirect()->route("admin.service.index")->with('success', 'service deleted successfully');
    }
}
