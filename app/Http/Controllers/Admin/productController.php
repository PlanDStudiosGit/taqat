<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Category;
use App\Models\Subcategories;
use App\Models\Brand;
use App\Models\color;
use App\Models\size;


use App\Http\Controllers\Admin\Validator;

class productController extends Controller
{
    
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "cvbnm";exit;
        $viewData = array(
            'pageName' => 'product',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'product',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.product.product')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = product::query();
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
        // echo "<pre>";print_r($filteredCategories);echo "</pre>";exit;
        foreach($filteredCategories as $product) {
            $product->featured_image='<img src="'.asset('uploads/' . $product->featured_image).'" style="width:70px;"/>';



            $product->actions = '<a class="edit_product" href="'.route('admin.product.edit', ['id' => $product->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="product" data-id="'.$product->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformproduct'. $product->id.'" method="POST" action="'.route('admin.product.destroy', ['id' => $product->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
                   
           
         

        }
        $data = [

            'draw' => $input['draw'],
            'recordsTotal' => product::count(),
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
        $allCategories = Category::all();
        $allSubcategories = Subcategories::all();
        $allBrands = Brand::all();
        $allcolors = color::all();
        $allsizes = size::all();


        $viewData = array(
            'pageName' => 'Add product',
            'categories'=>   $allCategories,
            'Subcategories' => $allSubcategories,
            'Brands' => $allBrands,
            'color' => $allcolors,
             'size' => $allsizes,
            
            'Brands' => $allBrands,

            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'product',
                    'class' => '',
                    'url' => route('admin.product.index')
                ),
                (object)array(
                    'name' => 'Add New product',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.product.addeditproduct')->with($viewData);
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

   
   
    $featured_image = null;
    if ($request->hasfile('featured_image')) {
        $file = $request->file('featured_image');
        if ($file->isValid()) {
            $featured_image = $this->uploadImage($file);
            // echo "<pre>";
            // print_r($featured_image);
            // exit;
            if(!$featured_image) {
                return Redirect()->route("admin.product.create")->with('error', 'Something went wrong. Please try again');
            }
        }else {
            return Redirect()->route("admin.product.create")->with('error', 'Featured image is not valid');
        }
    }
        
        $product = new product;
         $product->title = $request->title;
        $product->slug = $request->slug;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->brand_id = $request->brand_id;
        $product->color_id = $request->color_id;
        $product->size_id = $request->size_id;
      
        $product->featured_image = $featured_image;
        $product->price = $request->price;
        $product->qty = $request->qty;

        
      
        $product->save();
        $product_id=$product->id;
        return Redirect()->route("admin.product.index")->with('success', 'product added successfully');
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
        // $Subcategories = Subcategories::findOrFail($id);
        $product = product::findOrFail($id);
        $allCategories = Category::all();
        $allSubcategories = Subcategories::all();
        $allBrands = Brand::all();
       

        $viewData = array(
            'pageName' => 'Update product',
            'product' => $product,
            'Subcategories' => $allSubcategories,
            'categories'=>   $allCategories,
            'Brands' => $allBrands,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'product',
                    'class' => '',
                    'url' => route('admin.product.index')
                ),
                (object)array(
                    'name' => 'Update product',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.product.addeditproduct')->with($viewData);
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
        $product = product::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255',
            'featured_image' => 'file|mimes:jpg,jpeg,png|max:5120',
        
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.product.update", ['id' =>$id])->with('error', $validator->errors());
        }

       echo "<pre>";
            print_r($product);
            exit;
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->brand_id = $request->brand_id;
        $product->color_id = $request->color_id;
        $product->size_id = $request->size_id;
     
        $product->featured_image = $request->featured_image;
        $product->price = $request->price;
        $product->qty = $request->qty;
        
    
        $product->save();
        return Redirect()->route("admin.product.index")->with('success', 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        product::destroy($id);
        return Redirect()->route("admin.product.index")->with('success', 'product deleted successfully');
    }

    public function uploadImage($file) {
        $ext = $file->extension();
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $prefix = 'uploads-' . md5(time().rand());
        $imgName = $prefix . '.' . $ext;
        if ($file->move($path, $imgName)) {
            return  $imgName;
            // return $imgName;
        }else{
            return false;
        }
    }
  

}
