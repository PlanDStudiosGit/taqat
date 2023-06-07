<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;

class LeadController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Lead',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Lead',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.lead.lead')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = Lead::query();
        if($request->search['value']) {
            $searchStrings = explode(' ', $request->search['value']);
            foreach($searchStrings as $searchString) {
                $query->where(function ($query) use ($searchString) {
                    $query->orWhere('type', 'like', '%' . $searchString . '%');
                    $query->orWhere('name', 'like', '%' . $searchString . '%');
                    $query->orWhere('phone', 'like', '%' . $searchString . '%');
                    $query->orWhere('email', 'like', '%' . $searchString . '%');
                    $query->orWhere('page', 'like', '%' . $searchString . '%');
                });
            }
        }
        if($request->order) {
            $orderableColumns = array('type', 'name', 'phone', 'email', 'page', 'created_at');
            $query->orderBy($orderableColumns[$request->order['0']['column']], $request->order['0']['dir']);
        }else {
            $query->orderBy('id', 'DESC');
        }
        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredLeads = $query->get();
        foreach($filteredLeads as $lead) {
            $lead->type = ucwords($lead->type).'<a class="clickablecontent" href="'.route('admin.lead.show', ['id' => $lead->id]).'">&nbsp;</a>';
            $lead->name = $lead->name.'<a class="clickablecontent" href="'.route('admin.lead.show', ['id' => $lead->id]).'">&nbsp;</a>';
            $lead->phone = $lead->phone.'<a class="clickablecontent" href="'.route('admin.lead.show', ['id' => $lead->id]).'">&nbsp;</a>';
            $lead->email = $lead->email.'<a class="clickablecontent" href="'.route('admin.lead.show', ['id' => $lead->id]).'">&nbsp;</a>';
            $lead->page = $lead->page.'<a class="clickablecontent" href="'.route('admin.lead.show', ['id' => $lead->id]).'">&nbsp;</a>';
            $lead->datetime = $lead->created_at->format('m/d/Y h:i A').'<a class="clickablecontent" href="'.route('admin.lead.show', ['id' => $lead->id]).'">&nbsp;</a>';
            $lead->actions = '<a class="view_lead" href="'.route('admin.lead.show', ['id' => $lead->id]).'">
                        <img class="eyeiconimg" src="'.asset('img/eye.svg').'" alt="edit icon">
                    </a>
                    <a class="deleteprocess" data-type="lead" data-id="'.$lead->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformlead'. $lead->id.'" method="POST" action="'.route('admin.lead.destroy', ['id' => $lead->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => Lead::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredLeads
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leadDetails = Lead::findOrFail($id);
        $viewData = array(
            'pageName' => 'Lead Details',
            'leadDetails' => $leadDetails,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Leads',
                    'class' => '',
                    'url' => route('admin.lead.index')
                ),
                (object)array(
                    'name' => 'Lead Details',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.lead.leaddetails')->with($viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lead::destroy($id);
        return Redirect()->route("admin.lead.index")->with('success', 'Lead deleted successfully');
    }
}
