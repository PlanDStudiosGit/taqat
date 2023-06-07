<?php

namespace App\Http\Controllers\Admin;

use App\Common\FileHandler;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        $viewData = array(
            'pageName' => 'Portfolio',
            'services' => $services,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Portfolio',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.portfolio.portfolio')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = Portfolio::where('service_id_fk', $input['serviceId']);
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
            $orderableColumns = array('title', 'slug', 'order_no');
            $query->orderBy($orderableColumns[$request->order['0']['column']], $request->order['0']['dir']);
        }else {
            $query->orderBy('order_no', 'ASC');
        }
        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredPortfolios = $query->get();
        foreach($filteredPortfolios as $portfolio) {
            $portfolio->actions = '<a class="edit_portfolio" href="'.route('admin.portfolio.edit', ['id' => $portfolio->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="portfolio" data-id="'.$portfolio->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformportfolio'. $portfolio->id.'" method="POST" action="'.route('admin.portfolio.destroy', ['id' => $portfolio->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => Portfolio::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredPortfolios
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($portfolioId = NULL)
    {
        $allCategories = Service::all();
        $viewData = array(
            'pageName' => 'Add Portfolio',
            'categories' => $allCategories,
            'portfolioId' => $portfolioId,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Portfolio',
                    'class' => '',
                    'url' => route('admin.portfolio.index')
                ),
                (object)array(
                    'name' => 'Add New Portfolio',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.portfolio.addeditportfolio')->with($viewData);
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
            'order_no' => 'required|gt:0',
            'description' => 'required',
            'featured_image' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.portfolio.create")->with('error', $validator->errors());
        }
        $featuredImage = null;
        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = FileHandler::uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.portfolio.create")->with('error', 'Something went wrong. Please try again');
                }
            }else {
                return Redirect()->route("admin.portfolio.create")->with('error', 'Featured image is not valid');
            }
        }

        $portfolio = new Portfolio;
        $portfolio->title = $request->title;
        $portfolio->featured_image = $featuredImage;
        $portfolio->description = $request->description;
        $portfolio->order_no = $request->order_no;
        $portfolio->meta_title = $request->meta_title;
        $portfolio->meta_description = $request->meta_description;
        $portfolio->service_id_fk = $request->service_id_fk;
        $portfolio->save();
        return Redirect()->route("admin.portfolio.index")->with('success', 'Portfolio added successfully');
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
        $portfolio = Portfolio::findOrFail($id);
        $allCategories = Service::all();
        $viewData = array(
            'pageName' => 'Update Portfolio',
            'portfolio' => $portfolio,
            'categories' => $allCategories,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Portfolio',
                    'class' => '',
                    'url' => route('admin.portfolio.index')
                ),
                (object)array(
                    'name' => 'Update Portfolio',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.portfolio.addeditportfolio')->with($viewData);
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
        $portfolio = Portfolio::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'order_no' => 'required|gt:0',
            'description' => 'required',
            'featured_image' => 'file|mimes:jpg,jpeg,png|max:5120',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.portfolio.update", ['id' =>$id])->with('error', $validator->errors());
        }

        if ($request->hasfile('featured_image')) {
            $file = $request->file('featured_image');
            if ($file->isValid()) {
                $featuredImage = FileHandler::uploadImage($file);
                if(!$featuredImage) {
                    return Redirect()->route("admin.portfolio.update", ['id' =>$id])->with('error', 'Something went wrong. Please try again');
                }else {
                    $portfolio->featured_image = $featuredImage;
                }
            }else {
                return Redirect()->route("admin.portfolio.update", ['id' =>$id])->with('error', 'Featured image is not valid');
            }
        }

        $portfolio->title = $request->title;
        $portfolio->description = $request->description;
        $portfolio->order_no = $request->order_no;
        $portfolio->meta_title = $request->meta_title;
        $portfolio->meta_description = $request->meta_description;
        $portfolio->service_id_fk = $request->service_id_fk;
        $portfolio->save();
        return Redirect()->route("admin.portfolio.index")->with('success', 'Portfolio updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Portfolio::destroy($id);
        return Redirect()->route("admin.portfolio.index")->with('success', 'Portfolio deleted successfully');
    }

    public function removeimage($id, $slug) {
        $portfolio = Portfolio::findOrFail($id);
        $portfolio->$slug = null;
        $portfolio->save();
        return Redirect()->route("admin.portfolio.update", ['id' =>$id])->with('success', 'Image removed successfully');
    }
}
