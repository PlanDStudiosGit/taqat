<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Faqs',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Faq',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.faq.faq')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = new Faq();
        if($request->search['value']) {
            $searchStrings = explode(' ', $request->search['value']);
            foreach($searchStrings as $searchString) {
                $query->where(function ($query) use ($searchString) {
                    $query->orWhere('title', 'like', '%' . $searchString . '%');
                });
            }
        }
        if($request->order) {
            $orderableColumns = array('title',  '');
            $query->orderBy($orderableColumns[$request->order['0']['column']], $request->order['0']['dir']);
        }else {
            $query->orderBy('order_no', 'ASC');
        }
        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredFaqs = $query->get();
        foreach($filteredFaqs as $faq) {
            $faq->actions = '<a class="edit_faq" href="'.route('admin.faq.edit', ['id' => $faq->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="faq" data-id="'.$faq->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformfaq'. $faq->id.'" method="POST" action="'.route('admin.faq.destroy', ['id' => $faq->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => Faq::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredFaqs
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
            'pageName' => 'Add Faq',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Faq',
                    'class' => '',
                    'url' => route('admin.faq.index')
                ),
                (object)array(
                    'name' => 'Add New Faq',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.faq.addeditfaq')->with($viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $faqData = $request->all();
        $validator = Validator::make($faqData, [
            'title' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return Redirect()->route("admin.faq.create")->with('error', $validator->errors());
        }
        
        $faqData= new FAQ;
        $faqData->title=$request->title;
        $faqData->description=$request->description;
        $faqData->save();
        $data=FAQ::all();
        return redirect()->route('admin.faq.index');
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
        $faq = Faq::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Faq',
            'faq' => $faq,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Faq',
                    'class' => '',
                    'url' => route('admin.faq.index')
                ),
                (object)array(
                    'name' => 'Update Faq',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.faq.addeditfaq')->with($viewData);
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
        $faq = Faq::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect()->route("admin.faq.update", ['id' =>$id])->with('error', $validator->errors());
        }

        $faq->title=$request->title;
        $faq->description=$request->description;
        $faq->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Faq::destroy($id);
        return Redirect()->back()->with('success', 'Faq deleted successfully');
    }
}
