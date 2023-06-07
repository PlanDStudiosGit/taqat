<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use App\Models\LaborModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\services;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LaborController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        

        $viewData = array(
            'pageName' => 'Labors',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'labors',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.labors.labors')->with($viewData);
    }


    public function tabledata(Request $request)
    {
        $input = $request->all();
        $query = LaborModel::query();

        if ($request->search['value']) {
            $searchStrings = explode(' ', $request->search['value']);
            foreach ($searchStrings as $searchString) {
                $query->where(function ($query) use ($searchString) {
                    $query->orWhere('title', 'like', '%' . $searchString . '%');
                });
            }
        }
        if ($request->order) {
            $orderableColumns = array('title', '');
            $query->orderBy($orderableColumns[$request->order['0']['column']], $request->order['0']['dir']);
        } else {
            $query->orderBy('id', 'DESC');
        }
        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredusers = $query->get();
        
        foreach ($filteredusers as $user) {
            $user->actions = '<a class="edit_user" href="' . route('admin.labors.edit', ['id' => $user->id]) . '">
                        <img src="' . asset('img/edit-solid.svg') . '" alt="edit icon">
                    </a>

                    <a class="delete_service" href="' . route('admin.labors.destroy', ['id' => $user->id]) . '">
                        <img src="' . asset('img/delete-solid.svg') . '" alt="delete icon">
                    </a>
                    ';

                    $service = DB::table('ourservices')->where('id',$user->occupation)->first();
                    $user->occupation = @$service->title;  


                    $labor = LaborModel::find($user->id);
                    $dateOfBirth = $labor->dob;
                    $user->dob = Carbon::parse($dateOfBirth)->age;


                    $f_name = $labor->labor_first_name;
                    $l_name = $labor->labor_last_name;

                    $user->labor_first_name = $f_name . ' ' . $l_name;
                    
                 
                   

        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => LaborModel::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredusers
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

        $services = services::all();
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
                    'url' => route('admin.labors.index')
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'first_name' => 'required | regex:/^[a-zA-Z_ ]+$/',
            'last_name' => 'required | regex:/^[a-zA-Z_ ]+$/',
            'labor_photo' => 'required',
            'labor_passport_photo' => 'required',
            'nationality' => 'required',
            'religion' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'monthly_salary' => 'required',
            'gender' => 'required',
            'occupation' => 'required',
            'app_type' => 'required',
            'job_type' => 'required',
            'education' => 'required',
            'labor_sponsorship_transfer_fee' => 'required'
        ]);


        if ($validator->fails()) {
            return Redirect()->route("admin.labors.create")->with('error', $validator->errors());
        }

        // $data = $request->all();
        // dd($data);



        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $passport_number = $request->pass_no;

        $labor_photo = $request->labor_photo;
        $labor_photo_original = $labor_photo->getClientOriginalName();
        $labor_photo_unique = time() . '_' . $labor_photo_original;
        $destinationPath = public_path('/images/labors');
        $labor_photo->move($destinationPath, $labor_photo_unique);


        $labor_passport_photo = $request->labor_passport_photo;
        $labor_passport_photo_original = $labor_passport_photo->getClientOriginalName();
        $labor_passport_photo_unique = time() . '_' . $labor_passport_photo_original;
        $destinationPath = public_path('/images/labors');
        $labor_passport_photo->move($destinationPath, $labor_passport_photo_unique);


        // $gender = $request->gender;
        $gender = $request->gender;
        $experience = $request->experience;
        $nationality = $request->nationality;
        $religion = $request->religion;
        $dob = $request->dob;
        $age = Carbon::parse($dob)->age;


        $address = $request->address;
        $monthly_salary = $request->monthly_salary;
        $marital_status = $request->marital_status;
        $application_type = $request->app_type;

        $occupation = $request->occupation;
        $job_type = $request->job_type;
        $education = $request->education;
        $labor_sponsorship_transfer_fee = $request->labor_sponsorship_transfer_fee;



        $labor = new LaborModel;

        $labor->labor_first_name = $first_name;
        $labor->labor_last_name = $last_name;
        $labor->fullname = $first_name . ' ' . $last_name;
        $labor->passport_no = $passport_number;
        $labor->labor_photo = $labor_photo_unique;
        $labor->passport_copy = $labor_passport_photo_unique;
        $labor->gender = $gender;
        $labor->experience = $experience;
        $labor->nationality = $nationality;
        $labor->religion = $religion;
        $labor->address = $address;
        $labor->dob = $dob;
        $labor->occupation = $occupation;
        $labor->monthly_salary = $monthly_salary;

        $labor->marital_status = $marital_status;
        $labor->application_type = $application_type;

        $labor->job_type = $job_type;
        $labor->education = $education;
        $labor->labor_sponsorship_transfer_fee = $labor_sponsorship_transfer_fee;


        if (LaborModel::where('passport_no', $request->pass_no)->exists()) {

            return Redirect()->route("admin.labors.index")->with('success', 'Labor with this passport number already exist');
        } elseif($age > 20) {
            $labor->save();
            return Redirect()->route("admin.labors.index")->with('success', 'Labor added successfully');
        }else{
            return Redirect()->route("admin.labors.index")->with('success', 'Age must be greater than 20');
        }

       
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


        $labor = LaborModel::findOrFail($id);
        $services = services::all();
       
        $viewData = array(
            'pageName' => 'Edit Labor',
            'services' => $services,
            'labor' => $labor,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'edit labor',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.labors.addeditlabors')->with($viewData);
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

        $validator = Validator::make($request->all(), [
            'first_name' => 'required | regex:/^[a-zA-Z_ ]+$/',
            'last_name' => 'required | regex:/^[a-zA-Z_ ]+$/'
        ]);


        $labor = LaborModel::findOrFail($id);



        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $passport_number = $request->pass_no;



        if ($request->hasfile('labor_photo')) {
            $labor_photo = $request->file('labor_photo');
            $labor_photo_original_name = $labor_photo->getClientOriginalName();
            $labor_photo_unique = time() . '_' . $labor_photo_original_name;
            $destinationPath = public_path('/images/labors');
            $labor_photo->move($destinationPath, $labor_photo_unique);
            $labor->labor_photo = $labor_photo;

            $labor->labor_photo = $labor_photo_unique;
        }




        if ($request->hasfile('labor_passport_photo')) {
            $labor_passport_photo = $request->file('labor_passport_photo');
            $labor_passport_photo_original_name = $labor_passport_photo->getClientOriginalName();
            $labor_passport_photo_unique = time() . '_' . $labor_passport_photo_original_name;
            $destinationPath = public_path('/images/labors');
            $labor_passport_photo->move($destinationPath, $labor_passport_photo_unique);
            $labor->passport_copy = $labor_passport_photo;

            $labor->passport_copy = $labor_passport_photo_unique;
        }


        // $gender = $request->gender;
        $gender = $request->gender;
        $experience = $request->experience;
        $nationality = $request->nationality;
        $religion = $request->religion;
        $dob = $request->dob;

        $age = Carbon::parse($dob)->age;

        $address = $request->address;
        $monthly_salary = $request->monthly_salary;
        $marital_status = $request->marital_status;
        $application_type = $request->app_type;

        $occupation = $request->occupation;
        $job_type = $request->job_type;
        $education = $request->education;
        $labor_sponsorship_transfer_fee = $request->labor_sponsorship_transfer_fee;


        $labor->labor_first_name = $first_name;
        $labor->labor_last_name = $last_name;
        $labor->passport_no = $passport_number;

        $labor->gender = $gender;
        $labor->experience = $experience;
        $labor->nationality = $nationality;
        $labor->religion = $religion;
        $labor->address = $address;
        $labor->dob = $dob;
        $labor->occupation = $occupation;
        $labor->monthly_salary = $monthly_salary;

        $labor->marital_status = $marital_status;
        $labor->application_type = $application_type;

        $labor->job_type = $job_type;
        $labor->education = $education;
        $labor->labor_sponsorship_transfer_fee = $labor_sponsorship_transfer_fee;
        
        $labor->save();
        return Redirect()->route("admin.labors.index")->with('success', 'Labor updated successfully');
        


        // $labor->save();

        // return Redirect()->route("admin.labors.index")->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */  
    public function destroy($id)
    {
        $labor = LaborModel::find($id);
        $labor->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function checkNumber(Request $request)
{
    $number = $request->number;
    $exists = DB::table('labor_details')->where('passport_no', $number)->exists();

    return response()->json(['exists' => $exists]);
}

}
