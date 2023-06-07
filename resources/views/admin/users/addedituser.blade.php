<x-admin-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs" />
    </x-slot>

 {{-- <div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
    An example danger alert with an icon
  </div>
</div> --}}

    <div class="dealership-form">
        <form class="myform" method="POST" action="{{ !empty($user)? route('admin.users.update', ['id' => @$user->id]) : route('admin.users.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>First Name</label>
                    <input maxlength="255" type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ @$user->first_name }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Last Name</label>
                    <input maxlength="255" type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ @$user->last_name }}" required>
                </div>


                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input maxlength="255" type="email" name="email" class="form-control" placeholder="Email" value="{{ @$user->email }}" required>
                </div>


                <div class="form-group col-md-6">
                    <label>GSM NO</label>
                    <input maxlength="255" type="tel" name="gsmno" class="form-control" placeholder="GSM NO" value="{{ @$user->gsm_no }}" required>
                </div>


                <div class="form-group col-md-6">
                    <label>ID NO</label>
                    <input  type="text" name="idno" class="form-control" placeholder="ID NO" value="{{ @$user->id_no }}" required id="user_id_no" minlength="9" maxlength="9">
                    <small id="user_id_no_error" class="text-danger"></small>
                </div>


                <div class="form-group col-md-6">
                    <label>Address</label>
                    <input maxlength="255" type="text" name="address" class="form-control" placeholder="Address" value="{{ @$user->address }}" required>
                </div>


                <div class="form-group col-md-6">
                    <label>Date of Birth </label>
                    <input type="date" name="dob" class="form-control" placeholder="DOB" value="{{ @$user->dob }}" required>
                </div>


                <div class="form-group col-md-6">
                    <label>Gender</label>
                    <select class=" form-control" name="gender">

                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label>User type</label>
                    <select class=" form-control" name="user_type">

                        <option value="user">User</option>
                        <option value="admin">Admin</option>

                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label>User status</label>
                    <select class=" form-control" name="user_status">

                        <option value="0" <?php echo @$user->status == '1' ? 'selected' : ''; ?>>Inactive</option>
                        <option value="1" <?php echo @$user->status == '0' ? 'selected' : ''; ?>>Active</option>

                    </select>
                </div>

                <div class="row col-md-12 mt-3 ">
                    <div class="form-group col-md-6">
                        <label>Sponsor ID</label>
                        <input type="file" name="sponsor_id" class="form-control" placeholder="Sponsor ID" value="{{asset('images/users/user_sponsor_id')}}{{'/' . @$user->sponsor_id}}">
                    </div>

                    <div class="col-md-6" style="display: flex; align-items:center">
                        <div class="form-group col-md-6">
                            @if(@$user->sponsor_id)
                            <label>Sponsor ID</label>
                           <a href="{{asset('images/users/user_sponsor_id')}}{{'/' . $user->sponsor_id}}" download class="btn btn-primary bg-primary pt-1 pb-1 pl-2 pr-2 text-light">Download</a>
                           {{-- <img src="{{asset('images/users/user_sponsor_id')}}{{'/' . $user->sponsor_id}}" alt="" srcset="" style="width: 150px; height: 150px;"> --}}

                            @else
                            <img src="{{asset('/img/placeholder-img.png')}}" alt="" srcset="" style="width: 150px; height: 150px;">
                            @endif
                        </div>
                    </div>
                </div>



                <div class="row col-md-12 mt-3 ">

                    <div class="form-group col-md-6">
                        <label>Marriage_certificate</label>
                        <input type="file" name="marriage_certificate" class="form-control" placeholder="Marriage Certificate" value="{{asset('images/users/marriage_certificate' . @$user->marriage_certificate)}}">
                    </div>

                    <div class="col-md-6" style="display: flex; align-items:center">
                        <div class="form-group col-md-6">

                            @if(@$user->marriage_certificate)
                            {{-- <img src="{{asset('/images/users/user_marriage_certificate')}}{{'/' . $user->marriage_certificate}}" alt="" srcset="" style="width: 150px; height: 150px;"> --}}
                            <label>Marriage_certificate</label>
                            <a href="{{asset('/images/users/user_marriage_certificate')}}{{'/' . $user->marriage_certificate}}" download class="btn btn-primary bg-primary pt-1 pb-1 pl-2 pr-2 text-light">Download</a>

                            @else
                            <img src="{{asset('/img/placeholder-img.png')}}" alt="" srcset="" style="width: 150px; height: 150px;">

                            @endif
                        </div>
                    </div>

                </div>

                <div class="row col-md-12 mt-3 ">

                    <div class="form-group col-md-6">
                        <label>Salary Certificate</label>
                        <input type="file" name="salary_certificate" class="form-control" placeholder="ID Front" value="{{asset('images/users/user_salary_certificate' . @$user->salary_certificate)}}">
                    </div>

                    <div class="col-md-6" style="display: flex; align-items:center">
                        <div class="form-group col-md-6 " >

                            @if(@$user->salary_certificate)

                           {{-- <img src="{{asset('/images/users/user_salary_certificate')}}{{'/' . $user->salary_certificate}}" alt="" srcset="" style="width: 150px; height: 150px;"> --}}
                           <label>Salary Certificate</label>
                           <a href="{{asset('/images/users/user_salary_certificate')}}{{'/' . $user->salary_certificate}}" download class="btn btn-primary bg-primary pt-1 pb-1 pl-2 pr-2 text-light">Download</a>

                            @else
                            <img src="{{asset('/img/placeholder-img.png')}}" alt="" srcset="" style="width: 150px; height: 150px;">

                            @endif
                        </div>
                    </div>

                </div>

                <div class="form-group col-md-6">
                    <label>ID verified (labor add)</label>
                    <select class=" form-control" name="labor_add_status">

                        <option value="1"  <?php echo @$user->profile_status == '1' ? 'selected' : ''; ?>>Yes</option>
                        <option value="0"  <?php echo @$user->profile_status == '0' ? 'selected' : ''; ?>>No</option>

                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label>Profile verified (labor hire)</label>
                    <select class=" form-control" name="labor_hire_status">

                        <option value="1"  <?php echo @$user->hire_labor_status == '1' ? 'selected' : ''; ?>>Yes</option>
                        <option value="0"  <?php echo @$user->hire_labor_status == '0' ? 'selected' : ''; ?>>No</option>

                    </select>
                </div>
       
      <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        {{-- <a href="{{ route('admin.users.index') }}" class="cancle-btn">Back</a> --}}
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>

    </div>



    <script>
        $(document).ready(function() {
            $('#user_id_no').on('keyup', function() {
                $('#user_id_no_error').html('');

                var number = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    type: 'get',
                    url: "{{ route('users.checknumber') }}",
                    data: {
                        'number': number
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#user_id_no_error').html('');
                            $('#user_id_no_error').html('User id card number already exist');
                        } else {
                            $('#user_id_no_error').html('');
                        }
                    }
                });
            });
        });
    </script>


    <x-slot name="pluginCss"></x-slot>
    <x-admin.tinymce />
</x-admin-layout>