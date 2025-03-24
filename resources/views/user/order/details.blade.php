@extends('user.layouts.master', ['pageSlug' => 'order'])
@section('title', 'Order Details')
@push('css')
    <style>
        /* Timeline Styles */
        .order-timeline {
            --primary-color: #10B981;
            --inactive-color: #E5E7EB;
            --text-muted: #6B7280;
            padding: 1rem 0;
        }

        /* Progress Bar */
        .progress-bar-wrapper {
            position: absolute;
            top: 2rem;
            left: 2rem;
            right: 2rem;
            height: 4px;
            z-index: 0;
        }

        .progress-line {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: var(--inactive-color);
            border-radius: 2px;
        }

        .progress-line-active {
            position: absolute;
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 2px;
            transition: width 0.5s ease-in-out;
        }

        /* Timeline Steps */
        .timeline-step {
            position: relative;
            padding-bottom: 2rem;
        }

        /* Vertical Line (Mobile) */


        .order-timeline .content-wrapper {
            padding-left: 2rem;
        }

        .vertical-line {
            position: absolute;
            left: 1.9rem;
            top: 2.5rem;
            bottom: 0;
            width: 5px;
            background-color: var(--inactive-color);
        }

        .timeline-step.active .vertical-line-active {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: var(--primary-color);
            transition: height 0.5s ease-in-out;
        }

        /* Icon */
        .icon-wrapper {
            position: relative;
            z-index: 1;
            margin-bottom: 1rem;
        }

        .icon {
            width: 2.5rem;
            height: 2.5rem;
            background-color: white;
            border: 2px solid var(--inactive-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease-in-out;
        }

        .timeline-step.active .icon {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        @media screen and (max-width: 767px) {
            .order-timeline .content-wrapper {
                position: absolute;
                top: 10px;
                left: 60px;
            }
        }

        .icon-wrapper-end {
            text-align: -webkit-right !important;
            text-align: right !important;
        }
    </style>
@endpush
@section('content')
    <section class="order-info-section">
        <div class="container">
            <div class="order-info-cont">
                <!-- Order-status-row-start -->
                <div class="row  align-items-center">
                    <div class="col-lg-6  col-12">
                        <div class="d-block d-md-flex align-items-center ">
                            <div
                                class="order-status-row d-flex align-items-center justify-content-md-start justify-content-between py-2 py-sm-4">
                                <div class="img me-sm-3 me-2">
                                    <img src="{{ asset('user/asset/img/order-status.png') }}" alt="">
                                </div>
                                <h2 class="mb-0 me-sm-4">{{ __('Order ID: ') }}<span>{{ $order->order_id }}</span></h2>
                                <p class="mb-0 fw-bold">{{ slugToTitle($order->status_string) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 fs-1 pb-3 ">
                        <div class="order-status order-tracking-main m-0 text-start text-sm-end d-flex justify-content-lg-end justify-content-center align-items-center gap-2">
                            @if ($order->status == App\Models\Order::INITIATED)
                                    <a class=" text-center pay-now"
                                        href="">{{ __('Pay Now') }}</a>
                            @endif

                            @if(($order->status == App\Models\Order::SUBMITTED) || ($order->status == App\Models\Order::INITIATED))
                                    <a class="text-center cancel"
                                        href="{{ route('u.order.cancel', encrypt($order->order_id)) }}">{{ __('Cancel') }}</a>
                            @endif
                                <a class="text-center record"
                                    href="{{ route('u.order.reorder', encrypt($order->id)) }}">{{ __('Reorder') }}</a>
                        </div>

                    </div>

                </div>
                <!-- Order-status-row-end -->

                <!-- Order Tracking row start-->
                @if ($order->status != -1)
                    <div class="">
                        <h2 class="mb-4 fw-bold">{{ __('Order Tracking') }}</h2>
                        <div class="position-relative order-timeline">
                            <!-- Progress Bar -->
                            <div class="progress-bar-wrapper d-none d-md-block">
                                <div class="progress-line"></div>
                            </div>

                            <!-- Timeline Steps -->
                            <div class="row position-relative">
                                @foreach ($order->timelines as $timeline)
                                    @if ($timeline->status != -1)
                                        <div
                                            class="col-12 col-md timeline-step {{ $timeline->actual_completion_time != null ? 'active' : '' }}">
                                            <!-- Vertical line for mobile -->
                                            <div class="vertical-line d-md-none">
                                                <div class="vertical-line-active"></div>
                                            </div>

                                            <!-- Icon -->
                                            <div class="icon-wrapper">
                                                <div class="icon">
                                                    @if ($timeline->actual_completion_time != null)
                                                        <i class="fas fa-check"></i>
                                                    @else
                                                        <i class="fa-regular
                                                        fa-hourglass"></i>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Content -->
                                            <div class="content-wrapper">
                                                <h5 class="timeline-title">{{ __($timeline->status_string) }}</h5>
                                                @if ($timeline->actual_completion_time != null)
                                                    <p class="timeline-text">{{ __('Completed at') }}
                                                        {{ timeFormate($timeline->actual_completion_time) }}</p>
                                                @endif
                                                @if ($timeline->expected_completion_time != null)
                                                    <p class="timeline-text">{{ __('Expected at') }}
                                                        {{ timeFormate($timeline->expected_completion_time) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <h2 class="text-danger">{{ __('Order Canceled') }}</h2>
                @endif

                <!-- Order Tracking row end-->

                <!-- Order-details-row-start -->
                <div class="row py-2 pt-4">
                    <div class="col-lg-3 col-sm-6 col-12 mb-lg-0 mb-2">
                        <div class="order-details">
                            <span>{{ __('Order Date') }}</span>
                            <p>{{ timeFormate($order->created_at) }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 mb-lg-0 mb-2">
                        <div class="order-details">
                            <span>{{ __('Receiver Name') }} </span>
                            <p class="mb-0">{{ optional($order->customer)->name }}</p>
                            <p>{{ __('Mobile : ') }}
                                {{ formatPhoneNumber(optional($order->customer)->phone) }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 mb-lg-0 mb-2">
                        <div class="order-details">
                            <span>{{ __('Delivery Address') }}</span>
                            <p>{{ __(optional($order->address)->address) }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 mb-lg-0 mb-2">
                        @if ($order->timelines->where('status', App\Models\Order::DELIVERED)->first()->actual_completion_time != null)
                            <div class="order-details">
                                <span>{{ __('Delivery Time') }}</span>
                                <p>Est.
                                    {{ timeFormate($order->timelines->where('status', App\Models\Order::DELIVERED)->first()->actual_completion_time) }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Order-details-row-end -->

                <!-- Order-information-row-start -->
                <div class="order-info-row">
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                            <h4 class="mb-3 title">{{ __('Order Information') }}</h4>
                            <div class="left">
                                @foreach ($order->products as $product)
                                    <div class="row align-items-center py-2">
                                        <div class="col-sm-3 col-4 px-0 px-sm-3">
                                            <div class="img">
                                                <img src="{{ $product->image }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-sm-9 col-8 px-0 px-sm-3">
                                            <div class="row align-items-center row-gap-2">
                                                <div class="col-sm-8 col-12">
                                                    <h5 class="mb-1" title="{{ $product->attr_title }}">
                                                        {{ $product->name }}
                                                    </h5>
                                                    <p class="mb-0">{{ optional($product->generic)->name }}</p>
                                                    <p class="mb-0">{{ optional($product->company)->name }}</p>
                                                </div>
                                                <div class="col-sm-4 col-12 ms-auto d-block d-sm-block gap-sm-0 gap-3">
                                                    <p class="qt mb-1">
                                                        {{ __('Qty') }}:<span>{{ $product->pivot->quantity }}</span>
                                                    </p>
                                                    <p class="qt mb-0">
                                                        {{ __('Unit') }}:<span>{{ $product->pivot->unit_name }}</span>
                                                    </p>
                                                    <p class="qt mb-0">
                                                        {{ __('Total Price') }}:<span>{{ $product->pivot->total_price }}</span> @if($product->pivot->unit_discount > 0) <del>{{ $product->pivot->quantity * $product->pivot->unit_price }}</del>@endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <h4 class="mb-3 title">{{ __('Order Summary') }}</h4>
                            <div class="right d-flex flex-column justify-content-center">
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Sub Total Price') }}</h5>
                                    <p class="text-align-right">{!! get_taka_icon() .'(+)'. number_format(ceil($order->sub_total), 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Product Discount') }}</h5>
                                    <p class="text-right">{!! get_taka_icon() .'(-)'.number_format($order->product_discount, 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Voucher Discount') }}</h5>
                                    <p class="text-right">{!! get_taka_icon() .'(-)'. number_format($order->voucher_discount, 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Sub Total') }}</h5>
                                    <p class="text-right">{!! get_taka_icon() . number_format($order->total_amount - $order->delivery_fee, 2) !!}</p>
                                </div>
                                <div class="total-border d-flex justify-content-between mb-3">
                                    <h5>{{ __('Delivery Charge') }}</h5>
                                    <p class="text-align-right">{!! get_taka_icon() .'(+)'. number_format($order->delivery_fee, 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Payable Amount') }}</h5>
                                    <p class="text-align-right">{!! get_taka_icon() . number_format(ceil($order->total_amount), 2) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment-info-row mt-4">
                    <div class="row">
                        <div class="col">
                            <h4 class="mb-3 title">{{ __('Payment Information') }}</h4>
                            <div class="wrap overflow-auto">
                                <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>{{ __('SL') }}</th>
                                            <th>{{ __('Tran ID') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Submitted date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->payments as $payment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $payment->transaction_id }}</td>
                                                <td>{!! get_taka_icon() . number_format(ceil($payment->amount), 2) !!}
                                                </td>
                                                <td><span
                                                        class="{{ $payment->statusBg() }}">{{ $payment->statusTitle() }}</span>
                                                </td>
                                                <td>{{ timeFormate($payment->created_at) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Order-information-row-end -->
            </div>
        </div>
    </section>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $('.cancel-btn').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const button = $(this);
            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> {{ __("Processing...") }}');

            Swal.fire({
                title: '{{ __("Are you sure?") }}',
                text: '{{ __("You will not be able to revert this!") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __("Yes, cancel it!") }}',
                cancelButtonText: '{{ __("No, go back") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                } else {
                    button.prop('disabled', false).html('{{ __("Cancel") }}');
                }
            });
        });
    })
</script>
@endpush
