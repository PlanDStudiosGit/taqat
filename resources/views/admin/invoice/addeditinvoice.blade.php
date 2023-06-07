<x-admin-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs" />
    </x-slot>

    <div class="dealership-form">





        <form class="myform" method="POST"
            action="{{ !empty($details) ? route('admin.invoice.update', ['id' => $details->id]) : route('admin.invoice.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="form-row">


                <div class="form-group col-md-6">
                    <label>Work permit (unit cost)</label>
                    <input type="text" name="work_permit_unit_cost" class="form-control " value="{{@$details->workpermit_unit_cost}}" required placeholder="Enter work permit unit cost">
                </div>

                <div class="form-group col-md-6">
                    <label>Medical (unit cost)</label>
                    <input type="text" name="medical_unit_cost" class="form-control " value="{{@$details->medical_unit_cost}}" required placeholder="Enter Medical unit cost" >
                </div>

                <div class="form-group col-md-6">
                    <label>Visa form (unit cost)</label>
                    <input type="text" name="visa_form_unit_cost" class="form-control " value="{{@$details->visa_form_unit_cost}}" required placeholder="Enter visa form unit cost">
                </div>

                <div class="form-group col-md-6">
                    <label>Visa stamp (unit cost)</label>
                    <input type="text" name="visa_stamp_unit_cost" class="form-control " value="{{@$details->visa_stamp_unit_cost}}" required placeholder="Enter visa stamp unit cost">
                </div>

                <div class="form-group col-md-6">
                    <label>Resident form (unit cost)</label>
                    <input type="text" name="resident_form_unit_cost" class="form-control " value="{{@$details->resident_form_unit_cost}}" required placeholder="Enter resident form unit cost">
                </div>

                <div class="form-group col-md-6">
                    <label>Labor card (unit cost)</label>
                    <input type="text" name="labor_card_unit_cost" class="form-control " value="{{@$details->labor_card_unit_cost}}" required placeholder="Enter labor card unit cost">
                </div>

                <div class="form-group col-md-6">
                    <label>Sponsorship transfer (unit cost)</label>
                    <input type="text" name="sponsorship_transfer_unit_cost" class="form-control " value="{{@$details->sponsorship_form_unit_cost}}" required placeholder="Enter sponsorship transfer unit cost">
                </div>

                <div class="form-group col-md-6">
                    <label>Bank name</label>
                    <input type="text" name="bank_name" class="form-control " value="{{@$details->bank_name}}" required placeholder="Enter your bank name">
                </div>

                <div class="form-group col-md-6">
                    <label>Bank account number</label>
                    <input type="text" name="bank_account" class="form-control " value="{{@$details->bank_account_number}}" required placeholder="Enter your bank account number">
                </div>

                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="{{ route('admin.invoice.index') }}" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>

            </div>
        </form>

    </div>

    {{-- <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('terms');
        ckfinder.setupCDEditor('editor');
    </script> --}}
    {{-- ////////////////////// mine /////////////// --}}

    <div id="editor"></div>
    <x-slot name="pluginCss"></x-slot>
    <x-admin.tinymce />
</x-admin-layout>
