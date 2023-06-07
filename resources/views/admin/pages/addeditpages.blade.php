<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>  
    </x-slot>

    <div class="dealership-form">
        <form class="myform" method="POST" action="{{ !empty($service)? route('admin.pages.update', ['id' => $service->id]) : route('admin.pages.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                
                <div class="clearfix"></div>
                <div class="form-group col-md-12">
                    <label class="p-2 mb-2">Title</label>
                    <input type="text" name="title" class="form-control " rows="5" value="{{ @$service->title }}" required>
                        
                    
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-md-12">
                    <label class="p-2 mb-2">Slug</label>
                    <input type="text" name="slug" class="form-control" rows="5" value="{{ @$service->slug }}" required>
                        
                    
                </div>
                
                
                <div class="clearfix"></div>
                <div class="form-group col-md-12">
                    <label class=" p-2 mb-2">Details</label>
                    <textarea name="description" class="form-control tinymceeditor" rows="5" required>
                        {{htmlspecialchars_decode(html_entity_decode(@$service->description))}}
                    </textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.pages.index') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>

    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('terms');
        ckfinder.setupCDEditor('editor');
        </script>
    {{-- ////////////////////// mine /////////////// --}}


    <div id="editor"></div>



    <x-slot name="pluginCss"></x-slot>
    <x-admin.tinymce/>
</x-admin-layout>
