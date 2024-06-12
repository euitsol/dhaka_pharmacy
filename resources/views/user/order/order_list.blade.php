@extends('user.layouts.master', ['pageSlug' => 'order'])

@section('title', 'Order List')
@section('content')
    <section class="my-order-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h3>{{ __('My Orders') }}</h3>
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
            <div class="order_wrap">
                @forelse ($orders as $order)
                    <div class="order-row">
                        <div class="order-id-row">
                            <div class="row">
                                <div class="col-10">
                                    <h3 class="order-num">{{ __('Order: ') }}<span>{{ $order->order_id }}</span></h3>
                                    <p class="date-time">{{ __('Placed on ') }}<span>{{ $order->place_date }}</span></p>
                                </div>
                                <div class="col-2 text-end">
                                    @if ($order->od)
                                        <span
                                            class="{{ $order->od->statusBg() }}">{{ __(ucwords(strtolower(str_replace('-', ' ', $order->od->statusTitle())))) }}</span>
                                    @else
                                        <span class="badge bg-info">{{ __('Pending') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-9">
                                @forelse ($order->order_items as $item)
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
                                        <p class="total text-center">Total: <span>{{ $order->totalPrice }}</span>tk</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <h3 class="my-5 text-danger text-center">Order Not Found</h3>
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
                    return 'badge bg-warning';
                case 2:
                    return 'badge bg-secondary';
                case 3:
                    return 'badge bg-danger';
                case 4:
                    return 'badge bg-primary';
                case 5:
                    return 'badge bg-dark';
                case 6:
                    return 'badge bg-success';
                case 7:
                    return 'badge bg-danger';

            }
        }

        function statusTitle(status) {
            switch (status) {
                case 0:
                    return 'Pending';
                case 1:
                    return 'Preparing';
                case 2:
                    return 'Waiting For Rider';
                case 3:
                    return 'Waiting For Pickup';
                case 4:
                    return 'Picked Up';
                case 5:
                    return 'Delivered';
                case 6:
                    return 'Finish';
                case 7:
                    return 'Cancel';
            }
        }


        function getHtml(orders) {
            var result = '';
            orders.forEach(function(order) {
                result += `
                                <div class="order-row">
                                    <div class="order-id-row">
                                        <div class="row">
                                            <div class="col-10">
                                                <h3 class="order-num">Order: <span>${order.order_id}</span></h3>
                                                <p class="date-time">Placed on <span>${order.place_date}</span></p>
                                            </div>
                                            <div class="col-2 text-end"> 
                                `;
                if (order.od) {
                    result +=
                        `<span class="${statusBg(order.od.status)}">${statusTitle(order.od.status)}</span>`;
                } else {
                    result +=
                        `<span class="badge bg-info">{{ __('Pending') }}</span>`;
                }
                result += `
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-9">
                                `;


                order.order_items.forEach(function(item) {
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
                                                            <p class="total">Total: <span>${order.totalPrice}</span>tk</p>
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
                var status = "{{ $status }}";
                let url = (
                    "{{ route('u.order.list', ['filter' => 'filter_value', 'page' => '1', 'status' => '_status']) }}"
                );
                let _url = url.replace('filter_value', filter_value);
                let __url = _url.replace('_status', status);
                __url = __url.replace(/&amp;/g, '&');
                console.log(__url);
                $.ajax({
                    url: __url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = '';
                        var orders = data.orders.data;
                        if (orders.length === 0) {
                            result =
                                `<h3 class="my-5 text-danger text-center">Order Not Found</h3>`;
                        } else {
                            result = getHtml(orders);
                        }


                        $('.order_wrap').html(result);
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
