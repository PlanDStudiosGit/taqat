<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <div class="table-area blog-table">
        <!-- action-btn -->
        <div class="action-drop">
            <a class="action-btn" href="{{ route('admin.labors.create') }}">Add Labor</a>
        </div>
        <table id="listingtable" class="display">
            <thead>
            <tr>
                <th class="all">Labor name</th>
                <th >Passport number</th>
                <th >Gender</th>
                <th >Education</th>
                <th >Application type</th>
                <th >Job type</th>
                <th >Occupation</th>
                <th >Marital Status</th>
                <th>Nationality</th>
                <th>Address</th>
                <th>Age</th>
                <th>Religion</th>
                {{-- <th>Age</th> --}}
                <th class="all" style="width:30px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <x-slot name="pluginCss">
        <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.dataTables.min.css') }}">
    </x-slot>
    <style>
        .blog-table .dataTables_wrapper .dataTables_filter {
            margin-right: 0px;
        }
    </style>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#listingtable').addClass('nowrap').dataTable({
                responsive: true,
                fixedHeader: true,
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: "{{ route('admin.labors.tabledata') }}",
                    type: "POST",
                    async: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "labor_first_name" },
                    { data: "passport_no" },
                    { data: "gender" },
                    { data: "education" },
                    { data: "application_type" },
                    { data: "job_type" },
                    { data: "occupation" },
                    { data: "marital_status" },
                    { data: "nationality" },
                    { data: "address" },
                    { data: "dob" },
                    { data: "religion" },
                    { data: "actions" }

                ],
                columnDefs: [
                    {targets: [2], orderable: false }
                ]
            });
        });
    </script>
    <style>
        .blog-table .dataTables_wrapper .dataTables_filter {
            margin-right: 125px;
        }
    </style>
</x-admin-layout>
