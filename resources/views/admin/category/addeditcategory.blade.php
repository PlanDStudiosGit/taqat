<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <div class="dealership-form">
        <form class="myform" method="POST" action="{{ !empty($category)? route('admin.category.update', ['id' => $category->id]) : route('admin.category.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Name</label>
                    <input maxlength="255" type="text" name="title" class="form-control" required placeholder="Name" value="{{ @$category->title }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Featured Image <a href="javascript:;" id="selectimage" class="edit-logo" onclick="selectImage('featured_image');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="featured_image" id="featured_image" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('featured_image');" src="{{ !empty($category)? $category->featured_image : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Meta Title</label>
                    <input maxlength="255" type="text" name="meta_title" class="form-control" required placeholder="Meta Title" value="{{ @$category->meta_title }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Meta Description</label>
                    <input maxlength="255" type="text" name="meta_description" class="form-control" required placeholder="Meta Description" value="{{ @$category->meta_description }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.category.index') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <x-slot name="pluginCss"></x-slot>
</x-admin-layout>
