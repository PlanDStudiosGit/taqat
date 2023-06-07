<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategories;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class SubcategoriesController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Subcategories',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Subcategories',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.Subcategories.Subcategories')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = Subcategories::query();
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
            $orderableColumns = array('title', 'slug', 'category_id_fk', '');
            $query->orderBy($orderableColumns[$request->order['0']['column']], $request->order['0']['dir']);
        }else {
            $query->orderBy('id', 'DESC');
        }
        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredsub_categories = $query->get();
        foreach($filteredsub_categories as $Subcategories) {
            //Category data title get
$num=$Subcategories->category->title;
$Subcategories->categories =$num; 
            $Subcategories->actions = '<a class="edit_Subcategories" href="'.route('admin.Subcategories.edit', ['id' => $Subcategories->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="Subcategories" data-id="'.$Subcategories->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformSubcategories'. $Subcategories->id.'" method="POST" action="'.route('admin.Subcategories.destroy', ['id' => $Subcategories->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => Subcategories::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredsub_categories
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
        $allCategories = Category::all();
        $viewData = array(
            'pageName' => 'Add Subcategories',
            'categories' => $allCategories,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Subcategories',
                    'class' => '',
                    'url' => route('admin.Subcategories.index')
                ),
                (object)array(
                    'name' => 'Add New Subcategories',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.Subcategories.addeditSubcategories')->with($viewData);
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
            'description' => 'required',
            'featured_image' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.Subcategories.create")->with('error', $validator->errors());
        }
        $featuredImage = null;
        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = $this->uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.Subcategories.create")->with('error', 'Something went wrong. Please try again');
                }
            }else {
                return Redirect()->route("admin.Subcategories.create")->with('error', 'Featured image is not valid');
            }
        }
        $Subcategories = new Subcategories;
        $Subcategories->title = $request->title;
        $Subcategories->featured_image = $featuredImage;
        $Subcategories->description = $request->description;
        $Subcategories->meta_title = $request->meta_title;
        $Subcategories->meta_description = $request->meta_description;
        $Subcategories->category_id_fk = $request->category_id_fk;
        $Subcategories->save();
        return Redirect()->route("admin.Subcategories.index")->with('success', 'Subcategories added successfully');
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
        $Subcategories = Subcategories::findOrFail($id);
        $allCategories = Category::all();
        $viewData = array(
            'pageName' => 'Update Subcategories',
            'Subcategories' => $Subcategories,
            'categories' => $allCategories,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Subcategories',
                    'class' => '',
                    'url' => route('admin.Subcategories.index')
                ),
                (object)array(
                    'name' => 'Update Subcategories',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.Subcategories.addeditSubcategories')->with($viewData);
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
        $Subcategories = Subcategories::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'featured_image' => 'file|mimes:jpg,jpeg,png|max:5120',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.Subcategories.update", ['id' =>$id])->with('error', $validator->errors());
        }

        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = $this->uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.Subcategories.update", ['id' =>$id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $Subcategories->featured_image = $featuredImage;
                }
            }else {
                return Redirect()->route("admin.Subcategories.update", ['id' =>$id])->with('error', 'Featured image is not valid');
            }
        }

        $Subcategories->title = $request->title;
        $Subcategories->description = $request->description;
        $Subcategories->meta_title = $request->meta_title;
        $Subcategories->meta_description = $request->meta_description;
        $Subcategories->category_id_fk = $request->category_id_fk;
        $Subcategories->save();
        return Redirect()->route("admin.Subcategories.index")->with('success', 'Subcategories updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subcategories::destroy($id);
        return Redirect()->route("admin.Subcategories.index")->with('success', 'Subcategories deleted successfully');
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
