@extends('admin.layouts.master', ['pageSlug' => 'order_' . $status])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __(ucwords(strtolower(str_replace('-', ' ', $status))) . ' Orders') }}
                            </h4>
                        </div>
                        <div class="col-4 text-end">
                            <span
                                class="{{ $statusBgColor }}">{{ __(ucwords(strtolower(str_replace('-', ' ', $status)))) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Total Product') }}</th>
                                @if ($status == 'Processed')
                                    <th>{{ __('Total Pending') }}</th>
                                    <th>{{ __('Total Preparing') }}</th>
                                    <th>{{ __('Total Dispute') }}</th>
                                @endif
                                {{-- @if ($pp_count || $status == 'waiting-for-rider')
                                    <th>{{ __('Total Accepted') }}</th>
                                @endif --}}
                                <th>{{ __('Total Price') }}</th>
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Distribution Type') }}</th>
                                <th>{{ __('Preparation Time Left') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dos as $do)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $do->order->order_id }}</td>
                                    <td><span
                                            class="{{ $do->odps_count > 0 ? 'badge badge-info' : '' }}">{{ $do->odps_count }}</span>
                                    </td>
                                    @if ($status == 'Processed')
                                        <td><span
                                                class="{{ $do->odps->where('status', 0)->count() > 0 ? 'badge badge-primary' : '' }}">{{ $do->odps->where('status', 0)->count() }}</span>
                                        </td>
                                        <td><span
                                                class="{{ $do->odps->where('status', 1)->count() > 0 ? 'badge badge-warning' : '' }}">{{ $do->odps->where('status', 1)->count() }}</span>
                                        </td>
                                        <td><span
                                                class="{{ $do->odps->where('status', 3)->count() > 0 ? 'badge badge-danger' : '' }}">{{ $do->odps->where('status', 3)->count() }}</span>
                                        </td>
                                    @endif
                                    {{-- @if ($pp_count || $status == 'waiting-for-rider')
                                        <td><span
                                                class="{{ $do->odps->where('status', 2)->count() > 0 ? 'badge badge-success' : '' }}">{{ $do->odps->where('status', 2)->count() }}</span>
                                        </td>
                                    @endif --}}
                                    <td>{!! get_taka_icon() !!}{{ number_format(ceil($do->order->totalDiscountPrice + $do->order->delivery_fee)) }}
                                    </td>
                                    <td>{{ $do->paymentType() }}</td>
                                    <td>{{ $do->distributionType() }}</td>
                                    <td>{!! remainingTime($do->pharmacy_prep_time, true) !!}</td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'do.do_details',
                                                    'params' => [encrypt($do->id)],
                                                    'label' => 'Details',
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
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]])

@push('js_link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('admin/js/remaining.js') }}"></script>
@endpush
