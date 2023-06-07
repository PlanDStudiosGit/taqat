<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\size;

use App\Http\Controllers\Admin\Validator;

class sizeController extends Controller
{
    
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'size',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'size',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.size.size')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = size::query();
        if($request->search['value']) {
            $searchStrings = explode(' ', $request->search['value']);
            foreach($searchStrings as $searchString) {
                $query->where(function ($query) use ($searchString) {
                    $query->orWhere('title', 'like', '%' . $searchString . '%');
                    $query->orWhere('slug', 'like', '%' . $searchString . '%');
                });
            }
        }
        if($request->order) {
            $orderableColumns = array('title', 'slug', '');
            $query->orderBy($orderableColumns[$request->order['0']['column']], $request->order['0']['dir']);
        }else {
            $query->orderBy('id', 'DESC');
        }
        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredCategories = $query->get();
        foreach($filteredCategories as $size) {
            $size->actions = '<a class="edit_size" href="'.route('admin.size.edit', ['id' => $size->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="size" data-id="'.$size->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformsize'. $size->id.'" method="POST" action="'.route('admin.size.destroy', ['id' => $size->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => size::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredCategories
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
            'pageName' => 'Add size',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'size',
                    'class' => '',
                    'url' => route('admin.size.index')
                ),
                (object)array(
                    'name' => 'Add New size',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.size.addeditsize')->with($viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
    //     $validator = Validator::make($request->all(), [
    //         'title' => 'required|max:255',
    //         'meta_title' => 'required|max:255',
    //         'featured_image' => 'required|file|mimes:jpg,jpeg,png|max:5120',
    //         'meta_description' => 'required|max:255',
    //     ]);

    //     if ($validator->fails()) {
    //         return Redirect()->route("admin.color.create")->with('error', $validator->errors());
    //     }


        $size = new size;
        $size->title = $request->title;
        
      
        $size->save();
        return Redirect()->route("admin.size.index")->with('success', 'size added successfully');
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
        $size = size::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update size',
            'size' => $size,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'size',
                    'class' => '',
                    'url' => route('admin.size.index')
                ),
                (object)array(
                    'name' => 'Update size',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.size.addeditsize')->with($viewData);
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
        $size = size::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255',
            'featured_image' => 'file|mimes:jpg,jpeg,png|max:5120',
        
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.size.update", ['id' =>$id])->with('error', $validator->errors());
        }

     
        $size->title = $request->title;
       
    
        $size->save();
        return Redirect()->route("admin.size.index")->with('success', 'size updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        size::destroy($id);
        return Redirect()->route("admin.size.index")->with('success', 'size deleted successfully');
    }

    public function uploadImage($file) {
        $ext = $file->extension();
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $prefix = 'uploads-' . md5(time().rand());
        $imgName = $prefix . '.' . $ext;
        if ($file->move($path, $imgName)) {
            return url('/')."/uploads/". $imgName;
        }else{
            return false;
        }
    }
    
}
