@extends('pharmacy.layouts.master', ['pageSlug' => $do->odps->first()->pStatusSlug() . '_orders'])
@section('title', 'Order Details')
@push('css_link')
    <link href="https://pbutcher.uk/flipdown/css/flipdown/flipdown.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('pharmacy/css/order_details.css') }}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center gap-2">
                <h4 class="card-title mb-0">
                    {{ __('Order Details ') }}
                </h4>
            </div>
            @if ($odps_status < 2)
                <div class="flipdown" id="flipdown"></div>
            @endif

            <a href="{{ route('pharmacy.order_management.index',$do->odps->where('status', '!=', -1)->first()->pStatusSlug()) }}"
                class="btn btn-primary">{{ __('Back') }}</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    @include('pharmacy.orders.includes.order_details', [
                        'do' => $do,
                    ])
                </div>
                <div class="col-md-4">
                    @include('pharmacy.orders.includes.order_tracking', [
                        'do' => $do,
                        'odps_status' => $odps_status,
                    ])
                </div>
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            @include('pharmacy.orders.includes.otp-verify', [
                                'do' => $do,
                                'odps_status' => $odps_status,
                            ])
                            <form action="{{ route('pharmacy.order_management.update', encrypt($do->id)) }}" method="POST">
                                @csrf
                                @foreach ($do->odps as $key => $dop)
                                    <div class="col-12 status_wrap">
                                        <div class="card card-2 mb-0 mt-3">
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="sq align-self-center "> <img
                                                            class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                                                            src="{{ product_image($dop->order_product->product->image) }}"
                                                            width="135" height="135" /> </div>
                                                    <div class="media-body my-auto text-center">
                                                        <div class="row  my-auto flex-column flex-md-row px-3">
                                                            <div class="col text-start">
                                                                <h6 class="mb-0 text-start">
                                                                    {{ $dop->order_product->product->name }}</h6>
                                                                <small>{{ $dop->order_product->product->pro_cat->name }}
                                                                </small>
                                                            </div>
                                                            <div class="col my-auto d-flex justify-content-around"> Quantity
                                                                :
                                                                {{ $dop->order_product->quantity }} &nbsp; &nbsp; Pack :
                                                                {{ $dop->order_product->unit->name ?? 'Piece' }}
                                                            </div>
                                                            <div class="col my-auto text-end"><span
                                                                    class="{{ $dop->statusBg() }}">{{ slugToTitle($dop->statusTitle()) }}</span>
                                                            </div>
                                                            <div class="col my-auto">
                                                                <h6 class="my-auto text-center">
                                                                    <span>{{ __('Total Price : ') }}{!! get_taka_icon() !!}

                                                                        <span
                                                                            class="">{{ number_format(ceil($dop->discounted_price)) }}
                                                                        </span>
                                                                        @if ($dop->discounted_price != $dop->selling_price)
                                                                            <del
                                                                                class="text-danger">{{ number_format($dop->selling_price, 2) }}</del>
                                                                        @endif
                                                                    </span>
                                                                    @if ($dop->discount)
                                                                        <sup><span class='badge badge-danger'>
                                                                                {{ $dop->discount . '% off' }}
                                                                            </span></sup>
                                                                    @endif
                                                                </h6>
                                                                @if ($do->payment_type == 1 && ($dop->status == 0 || $dop->status == 1))
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            name="data[{{ $key }}][open_amount]"
                                                                            class="form-control open_amount"
                                                                            placeholder="Enter product price">
                                                                        @include('alerts.feedback', [
                                                                            'field' =>
                                                                                'data.' . $key . '.open_amount',
                                                                        ])
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            @if ($do->payment_type == 1 && $dop->status == 2 && $dop->open_amount > 0)
                                                                <div class="col my-auto">
                                                                    <h6 class="my-auto text-center">
                                                                        <span><strong>{{ __('Bit Price : ') }}</strong>{!! get_taka_icon() !!}
                                                                            {{ number_format($dop->open_amount, 2) }}</span>
                                                                    </h6>
                                                                </div>
                                                            @endif
                                                            @if ($dop->status == 0 || $dop->status == 1)
                                                                <div class="col my-auto mt-3">
                                                                    <div class="card mb-0">
                                                                        <div class="card-body">
                                                                            <input type="hidden"
                                                                                name="data[{{ $key }}][dop_id]"
                                                                                value="{{ $dop->id }}">

                                                                            <div class="form-check form-check-radio">
                                                                                <label class="form-check-label me-2"
                                                                                    for="status_{{ $key }}">
                                                                                    <input
                                                                                        class="form-check-input do_status"
                                                                                        type="radio"
                                                                                        name="data[{{ $key }}][status]"
                                                                                        id="status_{{ $key }}"
                                                                                        value="2" checked>
                                                                                    {{ __('Accept') }}
                                                                                    <span class="form-check-sign"></span>
                                                                                </label>
                                                                                <label class="form-check-label"
                                                                                    for="status{{ $key }}">
                                                                                    <input
                                                                                        class="form-check-input do_status"
                                                                                        type="radio"
                                                                                        name="data[{{ $key }}][status]"
                                                                                        id="status{{ $key }}"
                                                                                        value="3">
                                                                                    {{ __('Dispute') }}
                                                                                    <span class="form-check-sign"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($dop->status == 0 || $dop->status == 1)
                                            <div class="form-group status_note mt-3" style="display: none">
                                                <textarea name="data[{{ $key }}][note]" class="form-control" placeholder="Enter dispute reason"></textarea>
                                            </div>
                                            @include('alerts.feedback', [
                                                'field' => 'data.' . $key . '.note',
                                            ])
                                        @elseif($dop->status == -1)
                                            <span><strong
                                                    class="text-danger">{{ __('Reason: ') }}</strong>{{ $dop->note }}</span>
                                        @endif

                                    </div>
                                @endforeach
                                @if ($do->getPharmacyStatus(pharmacy()->id) == 0 || $do->getPharmacyStatus(pharmacy()->id) == 1)
                                    <div class="col-12 text-end mt-2">
                                        <input type="submit" value="Confirm" class="btn btn-success">
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pharmacy.orders.includes.otp-modal')
@endsection
@push('js_link')
    <script>
        const data = {
            'prepTime': `{{ $do->pharmacy_prep_time }}`,
        };
    </script>
    <script src="https://pbutcher.uk/flipdown/js/flipdown/flipdown.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('pharmacy/js/remaining.js') }}"></script>
    <script src="{{ asset('pharmacy/js/order_details.js') }}"></script>
@endpush
