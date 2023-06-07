<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <div class="dealership-form">
        <form class="myform" method="POST" action="{{ !empty($testimonial)? route('admin.testimonial.update', ['id' => $testimonial->id]) : route('admin.testimonial.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Name</label>
                    <input type="text" name="title" class="form-control" placeholder="Name" value="{{ @$testimonial->title }}" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Review</label>
                    <textarea name="description" class="form-control" placeholder="Review" required>{{ @$testimonial->description }}</textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.testimonial.index') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <x-slot name="pluginCss"></x-slot>
</x-admin-layout>
