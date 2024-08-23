@extends('pharmacy.layouts.master', ['pageSlug' => $status . '_orders'])
@section('title', ucwords(strtolower(str_replace('-', ' ', $status))) . ' Orders')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">
                                {{ __(ucwords(strtolower(str_replace('-', ' ', $status))) . ' Orders') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                {{-- @if ($rider && $status != 'dispute')

                                @endif --}}

                                @if ($status == 'assigned')
                                    <th>{{ __('Total Pending') }}</th>
                                    <th>{{ __('Total Preparing') }}</th>
                                    <th>{{ __('Total Dispute') }}</th>
                                    <th>{{ __('Preparetion Time Left') }}</th>
                                @else
                                    <th>{{ __('Rider') }}</th>
                                @endif
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Distribution Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($ods as $od)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $od->order->order_id }} </td>
                                    @if ($status == 'assigned')
                                        <td><span
                                                class="{{ $od->odps->where('status', 0)->count() > 0 ? 'badge badge-primary' : '' }}">{{ $od->odps->where('status', 0)->count() }}</span>
                                        </td>
                                        <td><span
                                                class="{{ $od->odps->where('status', 1)->count() > 0 ? 'badge badge-warning' : '' }}">{{ $od->odps->where('status', 1)->count() }}</span>
                                        </td>
                                        <td><span
                                                class="{{ $od->odps->where('status', -1)->count() > 0 ? 'badge badge-danger' : '' }}">{{ $od->odps->where('status', -1)->count() }}</span>
                                        </td>
                                        <td>
                                            {!! remainingTime($od->pharmacy_prep_time, true) !!}
                                        </td>
                                    @else
                                        <td>
                                            {{ $od->assignedRider->first() ? $od->assignedRider->first()->rider->name : '---' }}
                                        </td>
                                    @endif
                                    <td> {{ $od->paymentType() }} </td>
                                    <td> {{ $od->distributionType() }} </td>
                                    <td>
                                        <span class="{{ $od->statusBg() }}">{{ $od->statusTitle() }}</span>
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
                                                    href="{{ route('pharmacy.order_management.details', ['od_id' => encrypt($od->id), 'status' => $status]) }}">{{ __('View Details') }}</a>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7]])
@push('js_link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('pharmacy/js/remaining.js') }}"></script>
@endpush
