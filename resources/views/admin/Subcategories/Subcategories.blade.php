<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    <div class="table-area Subcategories-table">
        <!-- action-btn -->
        <div class="action-drop">
            <a class="action-btn" href="{{ route('admin.Subcategories.create') }}">Add sub_categories</a>
        </div>

        <table id="listingtable" class="display">
            <thead>
            <tr>
                <!-- <th>Image</th> -->
                <th class="all">Title</th>
                <th>URL (Slug)</th>
                <th>Category</th>


                <th class="all" style="width:70px;">Action</th>
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
                    url: "{{ route('admin.Subcategories.tabledata') }}",
                    type: "POST",
                    async: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "title" },
                    { data: "slug" },
                    { data: "categories" },

                    { data: "actions" }
                ],
                columnDefs: [
                    {targets: [3], orderable: false }
                ]
            });
        });
    </script>
</x-admin-layout>
