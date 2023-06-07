<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Users',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'users',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.users.user')->with($viewData);
    }




    public function tabledata(Request $request)
    {
        $input = $request->all();
        $query = User::query();
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
            $user->actions = '<a class="edit_user" href="' . route('admin.users.edit', ['id' => $user->id]) . '">
                        <img src="' . asset('img/edit-solid.svg') . '" alt="edit icon">
                    </a>
                    <a class="delete_service" href="' . route('admin.users.destroy', ['id' => $user->id]) . '">
                        <img src="' . asset('img/delete-solid.svg') . '" alt="delete icon">
                    </a>
                    ';


            $myuser = User::find($user->id);
            $dateOfBirth = $myuser->dob;
            $user->dob = Carbon::parse($dateOfBirth)->age;
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => User::count(),
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
        $viewData = array(
            'pageName' => 'Add User',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'add user',
                    'class' => '',
                    'url' => route('admin.users.index')
                ),
                (object)array(
                    'name' => 'Add New User',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.users.addedituser')->with($viewData);
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
            'email' => 'required',
            'gsmno' => 'required',
            'idno' => 'required',
            'address' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'sponsor_id' => 'required|mimes:png,jpg,jpeg,pdf',
            'marriage_certificate' => 'required|mimes:png,jpg,jpeg,pdf',
            'salary_certificate' => 'required|mimes:png,jpg,jpeg,pdf'
            

        ]);


        if ($validator->fails()) {
            return Redirect()->route("admin.users.create")->with('error', $validator->errors());
        }


        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $name = $first_name . ' ' . $last_name;

        $email = $request->email;
        $gsm_no = $request->gsmno;
        $id_no = $request->idno;
        $address = $request->address;
        $dob = $request->dob;

  

        $gender = $request->gender;
        $user_type = $request->user_type;
        $user_status = $request->user_status;
        $hire_labor_status = 3;


        $user = new User;
 
        if ($request->file('sponsor_id')) {
            // $sponsor_id = $input['sponsor_id'];
            $sponsor_id = $request->sponsor_id;
            $sponsor_id_original = $sponsor_id->getClientOriginalName();
            $sponsor_id_unique = time() . '_' . $sponsor_id_original;
            $destinationsponsorid = public_path('/images/users/user_sponsor_id');
            $sponsor_id_nospace = preg_replace('/\s+/', '', $sponsor_id_unique);
            $sponsor_id->move($destinationsponsorid, $sponsor_id_nospace);
            $user->sponsor_id = $sponsor_id_nospace;
        }

        if ($request->file('salary_certificate')) {
            $salary_certificate = $request->salary_certificate;
            // $salary_certificate = $input['salary_certificate'];
            $salary_certificate_original = $salary_certificate->getClientOriginalName();
            $salary_certificate_unique = time() . '_' . $salary_certificate_original;
            $destinationsal = public_path('/images/users/user_salary_certificate');
            $salary_certificate_nospace = preg_replace('/\s+/', '', $salary_certificate_unique);
            $salary_certificate->move($destinationsal, $salary_certificate_nospace);
            $user->salary_certificate = $salary_certificate_nospace;
        }
        
        if ($request->file('marriage_certificate')) {
            $marriage_certificate = $request->marriage_certificate;
            // $marriage_certificate = $input['marriage_certificate'];
            $marriage_certificate_original = $marriage_certificate->getClientOriginalName();
            $marriage_certificate_unique = time() . '_' . $marriage_certificate_original;
            $destinationmarr = public_path('/images/users/user_marriage_certificate');
            $marriage_certificate_nospace = preg_replace('/\s+/', '', $marriage_certificate_unique);
            $marriage_certificate->move($destinationmarr, $marriage_certificate_nospace);
            $user->marriage_certificate = $marriage_certificate_nospace;
        }
        // $user->sponsor_id = $sponsor_id_nospace;  
        // $user->salary_certificate = $salary_certificate_nospace;
        // $user->marriage_certificate = $marriage_certificate_nospace;

    
        $user->name = $name;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->gsm_no = $gsm_no;
        $user->id_no = $id_no;
        $user->address = $address;
        $user->dob = $dob;
        $user->gender = $gender;

        $user->user_type = $user_type;
        $user->status = $user_status;
        $user->hire_labor_status = $hire_labor_status;

        $age = Carbon::parse($dob)->age;


   
        
        


        if (User::where('id_no', $request->idno)->exists()) {

            return Redirect()->route("admin.users.index")->with('success', 'User with this passport number already exist');
        } elseif($age > 20) {
            $user->save();
            return Redirect()->route("admin.users.index")->with('success', 'User added successfully');
        }else{
            return Redirect()->route("admin.users.index")->with('success', 'Age must be greater than 20');
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
        $user = User::findOrFail($id);
        $viewData = array(
            'pageName' => 'Edit User',
            'user' => $user,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'edit user',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.users.addedituser')->with($viewData);
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


        $user = User::findorfail($id);

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $name = $first_name . ' ' . $last_name;

        $email = $request->email;
        $gsm_no = $request->gsmno;
        $id_no = $request->idno;
        $address = $request->address;
        $dob = $request->dob;
        $gender = $request->gender;
        $user_type = $request->user_type;
        $user_status = $request->user_status;

        if($request->has('labor_hire_status')){
            $hire_labor_status = $request->labor_hire_status;
        }

        if($request->has('labor_add_status')){
            $labor_add_status = $request->labor_add_status;
        }


        // dd($request->all());

        if ($request->hasfile('sponsor_id')) {
            $sponsor_id = $request->sponsor_id;
            
            $sponsor_id_original = $sponsor_id->getClientOriginalName();
            $sponsor_id_unique = time() . '_' . $sponsor_id_original;
            $destinationsponsorid = public_path('/images/users/user_sponsor_id');
            $sponsor_id->move($destinationsponsorid, $sponsor_id_unique);
            $sponsor_id_nospace = preg_replace('/\s+/', '', $sponsor_id_unique);

            $user->sponsor_id = $sponsor_id_nospace;
        }

        if ($request->hasfile('salary_certificate')) {
            $salary_certificate = $request->salary_certificate;
            $salary_certificate_original = $salary_certificate->getClientOriginalName();
            $salary_certificate_unique = time() . '_' . $salary_certificate_original;
            $destinationsal = public_path('/images/users/user_salary_certificate');
            $salary_certificate->move($destinationsal, $salary_certificate_unique);
            $salary_certificate_nospace = preg_replace('/\s+/', '', $salary_certificate_unique);
      
            $user->salary_certificate = $salary_certificate_nospace;
        }

        if ($request->hasfile('marriage_certificate')) {
            $marriage_certificate = $request->marriage_certificate;
            $marriage_certificate_original = $marriage_certificate->getClientOriginalName();
            $marriage_certificate_unique = time() . '_' . $marriage_certificate_original;
            $destinationmarr = public_path('/images/users/user_marriage_certificate');
            $marriage_certificate->move($destinationmarr, $marriage_certificate_unique);
            $marriage_certificate_nospace = preg_replace('/\s+/', '', $marriage_certificate_unique);
          
            $user->marriage_certificate = $marriage_certificate_nospace;

        }


        $user->name = $name;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->gsm_no = $gsm_no;
        $user->id_no = $id_no;
        $user->address = $address;
        $user->dob = $dob;
        $user->gender = $gender;
        $user->user_type = $user_type;
        $user->profile_status = 3;
        $user->hire_labor_status = $hire_labor_status;
        $user->add_labor_status = $user_status;
        $user->add_labor_status = $labor_add_status;
        $user->status = $user_status;
        $age = Carbon::parse($dob)->age;


        if ($age > 20) {
            $user->save();
            return Redirect()->route("admin.users.index")->with('success', 'User Updated successfully');
        } else {
            return Redirect()->route("admin.users.index")->with('success', 'Age must be greater than 20');
        }


        // $user->save();
        // return Redirect()->route("admin.users.index")->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function checkNumber(Request $request)
    {
        $number = $request->number;
        $exist = DB::table('users')->where('id_no', $number)->exists();

        if($exist){
            return response()->json(['exists' => $exist]);
        }
    }


}
