@extends('user.layouts.master', ['pageSlug' => 'order'])
@section('title', 'Order List')
@section('content')
    <section class="my-order-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="show-order d-flex align-items-center">
                        <h3>{{ __('My Orders') }}</h3>
                    </div>
                </div>
            </div>
            <div class="order_wrap">
                @forelse ($orders as $order)
                    <div class="order-row">
                        <div class="order-id-row">
                            <div class="row align-content-center">
                                <div class="col-xl-8 col-lg-7 col-md-6 col-12">
                                    <div class="d-flex flex-lg-row flex-column" style="position: relative">
                                        <div class="text">
                                            <h3 class="order-num">
                                                {{ __('Order: ') }}<span>{{ $order->order_id }}</span>
                                            </h3>
                                            <p class="date-time">
                                                {{ __('Placed on ') }}<span>{{ timeFormate($order->created_at) }}</span>
                                            </p>
                                        </div>
                                        <div class="status mt-1 mt-sm-0 ms-0 ms-lg-3 order-info-section">
                                            <div class="order-status-row d-flex gap-3 align-items-center">
                                                <span class="badge {{ $order->getStatusBg() }}">{{ __($order->status_string) }}</span>
                                                @if (isset($order->otp))
                                                    <p class="fw-bold">{{ __('OTP: ') }}{{ $order->otp }}
                                                    </p>
                                                @endif
                                            </div>
                                            <p class="total p-0">
                                                {{ __('Total Amount: ') }}<span
                                                    class="fw-bold">{{ number_format($order->total_amount, 2) }}{{ __('tk') }}</span>
                                                @if ($order->product_discount > 0 || $order->voucher_discount > 0)
                                                    <sup
                                                        class="text-danger"><del>{{ number_format($order->sub_total + $order->delivery_fee, 2) }}{{ __('tk') }}</del></sup>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-5 col-md-6 col-12 text-md-end text-start pb-3">
                                    <div class="order-status">
                                        <div
                                            class="p-0 d-flex gap-1 justify-content-md-end justify-content-start mt-2 mt-md-0">
                                            <a class="btn btn-info"
                                                href="{{ route('u.order.details', encrypt($order->order_id)) }}">{{ __('Details') }}</a>
                                            @if ($order->status == App\Models\Order::INITIATED)
                                                <a class="btn btn-success text-white"
                                                    href="javascript:void(0)">{{ __('Pay Now') }}</a>
                                            @endif
                                            @if(($order->status == App\Models\Order::SUBMITTED) || ($order->status == App\Models\Order::INITIATED))
                                                <a class="btn btn-danger cancel-btn"
                                                    href="{{ route('u.order.cancel', encrypt($order->order_id)) }}">{{ __('Cancel') }}</a>
                                            @endif
                                            <a class="btn btn-primary">{{ __('Re-order') }}</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12 px-3 px-md-4">
                                @foreach ($order->products as $product)
                                    <div
                                        class="row py-3 py-md-3 px-3 px-md-4 align-items-start align-items-md-center list-item">
                                        <div class="col-md-2 col-sm-3 col-4 px-0 px-sm-3">
                                            <div class="img">
                                                <img class="w-100" src="{{ $product->image }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-sm-9 col-8">
                                            <div class="row justify-content-between">
                                                <div class="col-md-9 col-sm-8 col-12">
                                                    <div class="product-info">
                                                        <h2 class="name" title="{{ $product->attr_title }}">
                                                            {{ $product->name }}</h2>
                                                        <p class="cat"
                                                            title="{{ optional($product->pro_sub_cat)->name }}">
                                                            {{ optional($product->pro_sub_cat)->name }}</p>
                                                        <p class="cat" title="{{ optional($product->generic)->name }}">
                                                            {{ optional($product->generic)->name }}</p>
                                                        <p class="cat" title="{{ optional($product->company)->name }}">
                                                            {{ optional($product->company)->name }}</p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-md-3 mt-2 mt-sm-0 col-sm-4 col-12 d-flex d-sm-block gap-4 gap-sm-0">
                                                    <p class="qty">
                                                        {{ __('Qty: ') }}<span>{{ optional($product->pivot)->quantity < 10 ? '0' . $product->pivot->quantity : $product->pivot->quantity }}</span>
                                                    </p>
                                                    <p class="qty">
                                                        {{ __('Unit: ') }}<span>{{ optional($product->pivot)->unit->name }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <h3 class="my-5 text-danger text-center">{{ __('Order Not Found') }}</h3>
                @endforelse
            </div>
            <div class="paginate mt-3">
                <span class="float-end">
                    {{ $orders->firstItem() }} - {{ $orders->lastItem() }} {{ __('of') }} {{ $orders->total() }}
                    {{ __('items') }}
                </span>
                {{ $orders->links('pagination::bootstrap-4') }}
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
                text: '{{ __("You won\'t be able to revert this!") }}',
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
