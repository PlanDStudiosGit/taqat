<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <form class="myform" method="POST" action="{{ route('admin.setting.update', ['id' => $settings->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="dealership-form">
            <div class="form-row">
                <div class="form-group col-md-12"><h6>Homepage Header</h6></div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Website Logo <a href="javascript:;" class="edit-logo" onclick="selectImage('logo');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="logo" id="logo" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('logo');" src="{{ !empty($settings->logo)? $settings->logo : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Banner Image <a href="javascript:;" class="edit-logo" onclick="selectImage('home_banner_image');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="home_banner_image" id="home_banner_image" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('home_banner_image');" src="{{ !empty($settings->home_banner_image)? $settings->home_banner_image : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Mobile Banner Image <a href="javascript:;" class="edit-logo" onclick="selectImage('home_banner_image_mobile');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="home_banner_image_mobile" id="home_banner_image_mobile" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('home_banner_image_mobile');" src="{{ !empty($settings->home_banner_image_mobile)? $settings->home_banner_image_mobile : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Favicon <a href="javascript:;" class="edit-logo" onclick="selectImage('favicon');"><img class="img-fluid" src="{{ asset('img/pen.svg') }}" alt="Select Image"> Select File</a></label>
                    <div style="display: none">
                        <input type="file" name="favicon" id="favicon" />
                    </div>
                    <div class="update-logo">
                        <img class="img-thumbnail" style="height: 100px;cursor: pointer" onclick="selectImage('favicon');" src="{{ !empty($settings->favicon)? $settings->favicon : asset('img/placeholder-img.png') }}" alt="">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Homepage Banner Text Line 1</label>
                    <input maxlength="255" type="text" name="home_banner_line1" class="form-control" placeholder="Homepage Banner Text Line 1" value="{{ @$settings->home_banner_line1 }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Homepage Banner Text Line 2</label>
                    <input maxlength="255" type="text" name="home_banner_line2" class="form-control" placeholder="Homepage Banner Text Line 2" value="{{ @$settings->home_banner_line2 }}">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Email Address</label>
                    <input maxlength="255" type="text" name="email" class="form-control" placeholder="Email Address" value="{{ @$settings->email }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Phone Number</label>
                    <input maxlength="20" type="text" name="phone_number" class="form-control" placeholder="Phone Number" value="{{ @$settings->phone_number }}">
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

{{-- ////////////  --}}

        <div class="dealership-form">
            <div class="form-row">
                <div class="form-group col-md-12"><h6>Min Salary and Sponsorship fee</h6></div>
                <div class="clearfix"></div>
        
              
                <div class="form-group col-md-6">
                    <label>Sponsor Salary</label>
                    <input  type="number" name="min_salary" class="form-control" placeholder="Minimum sponsor salary" value="{{ @$settings->min_salary }}">
                </div>
                <div class="clearfix"></div>


                <div class="form-group col-md-6">
                    <label>Taqat sponsorship fee ( % )</label>
                    <input  type="number" name="taqat_sponsorship_fee" class="form-control" placeholder="Taqat sponsorship fee" value="{{ @$settings->taqat_sponsorship_fee }}">
                </div>
                <div class="clearfix"></div>

                <div class="form-group col-md-6">
                    <label>Taqat Bank Name</label>
                    <input  type="text" name="taqat_bank_name" class="form-control" placeholder="Taqat bank name" value="{{ @$settings->taqat_bank_name }}">
                </div>
                <div class="clearfix"></div>

                <div class="form-group col-md-6">
                    <label>Taqat bank account number</label>
                    <input  type="text" name="taqat_bank_account" class="form-control" placeholder="Taqat bank account number" value="{{ @$settings->taqat_bank_account }}">
                </div>
                <div class="clearfix"></div>

                <div class="form-group col-md-6">
                    <label>Taqat whatsapp number</label>
                    <input  type="text" name="taqat_whatsapp" class="form-control" placeholder="Taqat whatsapp number" value="{{ @$settings->taqat_whatsapp }}">
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

        {{-- ////////////  --}}


        <div class="dealership-form">
            <div class="form-row">
                <div class="form-group col-md-12"><h6>Social</h6></div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Facebook Link</label>
                    <input maxlength="255" type="text" name="facebook_link" class="form-control" placeholder="Facebook Link" value="{{ @$settings->facebook_link }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Instagram Link</label>
                    <input maxlength="255" type="text" name="instagram_link" class="form-control" placeholder="Instagram Link" value="{{ @$settings->instagram_link }}">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Youtube Link</label>
                    <input maxlength="255" type="text" name="youtube_link" class="form-control" placeholder="Youtube Link" value="{{ @$settings->youtube_link }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Yelp Link</label>
                    <input maxlength="255" type="text" name="yelp_link" class="form-control" placeholder="Yelp Link" value="{{ @$settings->yelp_link }}">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>LinkedIn Link</label>
                    <input maxlength="255" type="text" name="linkedin_link" class="form-control" placeholder="LinkedIn Link" value="{{ @$settings->linkedin_link }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Twitter Link</label>
                    <input maxlength="255" type="text" name="twitter_link" class="form-control" placeholder="Twitter Link" value="{{ @$settings->twitter_link }}">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Google Link</label>
                    <input maxlength="255" type="text" name="google_link" class="form-control" placeholder="Google Link" value="{{ @$settings->google_link }}">
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
                <div class="form-group col-md-12"><h6>SEO</h6></div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Homepage Meta Title</label>
                    <input maxlength="255" type="text" name="homepage_meta_title" class="form-control" placeholder="Homepage Meta Title" value="{{ @$settings->homepage_meta_title }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Homepage Meta Description</label>
                    <input maxlength="255" type="text" name="homepage_meta_description" class="form-control" placeholder="Homepage Meta Description" value="{{ @$settings->homepage_meta_description }}">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Blog Meta Title</label>
                    <input maxlength="255" type="text" name="blog_page_meta_title" class="form-control" placeholder="Blog Meta Title" value="{{ @$settings->blog_page_meta_title }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Blog Meta Description</label>
                    <input maxlength="255" type="text" name="blog_page_meta_description" class="form-control" placeholder="Blog Meta Description" value="{{ @$settings->blog_page_meta_description }}">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Contact Us Meta Title</label>
                    <input maxlength="255" type="text" name="contact_page_meta_title" class="form-control" placeholder="Contact Us Meta Title" value="{{ @$settings->contact_page_meta_title }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Contact Us Meta Description</label>
                    <input maxlength="255" type="text" name="contact_page_meta_description" class="form-control" placeholder="Contact Us Meta Description" value="{{ @$settings->contact_page_meta_description }}">
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
                <div class="form-group col-md-12"><h6>Scripts</h6></div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Header Scripts</label>
                    <textarea name="header_scripts" id="header_scripts" class="form-control" placeholder="Header Scripts"> {{ @$settings->header_scripts }} </textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>Body Start Scripts</label>
                    <textarea name="body_start_scripts" id="body_start_scripts" class="form-control" placeholder="Body Start Scripts"> {{ @$settings->body_start_scripts }} </textarea>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-12">
                    <label>Body End Scripts</label>
                    <textarea name="body_end_scripts" id="body_end_scripts" class="form-control" placeholder="Body End Scripts"> {{ @$settings->body_end_scripts }} </textarea>
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
</x-admin-layout>
