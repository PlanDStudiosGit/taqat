<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <div class="dealership-form">
        <div id="leaddetails">
            <div class="col-md-12">
                <div class="form-group">
                    <span style="font-weight: 600;">Type:</span> {{ ucwords($leadDetails->type) }}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <span style="font-weight: 600;">Name:</span> {{ $leadDetails->name }}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <span style="font-weight: 600;">Phone:</span> {{ $leadDetails->phone }}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <span style="font-weight: 600;">Email:</span> {{ $leadDetails->email }}
                </div>
            </div>
            @if($leadDetails->page != '')
            <div class="col-md-12">
                <div class="form-group">
                    <span style="font-weight: 600;">Page:</span> {{ $leadDetails->page }}
                </div>
            </div>
            @endif
            @if($leadDetails->message != '')
            <div class="col-md-12">
                <div class="form-group">
                    <span style="font-weight: 600;">Message:</span> {{ $leadDetails->message }}
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-12">
            <div class="cus-btn text-right">
                <a href="{{ route('admin.lead.index') }}" class="cancle-btn">Back</a>
                <button type="button" class="send-btn" onclick="window.print();">Print</button>
            </div>
        </div>
    </div>
    <x-slot name="pluginCss"></x-slot>
    <style>
        @media print {
            .menu-area, .header-area, .cus-btn {display:none!important}
            .main-contents{margin-left:0px!important}
            body {
                background: transparent !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</x-admin-layout>
