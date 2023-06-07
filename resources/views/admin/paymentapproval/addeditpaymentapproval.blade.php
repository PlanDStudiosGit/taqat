<x-admin-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs" />
    </x-slot>

    <div class="dealership-form">





        <form class="myform" method="POST"
            action="{{ !empty($labor_hiring) ? route('admin.paymentapproval.update', ['id' => $labor_hiring->hiring_id]) : route('admin.labors.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="form-row">


                <div class="form-group col-md-6">
                    <label>Old Sponsor</label>
                    <input type="text" name="old_sponsor" class="form-control "
                        value="{{ @$labor_hiring->from_name }}" pattern="[A-Za-z ]+" required disabled>
                </div>


                {{-- { data: "from_name" },
                { data: "to_user" },
                { data: "fullname" },
                { data: "title" },
                { data: "payment_proof_doc" },
                { data: "payment_status" }, --}}

                <div class="form-group col-md-6">
                    <label>New Sponsor</label>
                    <input type="text" name="new_sponsor" class="form-control " value="{{ @$labor_hiring->to_user }}"
                        required pattern="^[a-zA-Z ]+$" disabled>
                </div>


                <div class="row col-md-12 mt-3 ">
                    <div class="form-group col-md-6">
                        <label>Document</label>
                        <input type="file" name="doc" class="form-control " disabled>
                    </div>

                    <div class="form-group col-md-6 ">

                        {{-- <div>

                            @if (@$labor_hiring->payment_proof_doc)
                            
                        <img src="{{asset('/images/users/paymentProofs')}}{{'/' . $labor_hiring->payment_proof_doc}}" alt="" srcset="" style="width: 150px; height: 150px;">

                        @else
                        <img src="{{asset('/img/placeholder-img.png')}}" alt="" srcset="" style="width: 150px; height: 150px;">
                        
                        @endif
                    </div> --}}

                        <div>
                            <a href="{{ asset('/images/users/paymentProofs') }}{{ '/' . $labor_hiring->payment_proof_doc }}"
                                download class="btn btn-primary bg-primary pt-1 pb-1 pl-2 pr-2 text-light">Download
                            </a>
                        </div>


                    </div>
                    <div>

                    </div>
                </div>


                <div class="form-group col-md-6">
                    <label>Payment status</label>
                    <select class=" form-control" name="payment_status">

                        <option value="0" {{ @$labor_hiring->payment_status == '0' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="1" {{ @$labor_hiring->payment_status == '1' ? 'selected' : '' }}>Approve
                        </option>
                        <option value="2" {{ @$labor_hiring->payment_status == '2' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>
                </div>


                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.paymentapproval') }}" class="cancle-btn">Back</a>
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
                    data: {
                        'number': number
                    },
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
