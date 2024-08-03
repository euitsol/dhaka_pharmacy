<table class="table table-striped review_datatable">
    <thead>
        <tr>
            <th>{{ __('SL') }}</th>
            <th>{{ __('Customer') }}</th>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Submitted date') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reviews as $review)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td> {{ $review->customer->name }} </td>
                <td> {{ str_limit($review->product->name, 20) }} </td>
                <td>
                    <span class="{{ $review->getStatusBadgeClass() }}">{{ $review->getStatus() }}</span>
                </td>
                <td>{{ timeFormate($review->created_at) }}</td>
                <td>
                    @include('admin.partials.action_buttons', [
                        'menuItems' => [
                            [
                                'routeName' => 'javascript:void(0)',
                                'params' => [$review->id],
                                'label' => 'View Details',
                                'className' => 'view',
                                'data-id' => $review->id,
                            ],
                        ],
                    ])
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
@include('admin.partials.datatable', [
    'columns_to_show' => [0, 1, 2, 3, 4],
    'mainClass' => 'review_datatable',
])
<div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Review Details') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal_data">
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('review.details.review_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status == 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status == 1 ? 'badge-success' :
                            'badge-warning';
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Customer</th>
                                        <th>:</th>
                                        <td>${data.customer.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Product</th>
                                        <th>:</th>
                                        <td>${data.product.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Review</th>
                                        <th>:</th>
                                        <td class="text-justify">${data.description}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created Date</th>
                                        <th>:</th>
                                        <td>${data.creating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created By</th>
                                        <th>:</th>
                                        <td>${data.created_by}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated Date</th>
                                        <th>:</th>
                                        <td>${data.updating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated By</th>
                                        <th>:</th>
                                        <td>${data.updated_by}</td>
                                    </tr>
                                </table>
                                `;
                        $('.modal_data').html(result);
                        $('.view_modal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching review data:', error);
                    }
                });
            });
        });
    </script>
@endpush
