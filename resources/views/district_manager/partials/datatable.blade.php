@push('css_link')
    <link rel="stylesheet" href="{{ asset('backend/plugin/datatable/datatables.min.css') }}">

@endpush

@push('js_link')
    <script src="{{ asset('backend/plugin/datatable/datatables.min.js') }}"></script>
@endpush


@push('js')
  <script>
    $(document).ready(function() {
      $('.datatable').each(function() {
        var columnsToShow =  {!! json_encode($columns_to_show ?? []) !!};
        var order =  {!! json_encode($order ?? 'asc') !!};
        $(this).DataTable({
            dom: 'Bfrtip',
            iDisplayLength: 50,
            order: [[0, order]],
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
                },  'excel', 'csv', 'pageLength',
            ]
        });
      });
    });
  </script>
@endpush
