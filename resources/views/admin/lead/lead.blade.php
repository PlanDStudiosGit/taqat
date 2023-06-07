<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <div class="table-area blog-table">
        <!-- action-btn -->
        <div class="action-drop">
            &nbsp;
        </div>

        <table id="listingtable" class="display">
            <thead>
            <tr>
                <th class="all">Type</th>
                <th class="all">Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Page</th>
                <th>Date/Time</th>
                <th class="all" style="width: 75px;">Actions</th>
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
        .blog-table .dataTables_wrapper .dataTables_filter {margin-right: 0px;}
        td{position:relative}
        a.clickablecontent{position: absolute;width:100%;height:100%;top:0;left:0;margin:0;}
        table.dataTable.nowrap tbody tr:hover{background:rgb(238 240 245 / 65%)}
        .eyeiconimg{position:relative;top:4px}
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
                    url: "{{ route('admin.lead.tabledata') }}",
                    type: "POST",
                    async: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "type" },
                    { data: "name" },
                    { data: "phone" },
                    { data: "email" },
                    { data: "page" },
                    { data: "datetime" },
                    { data: "actions" }
                ],
                columnDefs: [
                    {targets: [2], orderable: false }
                ]
            });
        });
    </script>
</x-admin-layout>
