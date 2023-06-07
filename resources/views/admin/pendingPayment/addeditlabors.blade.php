<x-admin-layout>
  <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs" />
    </x-slot>

    <div class="dealership-form">





        <form class="myform" method="POST" action="{{ !empty($labor)? route('admin.labors.update', ['id' => $labor->id]) : route('admin.labors.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">


                <div class="form-group col-md-6">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control " value="{{ @$labor->labor_first_name }}" pattern="[A-Za-z ]+" required >
                </div>




                <div class="form-group col-md-6">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control " value="{{ @$labor->labor_last_name }}" required pattern="^[a-zA-Z ]+$">
                </div>


                <div class="row col-md-12 mt-3 ">
                    <div class="form-group col-md-6">
                        <label>Labor Photo</label>
                        <input type="file" name="labor_photo" class="form-control ">
                    </div>

                    <div class="form-group col-md-6">


                        @if(@$labor->labor_photo)
                        
                        <img src="{{asset('/images/labors')}}{{'/' . $labor->labor_photo}}" alt="" srcset="" style="width: 150px; height: 150px;">

                        @else
                        <img src="{{asset('/img/placeholder-img.png')}}" alt="" srcset="" style="width: 150px; height: 150px;">
                        
                        @endif
                    </div>
                </div>

                <div class="row col-md-12 mb-3">
                    <div class="form-group col-md-6">
                        <label>Passport Photo</label>
                        <input type="file" name="labor_passport_photo" class="form-control " >
                    </div>

                    <div class="form-group col-md-6">
                    @if(@$labor->passport_copy)
                        
                        <img src="{{asset('/images/labors')}}{{'/' . $labor->passport_copy}}" alt="" srcset="" style="width: 150px; height: 150px;">

                        @else
                        <img src="{{asset('/img/placeholder-img.png')}}" alt="" srcset="" style="width: 150px; height: 150px;">
                        
                        @endif
                </div>

                <div class="form-group col-md-6">
                    <label>Gender</label>
                    <select class=" form-control" name="gender">

                        <option value="male" {{ @$labor->gender == "male" ? "selected" : "" }} >Male</option>
                        <option value="female" {{ @$labor->gender == "female" ? "selected" : "" }}>Female</option>
                        <option value="other" {{ @$labor->gender == "other" ? "selected" : "" }}>Other</option>

                    </select>
                </div>

                {{-- <div class="form-group col-md-6">
                    <label>Passport Number</label>
                    <input type="text" name="pass_no" id="pass_no" class="form-control " value="{{ @$labor->passport_no }}" min="0" maxlength="9" minlength="9"   required  pattern="[0-9]+">
                    <small id="passport_error" class="text-danger"></small>
                </div> --}}

                <div class="form-group col-md-6">
                    <label>Passport Number</label>
                    <input  type="text" name="pass_no" id="pass_no" class="form-control" placeholder="Passport number" value="{{ @$labor->passport_no }}" required id="user_id_no" minlength="9" maxlength="9">
                    <small id="passport_error" class="text-danger"></small>
                </div>


                <div class="form-group col-md-6">
                    <label>Experience</label>
                    <input type="number" name="experience" class="form-control " value="{{ @$labor->experience }}" min="0" required>
                </div>



                @php
                 $countries = DB::table('countries')->get();   
                @endphp
                {{-- <div class="form-group col-md-6">
                    <label>Nationality</label>
                    <input type="text" name="nationality" class="form-control " value="{{ @$labor->nationality }}" required pattern="[A-Za-z ]+">
                </div> --}}


                <div class="form-group col-md-6">
                    <label>Nationality</label>
                    <select class=" form-control" name="nationality" >

                       
                        @foreach ($countries as $country)
                            <option value="{{ $country->name }}" {{ $country->name  == @$labor->nationality ? "selected" : "" }}> {{ $country->name }}</option>
                        @endforeach

                    </select>
                </div>



                <div class="form-group col-md-6">
                    <label>Religion</label>
                    <input type="text" name="religion" class="form-control " value="{{ @$labor->religion }}" required pattern="[A-Za-z ]+">
                </div>

                <div class="form-group col-md-6">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control" placeholder="DOB" value="{{ @$labor->dob }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control " value="{{ @$labor->address }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Monthly salary</label>
                    <input type="number" name="monthly_salary" class="form-control " value="{{ @$labor->monthly_salary }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Marital Status</label>
                    <select class=" form-control" name="marital_status" value="{{ @$labor->marital_status }}">

                        <option value="Married" {{ @$labor->marital_status == "Married" ? "selected" : "" }}>Married</option>
                        <option value="Unmarried" {{ @$labor->marital_status == "Unmarried" ? "selected" : "" }}>Unmarried</option>

                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label>Occupation</label>
                    <select class=" form-control" name="occupation" >

                       
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" {{ @$labor->occupation == $service->id ? "selected" : "" }}> {{ $service->title }}</option>
                        @endforeach

                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label>Application type</label>
                    <select class=" form-control" name="app_type" value="{{ @$labor->app_type }}">

                        <option value="New" {{ @$labor->application_type == "New" ? "selected" : "" }}>New</option>
                        <option value="sponsorship transfer" {{ @$labor->application_type == "sponsorship transfer" ? "selected" : "" }}>sponsorship transfer</option>
                        <option value="Ready in Office" {{ @$labor->application_type == "Ready in Office" ? "selected" : "" }}>Ready in Office</option>

                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label>Job type</label>
                    <select class=" form-control" name="job_type" value="{{ @$labor->job_type }}">
                        <option value="part time" {{ @$labor->job_type == "part time" ? "selected" : "" }}>Part time</option>
                        <option value="full time" {{ @$labor->job_type == "full time" ? "selected" : "" }}>Full time</option>

                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label>Education</label>
                    <select class=" form-control" name="education" value="{{ @$labor->education }}">
                        <option value="No formal education" {{ @$labor->education == "No formal education" ? "selected" : "" }}>No formal education</option>

                        <option value="Primary education" {{ @$labor->education == "Primary education" ? "selected" : "" }}>Primary education</option>


                        <option value="Secondary education or high school" {{ @$labor->education == "Secondary education or high school" ? "selected" : "" }}>Secondary education or high school</option>

                        <option value="GED" {{ @$labor->education == "GED" ? "selected" : "" }}>GED</option>


                        <option value="Vocational qualification" {{ @$labor->education == "Vocational qualification" ? "selected" : "" }}>Vocational qualification</option>

                        <option value="Bachelor\'s degree" {{ @$labor->education == "Bachelor\'s degree" ? "selected" : "" }}>Bachelor\'s degree</option>

                        <option value="Master\'s degree" {{ @$labor->education == "Master\'s degree" ? "selected" : "" }}>Master\'s degree</option>

                        <option value="Doctorate or higher" {{ @$labor->education == "Doctorate or higher" ? "selected" : "" }}>Doctorate or higher</option>
                        

                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label>Labor Sponsorship Transfer Fee</label>
                    <input type="number" name="labor_sponsorship_transfer_fee" class="form-control " value="{{ @$labor->labor_sponsorship_transfer_fee }}" required>
                </div>


                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        {{-- <a href="{{ route('admin.labors.index') }}" class="cancle-btn">Back</a> --}}
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>


            </div>
        </form>

    </div>

    <script>
        $(document).ready(function() {
    $('#pass_no').on('keyup', function() {
        $('#passport_error').html('');
        
        var number = $(this).val();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
                  });


        $.ajax({
            type: 'post',
            url: "{{ route('labors.checknumber') }}",
            data: { 'number': number },
            success: function(response) {
                if (response.exists) {
                   $('#passport_error').html('');
                   $('#passport_error').html('Passport Number already exist');
                } else {
                   

                }
            }
        });
    });
});

    </script>

    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('terms');
        ckfinder.setupCDEditor('editor');
    </script>
    {{-- ////////////////////// mine /////////////// --}}


    <div id="editor"></div>



    <x-slot name="pluginCss"></x-slot>
    <x-admin.tinymce />
</x-admin-layout>