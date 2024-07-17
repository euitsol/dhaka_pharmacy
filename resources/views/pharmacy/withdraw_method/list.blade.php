@extends('pharmacy.layouts.master', ['pageSlug' => 'wm'])
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
                                'routeName' => 'pharmacy.wm.create',
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
                                <th>{{ __('Created date') }}</th>
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
                                    <td> {{ $wm->type() }} </td>
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
        const details = {
            'my_route': `{{ route('pharmacy.wm.details', ['id']) }}`,
        };
    </script>
    <script src="{{ asset('withdraw_method/details.js') }}"></script>
@endpush
