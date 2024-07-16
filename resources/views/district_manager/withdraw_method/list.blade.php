@extends('district_manager.layouts.master', ['pageSlug' => 'wm'])
@section('title', 'Withdraw Method List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Withdraw Method List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'dm.wm.create',
                                'className' => 'btn-primary',
                                'label' => 'Add withdraw method',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Account Name') }}</th>
                                <th>{{ __('Bank Name') }}</th>
                                <th>{{ __('Routing Number') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wms as $wm)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $wm->account_name }} </td>
                                    <td> {{ $wm->bank_name }} </td>
                                    <td> {{ $wm->routing_number }} </td>
                                    <td> {{ $wm->type }} </td>
                                    <td>
                                        <span class="{{ $wm->statusBg() }}">{{ $wm->statusTitle() }}</span>
                                    </td>
                                    <td>{{ timeFormate($wm->created_at) }}</td>

                                    <td> {{ c_user_name($wm->creater) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => encrypt($wm->id),
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
    {{-- Withdraw Method Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Withdraw Method Details') }}</h5>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7]])
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('dm.wm.details', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 2) {
                            $('#declained_reason').html(
                                `<p> <strong class = "text-danger"> Declined Reason: </strong>${data.note}</p>`
                            )
                        }
                        var result = `
                                <div id='declained_reason mb-2'></div>
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Account Name</th>
                                        <th>:</th>
                                        <td>${data.account_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Bank Name</th>
                                        <th>:</th>
                                        <td>${data.bank_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Bank Brunch Name</th>
                                        <th>:</th>
                                        <td>${data.bank_brunch_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Routing Number</th>
                                        <th>:</th>
                                        <td>${data.routing_number}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Type</th>
                                        <th>:</th>
                                        <td>${data.type}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Note</th>
                                        <th>:</th>
                                        <td><span class="text-danger">${data.note ?? '--'}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.statusBg}">${data.statusTitle}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created At</th>
                                        <th>:</th>
                                        <td>${data.creating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created By</th>
                                        <th>:</th>
                                        <td>${data.created_by}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated At</th>
                                        <th>:</th>
                                        <td>${data.creating_time != data.updating_time ? data.updating_time : ''}</td>
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
                        console.error('Error fetching admin data:', error);
                    }
                });
            });
        });
    </script>
@endpush
