<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <div class="dealership-form">
        <form class="myform" method="POST" action="{{ !empty($portfolio)? route('admin.portfolio.update', ['id' => $portfolio->id]) : route('admin.portfolio.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Name</label>
                    <input maxlength="255" type="text" name="title" class="form-control" required placeholder="Name" value="{{ @$portfolio->title }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Service</label>
                    <select class="form-control" id="categories" name="service_id_fk" required>
                        @foreach ($categories as $service)
                        <option value="{{ $service->id }}" {{ @$portfolioId == $service->id || @$portfolio->service_id_fk == $service->id? 'selected' : '' }}>{{ $service->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Order #</label>
                    <input type="number" name="order_no" class="form-control" placeholder="Order #" min="1" value="{{ @$portfolio->order_no }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Featured Image <a href="javascript:;" id="selectimage" class="edit-logo" onclick="selectImage('featured_image');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="featured_image" id="featured_image" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('featured_image');" src="{{ !empty($portfolio) && $portfolio->featured_image != ''? $portfolio->featured_image : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Meta Title</label>
                    <input maxlength="255" type="text" name="meta_title" class="form-control" placeholder="Meta Title" value="{{ @$portfolio->meta_title }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Meta Description</label>
                    <input maxlength="255" type="text" name="meta_description" class="form-control" placeholder="Meta Description" value="{{ @$portfolio->meta_description }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-12">
                    <label>Details</label>
                    <textarea name="description" class="form-control tinymceeditor" rows="5">{{ @$portfolio->description }}</textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.portfolio.index') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <x-slot name="pluginCss">
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    </x-slot>
    <x-admin.tinymce/>
    <style>
        .deleteicon{
            position: absolute;
            background: rgb(255 0 0 / 59%);
            color: #fff;
            padding: 5px;
            border-radius: 5px;
            cursor:pointer;
        }
        .deleteicon:hover{
            background: #FF0000;
        }
    </style>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#categories").select2();
            $(document).on('click', '.deleteicon', function() {
                var url = $(this).data('url');
                swal.fire({
                    title: 'Are you sure you want to delete this image?',
                    text: "This action cannot be undone",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (result.value) {
                        window.location.href = url;
                    } else {
                        return false;
                    }
                });
            });
        });
    </script>
</x-admin-layout>
