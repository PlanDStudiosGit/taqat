<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Brand;

use Illuminate\Support\Facades\Validator;

class brandsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Brand',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Brand',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.brands.brand')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = Brand::query();
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
        $filteredBrands = $query->get();
        foreach($filteredBrands as $brand) {
            $brand->actions = '<a class="edit_brand" href="'.route('admin.brand.edit', ['id' => $brand->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="brand" data-id="'.$brand->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformbrand'. $brand->id.'" method="POST" action="'.route('admin.brand.destroy', ['id' => $brand->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => Brand::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredBrands
        ];
        return response()->json($data);
    }
    
    public function create()
    {
        $allBrands = Brand::all();
        $viewData = array(
            'pageName' => 'Add Brand',
            'Brands' => $allBrands,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Brand',
                    'class' => '',
                    'url' => route('admin.brand.index')
                ),
                (object)array(
                    'name' => 'Add New Brand',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.brands.addeditbrands')->with($viewData);
    }
    
    public function store(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // exit;
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required',
            'featured_image' => 'required|file|mimes:jpg,jpeg,png|max:5120',
         
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.blog.create")->with('error', $validator->errors());
        }
        $featured_image = null;
        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featured_image = $this->uploadImage($file);
                if(!$featured_image) {
                    return Redirect()->route("admin.brand.create")->with('error', 'Something went wrong. Please try again');
                }
            }else {
                return Redirect()->route("admin.brand.create")->with('error', 'Featured image is not valid');
            }
        }
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->featured_image = $featured_image;
        $brand->slug = $request->slug;
        $brand->save();
        return Redirect()->route("admin.brand.index")->with('success', 'Brand added successfully');
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
        $brand = Brand::findOrFail($id);
        // $allBrand = Brand::all();
        $viewData = array(
            'pageName' => 'Update Brand',
            'brand' => $brand,
            // 'brand' => $allBrand,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Brand',
                    'class' => '',
                    'url' => route('admin.brand.index')
                ),
                (object)array(
                    'name' => 'Update Brand',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.brands.addeditbrands')->with($viewData);
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
        $brand = Brand::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required',
            'featured_image' => 'file|mimes:jpg,jpeg,png|max:5120',
           
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.brand.update", ['id' =>$id])->with('error', $validator->errors());
        }

        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = $this->uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.branddx.update", ['id' =>$id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $brand->featured_image = $featuredImage;
                }
            }else {
                return Redirect()->route("admin.brand.update", ['id' =>$id])->with('error', 'Featured image is not valid');
            }
        }

        $brand->name = $request->name;
        $brand->slug = $request->slug;
 
        $brand->save();
        return Redirect()->route("admin.brand.index")->with('success', 'Brand updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Brand::destroy($id);
        return Redirect()->route("admin.brand.index")->with('success', 'Brand deleted successfully');
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

