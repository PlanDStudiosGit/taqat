<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <div class="table-area blog-table">
        <!-- action-btn -->
        {{-- <div class="action-drop">
            <a class="action-btn" href="{{ route('admin.paymentapproval.create') }}">Add Service</a>
        </div> --}}
        <table id="listingtable" class="display">
            <thead>
            <tr>
                <th class="all">Old Sponsor</th>
                <th class="all">New Sponsor</th>
                <th>Labor</th>
                <th>Service</th>
                <th>Payment proof</th>
                <th>Payment proof status</th>
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
                    url: "{{ route('admin.paymentapproval.tabledata') }}",
                    type: "POST",
                    async: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "from_name" },
                    { data: "to_user" },
                    { data: "fullname" },
                    { data: "title" },
                    { data: "payment_proof_doc" },
                    { data: "payment_status" },
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
