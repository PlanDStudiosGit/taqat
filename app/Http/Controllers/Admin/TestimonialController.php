<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Review',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Review',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.testimonial.testimonial')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = Testimonial::query();
        if($request->search['value']) {
            $searchStrings = explode(' ', $request->search['value']);
            foreach($searchStrings as $searchString) {
                $query->where(function ($query) use ($searchString) {
                    $query->orWhere('title', 'like', '%' . $searchString . '%');
                });
            }
        }
        if($request->order) {
            $orderableColumns = array('title', '');
            $query->orderBy($orderableColumns[$request->order['0']['column']], $request->order['0']['dir']);
        }else {
            $query->orderBy('id', 'DESC');
        }
        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredTestimonials = $query->get();
        foreach($filteredTestimonials as $testimonial) {
            $testimonial->actions = '<a class="edit_testimonial" href="'.route('admin.testimonial.edit', ['id' => $testimonial->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="testimonial" data-id="'.$testimonial->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformtestimonial'. $testimonial->id.'" method="POST" action="'.route('admin.testimonial.destroy', ['id' => $testimonial->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => ::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredTestimonials
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
            'pageName' => 'Add Review',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Review',
                    'class' => '',
                    'url' => route('admin.testimonial.index')
                ),
                (object)array(
                    'name' => 'Add New Review',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.testimonial.addedittestimonial')->with($viewData);
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
            'title' => 'required | alpha',
            'description' => 'required | alpha'
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.testimonial.create")->with('error', $validator->errors());
        }

        $testimonial = new Testimonial;
        $testimonial->title = $request->title;
        $testimonial->description = $request->description;
        $testimonial->save();
        return Redirect()->route("admin.testimonial.index")->with('success', 'Review added successfully');
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
        $testimonial = Testimonial::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Review',
            'testimonial' => $testimonial,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Review',
                    'class' => '',
                    'url' => route('admin.testimonial.index')
                ),
                (object)array(
                    'name' => 'Update Review',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.testimonial.addedittestimonial')->with($viewData);
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
        $testimonial = Testimonial::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|alpha',
            'description' => 'required|alpha'
        ]);
        
        if ($validator->fails()) {
            return Redirect()->route("admin.testimonial.update", ['id' =>$id])->with('error', $validator->errors());
        }

        $testimonial->title = $request->title;
        $testimonial->description = $request->description;
        $testimonial->save();
        return Redirect()->route("admin.testimonial.index")->with('success', 'Review updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Testimonial::destroy($id);
        return Redirect()->route("admin.testimonial.index")->with('success', 'Review deleted successfully');
    }
}
