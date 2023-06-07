<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Section',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Section',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.section.section')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = Section::query();
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
        $filteredSections = $query->get();
        foreach($filteredSections as $section) {
            $section->actions = '<a class="edit_section" href="'.route('admin.section.edit', ['id' => $section->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => Section::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredSections
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
            'pageName' => 'Add Section',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Section',
                    'class' => '',
                    'url' => route('admin.section.index')
                ),
                (object)array(
                    'name' => 'Add New Section',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.section.addeditsection')->with($viewData);
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
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.section.create")->with('error', $validator->errors());
        }

        $section = new Section;
        $section->title = $request->title;
        $section->description = $request->description;
        $section->save();
        return Redirect()->route("admin.section.index")->with('success', 'Section added successfully');
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
        $section = Section::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Section',
            'section' => $section,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Section',
                    'class' => '',
                    'url' => route('admin.section.index')
                ),
                (object)array(
                    'name' => 'Update Section',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.section.addeditsection')->with($viewData);
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
        $section = Section::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.section.update", ['id' =>$id])->with('error', $validator->errors());
        }

        $section->title = $request->title;
        $section->description = $request->description;
        $section->save();
        return Redirect()->route("admin.section.index")->with('success', 'Section updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Section::destroy($id);
        return Redirect()->route("admin.section.index")->with('success', 'Section deleted successfully');
    }
}
