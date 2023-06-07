<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <div class="dealership-form">
        <form class="myform" method="POST" action="{{ !empty($section)? route('admin.section.update', ['id' => $section->id]) : route('admin.section.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Name</label>
                    <input maxlength="255" type="text" name="title" class="form-control" required placeholder="Name" value="{{ @$section->title }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-12">
                    <label>Details</label>
                    <textarea name="description" class="form-control tinymceeditor" rows="5">{{ @$section->description }}</textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.section.index') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <x-slot name="pluginCss"></x-slot>
    <x-admin.tinymce/>
</x-admin-layout>
