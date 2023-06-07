<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\invoiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class invoiceController extends Controller
{
    
    public function index()
    {
        $query = invoiceModel::query();

        $viewData = array(
            'pageName' => 'Invoice Details',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Invoice Details',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.invoice.invoice')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = invoiceModel::query();

        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filtereddetails = $query->get();
        // dd($filtereddetails);
        foreach($filtereddetails as $details) {
            $details->actions = '<a class="edit_invoice" href="'.route('admin.invoice.edit', ['id' => $details->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>
                    <a class="delete_invoice" href="' . route('admin.invoice.destroy', ['id' => $details->id]) . '">
                    <img src="' . asset('img/delete-solid.svg') . '" alt="delete icon">
                </a>
                
                ';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => invoiceModel::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filtereddetails
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
            'pageName' => 'Add Invoice details',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Invoice details',
                    'class' => '',
                    'url' => route('admin.invoice.index')
                ),
                (object)array(
                    'name' => 'Add Invoice detail',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.invoice.addeditinvoice')->with($viewData);
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
            'work_permit_unit_cost' => 'required',
            'medical_unit_cost' => 'required',
            'visa_form_unit_cost' => 'required',
            'visa_stamp_unit_cost' => 'required',
            'resident_form_unit_cost' => 'required',
            'labor_card_unit_cost' => 'required',
            'sponsorship_transfer_unit_cost' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect()->route("admin.invoice.create")->with('error', $validator->errors());
        }

        // $input = $request->all();
        // dd($input);
        
        $invoicedetails = new invoiceModel();
        $invoicedetails->workpermit_unit_cost = $request->work_permit_unit_cost;
        $invoicedetails->medical_unit_cost = $request->medical_unit_cost;
        $invoicedetails->visa_form_unit_cost = $request->visa_form_unit_cost;
        $invoicedetails->visa_stamp_unit_cost = $request->visa_stamp_unit_cost;
        $invoicedetails->resident_form_unit_cost = $request->resident_form_unit_cost;
        $invoicedetails->labor_card_unit_cost = $request->labor_card_unit_cost;
        $invoicedetails->sponsorship_form_unit_cost = $request->sponsorship_transfer_unit_cost;
        $invoicedetails->bank_name = $request->bank_name;
        $invoicedetails->bank_account_number = $request->bank_account;
        
        $invoicedetails->save();
        return Redirect()->route("admin.invoice.index")->with('success', 'Details added successfully');
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
        $details = invoiceModel::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Invoice details',
            'details' => $details,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Invoice details',
                    'class' => '',
                    'url' => route('admin.invoice.index')
                ),
                (object)array(
                    'name' => 'Update Invoice details',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.invoice.addeditinvoice')->with($viewData);
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
        $invoicedetails = invoiceModel::findOrFail($id);
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|max:255',
        //     'featured_image' => 'file|mimes:jpg,jpeg,png|max:5120',
        //     'order_no' => 'required|gt:0',
        //     'description' => 'required',
        //     'meta_title' => 'required|max:255',
        //     'meta_description' => 'required|max:255',
        // ]);
        // if ($validator->fails()) {
        //     return Redirect()->route("admin.invoicedetails.update", ['id' =>$id])->with('error', $validator->errors());
        // }

        $invoicedetails->workpermit_unit_cost = $request->work_permit_unit_cost;
        $invoicedetails->medical_unit_cost = $request->medical_unit_cost;
        $invoicedetails->visa_form_unit_cost = $request->visa_form_unit_cost;
        $invoicedetails->visa_stamp_unit_cost = $request->visa_stamp_unit_cost;
        $invoicedetails->resident_form_unit_cost = $request->resident_form_unit_cost;
        $invoicedetails->labor_card_unit_cost = $request->labor_card_unit_cost;
        $invoicedetails->sponsorship_form_unit_cost = $request->sponsorship_transfer_unit_cost;
        $invoicedetails->bank_name = $request->bank_name;
        $invoicedetails->bank_account_number = $request->bank_account;
        $invoicedetails->save();
        return Redirect()->route("admin.invoice.index")->with('success', 'Details updated successfully');

        // $service->title = $request->title;
        // $service->order_no = $request->order_no;
        // $service->description = $request->description;
        // $service->meta_title = $request->meta_title;
        // $service->meta_description = $request->meta_description;
        // $service->save();
        // return Redirect()->route("admin.invoicedetails.index")->with('success', 'service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        invoiceModel::destroy($id);
        return Redirect()->route("admin.invoice.index")->with('success', 'Invoice details deleted successfully');
    }


}
