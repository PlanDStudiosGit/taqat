<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Category',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Category',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.category.category')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = Category::query();
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
        foreach($filteredCategories as $category) {
            $category->actions = '<a class="edit_category" href="'.route('admin.category.edit', ['id' => $category->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="category" data-id="'.$category->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformcategory'. $category->id.'" method="POST" action="'.route('admin.category.destroy', ['id' => $category->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => Category::count(),
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
            'pageName' => 'Add Category',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Category',
                    'class' => '',
                    'url' => route('admin.category.index')
                ),
                (object)array(
                    'name' => 'Add New Category',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.category.addeditcategory')->with($viewData);
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
            'meta_title' => 'required|max:255',
            'featured_image' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'meta_description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.category.create")->with('error', $validator->errors());
        }
        $featuredImage = null;
        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = $this->uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.category.create")->with('error', 'Something went wrong. Please try again');
                }
            }else {
                return Redirect()->route("admin.category.create")->with('error', 'Featured image is not valid');
            }
        }

        $category = new Category;
        $category->title = $request->title;
        $category->featured_image = $featuredImage;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->save();
        return Redirect()->route("admin.category.index")->with('success', 'Category added successfully');
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
        $category = Category::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Category',
            'category' => $category,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Category',
                    'class' => '',
                    'url' => route('admin.category.index')
                ),
                (object)array(
                    'name' => 'Update Category',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.category.addeditcategory')->with($viewData);
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
        $category = Category::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'featured_image' => 'file|mimes:jpg,jpeg,png|max:5120',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.category.update", ['id' =>$id])->with('error', $validator->errors());
        }

        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = $this->uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.category.update", ['id' =>$id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $category->featured_image = $featuredImage;
                }
            }else {
                return Redirect()->route("admin.category.update", ['id' =>$id])->with('error', 'Featured image is not valid');
            }
        }

        $category->title = $request->title;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->save();
        return Redirect()->route("admin.category.index")->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return Redirect()->route("admin.category.index")->with('success', 'Category deleted successfully');
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
