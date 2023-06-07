<x-admin-layout>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <x-slot name="pageName">{{ $pageName }}</x-slot>
  <x-slot name="breadCrumbs">
    <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs" />
  </x-slot>




  <section class=" p-3 mt-5 d-flex justify-content-center">


    <form method="post" action="{{route('admin.searchlabors.labors')}}">
      @csrf
      <div class="form-row">

        <div class="form-group col-md-2">
          <label>Passport Number</label>
          <input type="text" name="pass_no" id="pass_no" class="form-control" placeholder="Passport number"
            id="user_id_no" minlength="9" maxlength="9">

        </div>


        <div class="col-md-2">
          <label for="exampleFormControlSelect1">Service</label>
          <select class="form-control" id="service" name="service">
            @foreach ($services as $item)
            <option>{{$item->title}}</option>
            @endforeach
          </select>
        </div>



        <div class="col-md-2">
          <label for="nationality">Nationality</label>
          <select class="form-control" name="nationality" id="nationality">
            @foreach ($labor as $item)
            <option>{{$item->nationality}}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label for="exampleFormControlSelect1">Religion</label>
          <select class="form-control" id="religion" name="religion">
            @foreach ($labor as $item)
            <option>{{$item->religion}}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label for="exampleFormControlSelect1">Job type</label>
          <select class="form-control" id="job_type" name="job_type">
            <option>Part time</option>
            <option>Full time</option>

          </select>
        </div>


        <div class="col-md-2">
          <label for="exampleFormControlSelect1">Gender</label>
          <select class="form-control" id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>

          </select>
        </div>

        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="send-btn">Submit</button>
        </div>


      </div>
    </form>


  </section>



  <section id="myTable" class="container mt-5 p-2">

    <table class="table">
      <thead>
        <tr class="bg-dark text-light">
          <th scope="col">ID</th>
          <th scope="col">NAME</th>
          <th scope="col">Passport Number</th>
          <th scope="col">Gender</th>
          <th scope="col">Education </th>
          <th scope="col">Job Type</th>
          <th scope="col">Occupation</th>
          <th scope="col">Marital Status</th>
          <th scope="col">Nationality</th>
          {{-- <th scope="col">Action</th> --}}
        </tr>
      </thead>
      <tbody>
        @if (@$labors)
        @foreach ($labors as $labor)

        <tr>
          <th scope="row">{{$labor->id}}</th>
          <td>{{$labor->labor_first_name .' '. $labor->labor_last_name }}</td>
          <td>{{$labor->passport_no}}</td>
          <td>{{$labor->gender}}</td>
          <td>{{$labor->education}}</td>
          <td>{{$labor->job_type}}</td>

          <td>
            @php

            $services = DB::table('ourservices')->where('id',$labor->occupation)->first();
            echo $services->title;

            @endphp

          </td>
          {{-- <td>{{$labor->occupation}}</td> --}}


          <td>{{$labor->marital_status}}</td>
          <td>{{$labor->nationality}}</td>
        </tr>

        @endforeach
        @else
        <tr>
          <th scope="row"></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>

        </tr>
        @endif


      </tbody>
    </table>

  </section>






  <x-slot name="pluginCss"></x-slot>
  <x-admin.tinymce />
</x-admin-layout>