@extends('rider.layouts.master', ['pageSlug' => $slug])
@section('title', ucwords(strtolower(str_replace('-', ' ', $slug))) . ' Order List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">
                                {{ __(ucwords(strtolower(str_replace('-', ' ', $slug))) . ' Order List') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Priority') }}</th>
                                <th>{{ __('Pharmacies') }}</th>
                                <th>{{ __('Delivery Address') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($dors as $dor)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $dor->od->order->order_id }} </td>
                                    <td> {{ $dor->priority() }} </td>
                                    <td>
                                        @foreach ($dor->od->active_odps->unique('pharmacy_id') as $key => $odp)
                                            {{ str_limit($odp->pharmacy->name, 30) }}
                                            @if (!$loop->last)
                                                |
                                            @endif
                                        @endforeach
                                    </td>
                                    <td> {{ str_limit($dor->od->order->address->address, 30) }} </td>
                                    <td>
                                        <span
                                            class="{{ $dor->statusBg() }}">{{ __(ucwords(strtolower(str_replace('-', ' ', $dor->statusTitle())))) }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)"
                                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                    href="{{ route('rider.order_management.details', encrypt($dor->id)) }}">{{ __('View Details') }}</a>
                                            </div>
                                        </div>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])

@push('js_link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('rider/js/remaining.js') }}"></script>
@endpush
