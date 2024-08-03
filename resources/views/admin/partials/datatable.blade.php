@push('css')
    <style>
        .datatable {
            width: 100% !important;
        }
    </style>
@endpush
@push('css_link')
    <link rel="stylesheet" href="{{ asset('plugin/datatable/datatables.min.css') }}">
@endpush

@push('js_link')
    <script src="{{ asset('plugin/datatable/datatables.min.js') }}"></script>
@endpush


@push('js')
    <script>
        $(document).ready(function() {
            var main_class = {!! json_encode($mainClass ?? 'datatable') !!};
            $('.' + main_class).css('width', '100%');
            $('.' + main_class).each(function() {
                var columnsToShow = {!! json_encode($columns_to_show ?? []) !!};
                var order = {!! json_encode($order ?? 'asc') !!};
                var length = {!! json_encode($length ?? 50) !!};
                $(this).DataTable({
                    dom: 'Bfrtip',
                    responsive: true,
                    iDisplayLength: length,
                    order: [
                        [0, order]
                    ],
                    buttons: [{
                            extend: 'pdfHtml5',
                            download: 'open',
                            orientation: 'potrait',
                            pagesize: 'A4',
                            exportOptions: {
                                columns: columnsToShow,
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: columnsToShow,
                            }
                        }, 'excel', 'csv', 'pageLength',
                    ]
                });
            });
        });
    </script>
@endpush
