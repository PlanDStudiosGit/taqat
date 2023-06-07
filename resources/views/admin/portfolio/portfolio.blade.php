<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
    <x-slot name="breadCrumbs">
        <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
    </x-slot>
    @if(!isset($services[0]))
        <div class="text-center" style="margin-top: 70px;">Please add a service before creating Portfolio</div>
    @else
    <div class="leads-tabs">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @foreach($services as $key => $service)
                    <a class="nav-link {{ $key == 0? 'active' : '' }}" id="{{ $service->slug }}" data-toggle="tab" href="#{{ $service->slug }}tab" role="tab" aria-controls="{{ $service->slug }}" aria-selected="true">{{ $service->title }}</a>
                @endforeach
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            @foreach($services as $key => $service)
                <div class="tab-pane fade show {{ $key == 0? 'active' : '' }}" id="{{ $service->slug }}tab" role="tabpanel" aria-labelledby="{{ $service->slug }}">
                    <div class="table-area blog-table">
                        <!-- action-btn -->
                        <div class="action-drop">
                            <a class="action-btn" href="{{ route('admin.portfolio.create', ['portfolio' => $service->id]) }}">Add Portfolio</a>
                        </div>

                        <table id="table{{ $service->slug }}" class="display">
                            <thead>
                            <tr>
                                <th class="all">Title</th>
                                <th>URL (Slug)</th>
                                <th>Order #</th>
                                <th class="all" style="width:70px !important;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
<x-slot name="pluginCss">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.dataTables.min.css') }}">
</x-slot>
<style>
    .blog-table .dataTables_wrapper .dataTables_filter {
        margin-right: 120px;
    }
    .leads-tabs .nav-tabs{
        margin-bottom: 15px;
    }
</style>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("a[data-toggle=\"tab\"]").on("shown.bs.tab", function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust()
                .responsive.recalc();
        });
        @foreach($services as $key => $service)
            $('#table{{ $service->slug }}').addClass('nowrap').dataTable({
                responsive: true,
                fixedHeader: true,
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: "{{ route('admin.portfolio.tabledata') }}",
                    type: "POST",
                    async: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "data": function ( d ) {
                        d.serviceId = '{{ $service->id }}';
                    }
                },
                columns: [
                    { data: "title" },
                    { data: "slug" },
                    { data: "order_no" },
                    { data: "actions" }
                ],
                columnDefs: [
                    {targets: [3], orderable: false }
                ]
            });
        @endforeach
    }); // document.ready
</script>
</x-admin-layout>
