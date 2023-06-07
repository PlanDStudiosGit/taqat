<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\PaymentApproval as AdminPaymentApproval;
use App\Http\Controllers\Controller;
use App\Models\labor_hiring;
use App\Models\LaborModel;
use App\Models\services;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class PaymentApproval extends Controller
{
    public function index()
    {
        $viewData = array(
            'pageName' => 'PaymentApproval',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.paymentapproval')
                ),
                (object)array(
                    'name' => 'Paymentapproval',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.paymentapproval.paymentapproval')->with($viewData);
    }


    public function tabledata(Request $request)
    {
        $input = $request->all();
        $query = labor_hiring::query();
        $query->join('ourservices', 'ourservices.id', '=', 'labor_hirings.service')
        ->join('users as from_user', 'labor_hirings.hiring_sponsor_id', '=', 'from_user.id')
        ->join('users as to_user', 'labor_hirings.sponsor_id', '=', 'to_user.id')
        ->join('labor_details', 'labor_hirings.labor_id', '=', 'labor_details.id')
        ->where('labor_hirings.labor_status','=','1')
        ->select( 'labor_hirings.payment_status','labor_hirings.payment_proof_doc','labor_hirings.payment_status','labor_hirings.id as hiring_id','ourservices.*','from_user.name as from_name','to_user.name as to_user','labor_details.*');
        
        // dd($query->toSql());   


        if ($request->search['value']) {
            $searchStrings = explode(' ', $request->search['value']);
            foreach ($searchStrings as $searchString) {
                $query->where(function ($query) use ($searchString) {
                    $query->orWhere('title', 'like', '%' . $searchString . '%');
                });
            }
        }
        // if ($request->order) {
        //     $orderableColumns = array('title', '');
        //     $query->orderBy($orderableColumns[$request->order['0']['column']], $request->order['0']['dir']);
        // } else {
        //     $query->orderBy('id', 'DESC');
        // }
        $recordsFiltered = $query->count();
        // $query->offset($input['start']);
        // $query->limit($input['length']);
        $filteredusers = $query->get();

        // dd($filteredusers);

        foreach ($filteredusers as $labor) {
            $labor->actions = '<a class="edit_user" href="' . route('admin.paymentapproval.edit', ['id' => $labor->hiring_id]) . '">
                        <img src="' . asset('img/edit-solid.svg') . '" alt="edit icon">
                    </a>

                    <a class="delete_service" href="' . route('admin.paymentapproval.destroy', ['id' => $labor->hiring_id]) . '">
                        <img src="' . asset('img/delete-solid.svg') . '" alt="delete icon">
                    </a>
                    ';

            // $service = services::where('id', $labor->id)->first();
            // $service = DB::table('ourservices')->where('id',$labor->occupation)->first();
            // $labor->occupation = @$service->title;


            // $laborr = LaborModel::find($labor->id);
            // $dateOfBirth = $laborr->dob;
            // $labor->dob = Carbon::parse($dateOfBirth)->age;


            // $f_name = $labor->labor_first_name;
            // $l_name = $labor->labor_last_name;


            // $labor->labor_first_name = $f_name . ' ' . $l_name;
            // $labor-
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => labor_hiring::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredusers
        ];
        return response()->json($data);
    }



    public function create()
    {

        $services = labor_hiring::all();
        $viewData = array(
            'pageName' => 'Add Labor',
            'services' => $services,

            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'add labor',
                    'class' => '',
                    'url' => route('admin.paymentapprovel')
                ),
                (object)array(
                    'name' => 'Add New Labor',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.labors.addeditlabors')->with($viewData);
    }



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


        $query = labor_hiring::query($id);
        $query->join('ourservices', 'ourservices.id', '=', 'labor_hirings.service')
        ->join('users as from_user', 'labor_hirings.hiring_sponsor_id', '=', 'from_user.id')
        ->join('users as to_user', 'labor_hirings.sponsor_id', '=', 'to_user.id')
        ->join('labor_details', 'labor_hirings.labor_id', '=', 'labor_details.id')
        ->where('labor_hirings.id','=',$id)
        ->select( 'labor_hirings.payment_status','labor_hirings.payment_proof_doc','labor_hirings.payment_status','labor_hirings.id as hiring_id','ourservices.*','from_user.name as from_name','to_user.name as to_user','labor_details.*');
        $labor_hiring = $query->first();
        // dd($labor_hiring);
        $services = services::all();

        $viewData = array(
            'pageName' => 'Edit Hiring',
            'services' => $services,
            'labor_hiring' => $labor_hiring,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'edit hiring',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.paymentapproval.addeditpaymentapproval')->with($viewData);
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

        $labor_hiring = labor_hiring::findOrFail($id);
        $payment_status = $request->payment_status;

        $labor_hiring->payment_status = $payment_status;
        // update([
        //     'payment_status' => $payment_status
        //     // Add more columns and values as needed
        // ]);
        $labor_hiring->save();

        return Redirect()->route("admin.paymentapproval")->with('success', 'Payment status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $labor = labor_hiring::find($id);
        $labor->delete();
        return redirect()->back()->with('success', 'Record deleted successfully');
    }
}
