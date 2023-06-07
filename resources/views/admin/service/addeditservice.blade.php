<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>  
    </x-slot>

    <div class="dealership-form">
        <form class="myform" method="POST" action="{{ !empty($service)? route('admin.ourservices.update', ['id' => $service->id]) : route('admin.ourservices.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">  
                <div class="form-group col-md-12">
                    <label>title</label>
                    <input maxlength="255" type="text" name="title" id="service_title" class="form-control" required placeholder="Name" value="{{ @$service->title }}" required>
                    <small id="services_title_error" class="text-danger"></small>

                </div> 

                <div class="form-group col-md-12">
                    <label>slug</label>
                    <input maxlength="255" type="text" name="slug" class="form-control" required placeholder="Name" value="{{ @$service->slug }}" required>
                </div> 

                

                               
                
                
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.ourservices.index') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>


    <script>
        $(document).ready(function() {
            $('#service_title').on('keyup', function() {
                $('#services_title_error').html('');

                var title = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    type: 'get',
                    url: "{{ route('services.checknumber') }}",
                    data: {
                        'title': title
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#services_title_error').html('');
                            $('#services_title_error').html('This service already exist');
                        } else {


                        }
                    }
                });
            });
        });
    </script>



    <x-slot name="pluginCss"></x-slot>
    <x-admin.tinymce/>
</x-admin-layout>
