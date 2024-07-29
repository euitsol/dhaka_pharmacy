@extends('admin.layouts.master', ['pageSlug' => 'user_tips'])
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('User Tips List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'user_tips.tips_create',
                                'className' => 'btn-primary',
                                'label' => 'Add User Tips',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead class=" text-primary">
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_tips as $tips)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>
                                        <div id="lightbox" class="lightbox">
                                            <div class="lightbox-content">
                                                <img src="{{ storage_url($tips->image) }}" class="lightbox_image">
                                            </div>
                                            <div class="close_button fa-beat">X</div>
                                        </div>
                                    </td>
                                    <td>{!! str_limit($tips->description, 80) !!}</td>
                                    <td>
                                        <span class="{{ $tips->getStatusBadgeClass() }}">{{ $tips->getStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($tips->created_at) }}</td>
                                    <td>{{ c_user_name($tips->created_user) }}</td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$tips->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $tips->id,
                                                ],
                                                [
                                                    'routeName' => 'user_tips.tips_edit',
                                                    'params' => [$tips->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'user_tips.status.tips_edit',
                                                    'params' => [$tips->id],
                                                    'label' => $tips->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'user_tips.tips_delete',
                                                    'params' => [$tips->id],
                                                    'label' => 'Delete',
                                                    'delete' => true,
                                                ],
                                            ],
                                        ])
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Role Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('User Tips Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3]])
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('user_tips.details.tips_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status === 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status === 1 ? 'badge-success' :
                            'badge-warning';
                        var result = `
                        <table class="table table-striped">
                            <tr>
                                <th class="text-nowrap">Image</th>
                                <th>:</th>
                                <td>
                                    <div id="lightbox" class="lightbox">
                                        <div class="lightbox-content">
                                            <img src="${data.image}" class="lightbox_image">
                                        </div>
                                        <div class="close_button fa-beat">X</div>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Description</th>
                                <th>:</th>
                                <td>${data.description}</td>
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
                                <td>${data.creating_time}</td>
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
                        console.error('Error fetching role data:', error);
                    }
                });
            });
        });
    </script>
@endpush
