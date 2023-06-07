<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\color;

use App\Http\Controllers\Admin\Validator;
class colorController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'color',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'color',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.color.color')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = color::query();
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
        foreach($filteredCategories as $color) {
            $color->actions = '<a class="edit_color" href="'.route('admin.color.edit', ['id' => $color->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="color" data-id="'.$color->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformcolor'. $color->id.'" method="POST" action="'.route('admin.color.destroy', ['id' => $color->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => color::count(),
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
            'pageName' => 'Add color',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'color',
                    'class' => '',
                    'url' => route('admin.color.index')
                ),
                (object)array(
                    'name' => 'Add New color',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.color.addeditcolor')->with($viewData);
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


        $color = new color;
        $color->title = $request->title;
        $color->code = $request->code;
      
        $color->save();
        return Redirect()->route("admin.color.index")->with('success', 'color added successfully');
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
        $color = color::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update color',
            'color' => $color,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'color',
                    'class' => '',
                    'url' => route('admin.color.index')
                ),
                (object)array(
                    'name' => 'Update color',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.color.addeditcolor')->with($viewData);
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
        $color = color::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255',
            'featured_image' => 'file|mimes:jpg,jpeg,png|max:5120',
        
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.color.update", ['id' =>$id])->with('error', $validator->errors());
        }

     
        $color->title = $request->title;
        $color->code = $request->code;
    
        $color->save();
        return Redirect()->route("admin.color.index")->with('success', 'color updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        color::destroy($id);
        return Redirect()->route("admin.color.index")->with('success', 'color deleted successfully');
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
