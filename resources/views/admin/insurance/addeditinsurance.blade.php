<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <form class="myform" method="POST" action="{{ route('admin.insurance.update', ['id' => $insurance->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="dealership-form">
            <div class="form-row">
                <div class="form-group col-md-12"><h6>Header</h6></div>
                <div class="clearfix"></div>
         
                <div class="form-group col-md-6">
                    <label>Title</label>
                    <input maxlength="255" type="text" name="section1_title1" class="form-control" placeholder="section1_title1" value="{{ @$insurance->section1_title1}}">
                    <label>Title2</label>
                    <input maxlength="255" type="text" name="section1_title2" class="form-control" placeholder="section1_title2" value="{{ @$insurance->section1_title2}}">
                    <label>Description</label>
                    <textarea name="section1_description" id="section1_description" class="form-control" placeholder="section1_description"> {{ @$insurance->section1_description}} </textarea>
                </div>
                
                <div class="form-group col-md-6">
                    <label>Section1 Image <a href="javascript:;" class="edit-logo" onclick="selectImage('section1_image');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="section1_image" id="section1_image" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="width: 250px;height: 150px; cursor: pointer"  onclick="selectImage('section1_image');" src="{{ !empty($insurance->section1_image)? $insurance->section1_image : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                </div> 

                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.dashboard') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="dealership-form">
            <div ><h6>EBP</h6></div>
            <div class="form-row">
                <!-- <div class="clearfix"></div> -->
                <!-- <div class="form-row"> -->
                <div class="form-group col-md-12">
                    <label>Main Title</label>
                    <input maxlength="255" type="text" name="plan_main_title" class="form-control" placeholder="Main Title" value="{{ @$insurance->section2_title}}">
                    <label>Compare Our Plans</label>
                    <input maxlength="255" type="text" name="our_plans" class="form-control" placeholder="Compare Our Plans" value="{{ @$insurance->section2_title}}">
                    <label>Main Description</label>
                    <textarea name="plan_main_description" id="plan_description" class="form-control" placeholder="Main Description"> {{ @$insurance->section2_description}} </textarea>
                </div>
                <div class="form-group col-md-12"><h6>Plans</h6>
                <a href="javascript:;" class="action-btn add-specification-btn2">Plans</a>
                <div class="specifications-div2"></div> 
                <!-- </div> -->
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.dashboard') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>  
        <div class="dealership-form">
            <div class="form-row">
                <div class="form-group col-md-12"><h6>HALA</h6></div>
                <div class="clearfix"></div>
         
                <div class="form-group col-md-6">
                    <label>Title</label>
                    <input maxlength="255" type="text" name="section2_title" class="form-control" placeholder="section2_title" value="{{ @$insurance->section2_title}}">
                </div>
                <div class="form-group col-md-6">
                    <label>Description</label>
                    <textarea name="section2_description" id="section2_description" class="form-control" placeholder="section2_description"> {{ @$insurance->section2_description}} </textarea>
                </div>
     
                <div class="form-group col-md-6">
                    <label>Button Text</label>
                    <input maxlength="255" type="text" name="section2_buttontext" class="form-control" placeholder="section2_buttontext" value="{{ @$insurance->section2_buttontext}}">
                </div>
                <div class="form-group col-md-6">
                    <label>Button Path</label>
                    <input maxlength="255" type="text" name="section2_buttontext" class="form-control" placeholder="section2_buttontext" value="{{ @$insurance->section2_buttontext}}">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.dashboard') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="dealership-form">
            <div class="form-row">
                <div class="form-group col-md-12"><h6>Our Network</h6></div>
                <div class="clearfix"></div>
                <div class="form-group col-md-4">
                    <label>Image <a href="javascript:;" class="edit-logo" onclick="selectImage('section3_image');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="section3_image" id="section3_image"/>
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="width: 250px;height: 200px; cursor: pointer"  onclick="selectImage('section3_image');" src="{{ !empty($insurance->section3_image)? $insurance->section3_image : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                </div> 
         
                <div class="form-group col-md-8">
                    <label>Title</label>
                    <input maxlength="255" type="text" name="section3_title" class="form-control" placeholder="section3_title" value="{{ @$insurance->section3_title}}">
                    <label>Description</label>
                    <textarea name="section3_description" id="section2_description" class="form-control" placeholder="section3_description"> {{ @$insurance->section3_description}}</textarea>
                    <label>Button Text</label>
                    <input maxlength="255" type="text" name="section3_buttontext" class="form-control" placeholder="section3_buttontext" value="{{ @$insurance->section3_buttontext}}">

                    <label>Button Path</label>
                    <input maxlength="255" type="text" name="section2_buttontext" class="form-control" placeholder="section2_buttontext" value="{{ @$insurance->section2_buttontext}}">
</div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.dashboard') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="dealership-form">
            <div class="form-row">

            <div class="addmore4-div"></div>
                <div class="form-group col-md-12"><h6>Our Promise to You</h6></div>
                <div class="clearfix"></div>
         
                <div class="form-group col-md-12">
                    <label>Title</label>
                    <input maxlength="255" type="text" name="section4_main_title" class="form-control" placeholder="Title" value="{{ @$insurance->section4_main_title }}">
                </div>
      
                <div class="form-group col-md-3">

                    <label>Image <a href="javascript:;" class="edit-logo" onclick="selectImage('section4_1_image');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="section4_1_image" id="section4_1_image" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('section4_1_image');" src="{{ !empty($insurance->section4_1_image)? $insurance->section4_1_image : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                    <label>Title</label>
                    <input maxlength="255" type="text" name="section4_1_title" class="form-control" placeholder="section4_1_title" value="{{ @$insurance->section4_1_title }}">
                    <label>Decription</label>
                    <textarea name="section4_1_decription" id="section4_1_decription" class="form-control" placeholder="Decription"> {{@$insurance->section4_1_decription }}</textarea>
                    <label>Button Text</label>
                    <input maxlength="255" type="text" name="section4_1_buttontext" class="form-control" placeholder="Buttontext" value="{{ @$insurance->section4_1_buttontext }}">
                </div>
                <div class="clearfix"></div>

                <div class="form-group col-md-3" id="div1">
                    <label>Image <a href="javascript:;" class="edit-logo" onclick="selectImage('section4_2_image');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="section4_2_image" id="section4_2_image" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('section4_2_image');" src="{{ !empty($insurance->section4_2_image)? $insurance->section4_2_image : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                    <label>Title</label>
                    <input maxlength="255" type="text" name="section4_2_title" class="form-control" placeholder="section4_2_title" value="{{ @$insurance->section4_2_title }}">
                    <label>Decription</label>
                    <textarea name="section4_2_decription" id="section4_1_decription" class="form-control" placeholder="Decription"> {{@$insurance->section4_2_decription }}</textarea>
                    <label>Buttontext</label>
                    <input maxlength="255" type="text" name="section4_2_buttontext" class="form-control" placeholder="Buttontext" value="{{ @$insurance->section4_2_buttontext }}">
                </div> 
                <div class="clearfix"></div>

                <div class="form-group col-md-3" id="div1">
                    <label>Image <a href="javascript:;" class="edit-logo" onclick="selectImage('section4_3_image');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="section4_3_image" id="section4_3_image" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('section4_3_image');" src="{{ !empty($insurance->section4_3_image)? $insurance->section4_3_image : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                    <label>Title</label>
                    <input maxlength="255" type="text" name="section4_3_title" class="form-control" placeholder="section4_3_title" value="{{ @$insurance->section4_3_title }}">
                    <label>section4_3_decription</label>
                    <textarea name="section4_3_decription" id="section4_3_decription" class="form-control" placeholder="Decription"> {{ @$insurance->section4_3_decription }}</textarea>
                    <label>Buttontext</label>
                    <input maxlength="255" type="text" name="section4_3_buttontext" class="form-control" placeholder="Buttontext" value="{{ @$insurance->section4_3_buttontext }}">
                </div> 
                <div class="clearfix"></div>

                <div class="form-group col-md-3" id="div1">
                    <label>Image <a href="javascript:;" class="edit-logo" onclick="selectImage('section4_4_image');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="section4_4_image" id="section4_4_image" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('section4_4_image');" src="{{ !empty($insurance->section4_4_image)? $insurance->section4_4_image : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                    <label>Title</label>
                    <input maxlength="255" type="text" name="section4_4_title" class="form-control" placeholder="Title" value="{{ @$insurance->section4_4_title }}">
                    <label>Decription</label>
                    <textarea name="section4_4_decription"  id="section4_4_decription" class="form-control" placeholder="section4_4_decription"> {{ @$insurance->section4_4_decription  }}</textarea>
                    <label>Buttontext</label>
                    <input maxlength="255" type="text" name="section4_4_buttontext" class="form-control" placeholder=uttontext" value="{{ @$insurance->section4_4_buttontext }}">
                </div> 
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.dashboard') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
            </div>  
                <div class="clearfix"></div>
                <div class="dealership-form">
             <div class="form-row">
                <div class="form-group col-md-12"><h6>Downloads</h6>
                <a href="javascript:;" class="action-btn add-specification-btn">Downloads</a>
                <div class="specifications-div"></div> 
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.dashboard') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="dealership-form">
             <div class="form-row">
                <div class="form-group col-md-12"><h6>FAQS</h6>
                <a href="javascript:;" class="action-btn add-specification-btn1">FAQS</a>
                <div class="specifications-div1"></div> 
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.dashboard') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>

                


       
    </form>
    <x-slot name="pluginCss">
        <link rel="stylesheet" href="{{ asset('plugins/codemirror/codemirror.css') }}">
    </x-slot>
    <style>
        .dealership-form{margin-bottom:15px;}.dealership-form:nth-last-child(1){margin-bottom:0px;}
        .CodeMirror {background:#EEF0F5;height:150px}
    </style>
    <script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
    <script>
        $(document).ready(function() {
            var header_scripts = CodeMirror.fromTextArea(document.getElementById("header_scripts"), {
                matchTags: {bothTags: true},
                matchBrackets: true,
                autoCloseTags: true
            });
            var body_start_scripts = CodeMirror.fromTextArea(document.getElementById("body_start_scripts"), {
                matchTags: {bothTags: true},
                matchBrackets: true,
                autoCloseTags: true
            });
            var body_end_scripts = CodeMirror.fromTextArea(document.getElementById("body_end_scripts"), {
                matchTags: {bothTags: true},
                matchBrackets: true,
                autoCloseTags: true
            });
        });
    </script>

<script>
var srow_no = 10001;
$(document).on('click','.add-specification-btn',function(){
	srow_no++;
	var specification_div = '<div class="form-group col-md-3 specification-row-'+srow_no+'">\
                    <label>Download Title</label>\
                    <input maxlength="255" type="text"  name="download_title" class="form-control" placeholder="download_title" value="">\
                    <textarea id="cked'+srow_no+'"></textarea>\
                    <div class="form-group col-md-3" id="div1">\
                    <label>section4_2_image <a href="javascript:;" class="edit-logo" onclick="selectImage(\'section4_2_image\');"><img class="img-fluid" src="<?= asset("img/pen.svg")?>" alt="Select Image"> Select File</a></label>\
                    <div style="display: none">\
                        <input type="file" name="section4_2_image" id="section4_2_image" />\
                    </div>\
                    <div class="update-logo">\
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage(\'section4_2_image\');" src="<?= !empty($insurance->section4_2_image)? $insurance->section4_2_image : asset('img/placeholder-img.png') ?>" alt="">\
                    </div>\
                </div>';
	$('.specifications-div').append(specification_div);

});
</script>
<script>
var srow_no = 10001;
$(document).on('click','.add-specification-btn1',function(){
	srow_no++;
	var specification_div1 = '<div class="form-group col-md-12 specification-row-'+srow_no+'">\
                    <label>Download Title</label>\
                    <input maxlength="255" type="text"  name="faqs_title" class="form-control" placeholder="Title" value="">\
                    <textarea id="cked1'+srow_no+'">Description</textarea>\
                </div>';
	$('.specifications-div1').append(specification_div1);
    CKEDITOR.replace('cked1'+srow_no);
	CKEDITOR.config.allowedContent = true;

});
</script>
<script>
var srow_no = 10001;
$(document).on('click','.add-specification-btn2',function(){
	srow_no++;
	var specification_div2 = '<div class="form-group col-md-12 specification-row-'+srow_no+'">'+
               ' <label>Title</label>'+
                   ' <input maxlength="255" type="text" name="plans_title" class="form-control" placeholder="Title" value="">'+
                   ' <label>Description</label>'+
                '    <textarea name="plans_description" id="cked2'+srow_no+'" class="form-control" placeholder="Description">  </textarea>'+
                   ' <label>Button Text</label>'+
                  '  <input maxlength="255" type="text" name="plan_buttontext" class="form-control" placeholder="Buttontext" value="">'+
                  ' <label>Button Path</label>'+
                  '  <input maxlength="255" type="text" name="plan_buttonpath" class="form-control" placeholder="Buttontext" value="">'+
                '</div>'
	$('.specifications-div2').append(specification_div2);
    CKEDITOR.replace('cked2'+srow_no);
	CKEDITOR.config.allowedContent = true;

});
</script>
<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script>
$(document).ready(function() {
	CKEDITOR.replaceClass = 'ckeditor';
	CKEDITOR.config.allowedContent = true;
});
</script>
</x-admin-layout>
