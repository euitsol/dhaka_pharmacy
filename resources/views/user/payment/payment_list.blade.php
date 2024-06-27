@extends('user.layouts.master', ['pageSlug' => 'payment'])

@section('title', 'Payment List')
@section('content')
    <section class="my-order-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h3>{{ __('My Payments') }}</h3>
                    </div>
                    <div class="show-order d-flex align-items-center">
                        <h4 class="me-2">{{ __('Show:') }}</h4>
                        <select class="form-select order_filter" aria-label="Default select example">
                            <option value="all" {{ $filterValue == 'all' ? 'selected' : '' }}>{{ __('All orders') }}
                            </option>
                            <option value="5" {{ $filterValue == '5' ? 'selected' : '' }}>{{ __('Last 5 orders') }}
                            </option>
                            <option value="7" {{ $filterValue == '7' ? 'selected' : '' }}>{{ __('Last 7 days') }}
                            </option>
                            <option value="15" {{ $filterValue == '15' ? 'selected' : '' }}>{{ __('Last 15 days') }}
                            </option>
                            <option value="30" {{ $filterValue == '30' ? 'selected' : '' }}>{{ __('Last 30 days') }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="payment_wrap">
                @forelse ($payments as $payment)
                    <div class="order-row">
                        <div class="order-id-row">
                            <div class="row">
                                <div class="col-10">
                                    <h3 class="order-num">
                                        {{ __('Transaction ID: ') }}<span>{{ $payment->transaction_id }}</span>
                                    </h3>
                                    <p class="date-time">{{ __('Payment Date: ') }}<span>{{ $payment->date }}</span></p>
                                </div>
                                <div class="col-2 text-end">
                                    <span
                                        class="{{ $payment->statusBg() }}">{{ __(ucwords(strtolower(str_replace('-', ' ', $payment->statusTitle())))) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-9">
                                @forelse ($payment->order->order_items as $item)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row py-3 px-4">
                                                <div class="col-3">
                                                    <div class="img">
                                                        <img class="w-100" src="{{ $item->product->image }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="product-info">
                                                        <h2 class="name" title="{{ $item->product->attr_title }}">
                                                            {{ $item->product->name }}</h2>
                                                        <h3 class="cat">{{ $item->product->pro_sub_cat->name }}</h3>
                                                        <h3 class="cat">{{ $item->product->pro_cat->name }}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <p class="qty">Qty: <span>{{ $item->quantity }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            <div class="col-3 d-flex justify-content-end align-items-center py-3 px-4">
                                <div class="order-status">
                                    <div class="btn">
                                        <a href="#">{{ __('Details') }}</a>
                                    </div>
                                    <div class="total">
                                        <p class="total text-center">
                                            {{ __('Total: ') }}<span>{{ number_format(ceil($payment->amount)) }}</span>tk
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <h3 class="my-5 text-danger text-center">{{ __('Payment Not Found') }}</h3>
                @endforelse
            </div>
            <div class="paginate mt-3">
                {!! $pagination !!}
            </div>

        </div>
    </section>
@endsection
@push('js')
    <script>
        function statusBg(status) {
            switch (status) {
                case 0:
                    return 'badge bg-info';
                case 1:
                    return 'badge bg-success';
                case -1:
                    return 'badge bg-warning';
                case -2:
                    return 'badge bg-danger';
                default:
                    return 'badge bg-primary';
            }
        }

        function statusTitle(status) {
            switch (status) {
                case 0:
                    return 'Pending';
                case 1:
                    return 'Success';
                case -1:
                    return 'Failed';
                case -2:
                    return 'Cancel';
                default:
                    return 'Processing';
            }
        }

        function getHtml(payments) {
            var result = '';
            payments.forEach(function(payment) {
                result +=
                    `
                                <div class="order-row">
                                    <div class="order-id-row">
                                        <div class="row">
                                            <div class="col-10">
                                                <h3 class="order-num">Transaction ID: <span>${payment.transaction_id}</span></h3>
                                                <p class="date-time">Payment Date: <span>${payment.date}</span></p>
                                            </div>
                                            <div class="col-2 text-end"> 
                                            <span class="${statusBg(payment.status)}">${statusTitle(payment.status)}</span>`;

                result += `
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-9">
                                `;


                payment.order.order_items.forEach(function(item) {
                    result += `
                                                <div class="row">
                                                        <div class="col-12">
                                                            <div class="row py-3 px-4">
                                                                <div class="col-3">
                                                                    <div class="img">
                                                                        <img class="w-100" src="${item.product.image}" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="product-info">
                                                                        <h2 class="name" title="${item.product.attr_title}">${item.product.name}</h2>
                                                                        <h3 class="cat">${item.product.pro_sub_cat.name}</h3>
                                                                        <h3 class="cat">${item.product.pro_cat.name}</h3>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <p class="qty">Qty: <span>${item.quantity}</span></p>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                `;
                })

                result += `
                                            </div>
                                                <div class="col-3 d-flex justify-content-end align-items-center py-3 px-4">
                                                    <div class="order-status">
                                                        <div class="btn">
                                                            <a href="#">{{ __('Details') }}</a>
                                        `;
                result += `
                                                            
                                                        </div>
                                                        <div class="total">
                                                            <p class="total">Total: <span>${numberFormat(Math.ceil(parseInt(payment.amount)))}</span>tk</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        `;

            })
            return result;
        }
        $(document).ready(function() {
            $('.order_filter').on('change', function() {
                var filter_value = $(this).val();
                let url = (
                    "{{ route('u.payment.list', ['filter' => 'filter_value', 'page' => '1']) }}"
                );
                let _url = url.replace('filter_value', filter_value);
                _url = _url.replace(/&amp;/g, '&');
                console.log(_url);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = '';
                        var payments = data.payments.data;
                        if (payments.length === 0) {
                            result =
                                `<h3 class="my-5 text-danger text-center">Payment Not Found</h3>`;
                        } else {
                            result = getHtml(payments);
                        }


                        $('.payment_wrap').html(result);
                        $('.paginate').html(data.pagination);

                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching admin data:', error);
                    }
                });
            });
        });
    </script>
@endpush
