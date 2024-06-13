@extends('user.layouts.master', ['pageSlug' => 'wishlist'])

@section('title', 'Wish List')
@push('css')
    <link rel="stylesheet" href="{{ asset('user/asset/css/wishlist.css') }}">
@endpush
@section('content')
    <section class="my-order-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h3>{{ __('My Wishlist') }}</h3>
                    </div>
                    <div class="show-order d-flex align-items-center">
                        <h4 class="me-2">{{ __('Show:') }}</h4>
                        <select class="form-select order_filter" aria-label="Default select example">
                            <option value="all" {{ $filterValue == 'all' ? 'selected' : '' }}>{{ __('All orders') }}
                            </option>
                            <option value="5" {{ $filterValue == '5' ? 'selected' : '' }}>{{ __('Last 5 Wishes') }}
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
            <div class="order_wrap" id="wish_wrap">
                @forelse ($wishes as $wish)
                    <div class="order-row wish_item">
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row py-3 px-4">
                                            <div class="col-3">
                                                <div class="img">
                                                    <img class="w-100" src="{{ $wish->product->image }}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="product-info">
                                                    <h2 class="name" title="{{ $wish->product->attr_title }}">
                                                        {{ $wish->product->name }}</h2>
                                                    <h3 class="cat">{{ $wish->product->pro_sub_cat->name }}</h3>
                                                    <h3 class="cat">{{ $wish->product->pro_cat->name }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 d-flex justify-content-center align-items-center py-3 px-4">
                                <div class="order-status p-0">
                                    <div class="total">
                                        <p class="total text-center ms-3">{{ __('Total:') }}
                                            <span>{{ number_format($wish->product->discountPrice, 2) }}{{ __('tk') }}</span>
                                            @if ($wish->product->discountPrice != $wish->product->price)
                                                <sup>
                                                    <del
                                                        class="text-danger">{{ number_format($wish->product->price, 2) }}{{ __('tk') }}</del>
                                                </sup>
                                            @endif
                                        </p>
                                        <div class="favorite wishlist_item me-3 text-danger">
                                            <i class="fa-solid fa-trash-can wish_update wish_remove_btn"
                                                data-pid="{{ encrypt($wish->product->id) }}"></i>
                                        </div>
                                    </div>
                                    <div class="btns w-100 mx-auto">
                                        <a class="button"
                                            href="{{ route('product.single_product', $wish->product->slug) }}">{{ __('Details') }}</a>
                                        <form action="{{ route('u.ck.product.single_order') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="slug" value="{{ $wish->product->slug }}">
                                            <input type="hidden" name="unit_id"
                                                value="{{ $wish->product->units[0]->id }}">
                                            <input type="submit" class="button" value="Order Now">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <h5 class="text-center wish_empty_alert">{{ __('Wished Item Not Found') }}</h5>
                @endforelse
            </div>
            <div class="paginate mt-3">
                {!! $pagination !!}
            </div>
        </div>
    </section>
@endsection
@push('js')
    @include('frontend.includes.wishlist_js')

    <script>
        function getHtml(wishes) {
            var result = '';
            wishes.forEach(function(wish) {
                let product_details = `{{ route('product.single_product', 'param') }}`;
                product_details = product_details.replace('param', wish.product.slug);
                result +=
                    `<div class="order-row wish_item">
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row py-3 px-4">
                                            <div class="col-3">
                                                <div class="img">
                                                    <img class="w-100" src="${wish.product.image}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="product-info">
                                                    <h2 class="name" title="${wish.product.attr_title}">
                                                        ${wish.product.name}</h2>
                                                    <h3 class="cat">${wish.product.pro_sub_cat.name}</h3>
                                                    <h3 class="cat">${wish.product.pro_cat.name}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 d-flex justify-content-center align-items-center py-3 px-4">
                                <div class="order-status p-0">
                                    <div class="total">
                                        <p class="total text-center ms-3">{{ __('Total:') }}
                                            <span>${numberFormat(wish.product.discountPrice, 2) }{{ __('tk') }}</span>`;
                if (wish.product.discountPrice != wish.product.price) {
                    result +=
                        `<sup><del class="text-danger">${numberFormat(wish.product.price, 2)}{{ __('tk') }}</del></sup>`;
                }
                result += `       
                                        </p>
                                        <div class="favorite wishlist_item me-3 text-danger">
                                            <i class="fa-solid fa-trash-can wish_update wish_remove_btn"
                                                data-pid="${wish.product.pid}"></i>
                                        </div>
                                    </div>
                                    <div class="btns w-100 mx-auto">
                                        <a class="button"
                                            href="${product_details}">{{ __('Details') }}</a>
                                        <form action="{{ route('u.ck.product.single_order') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="slug" value="${wish.product.slug}">
                                            <input type="hidden" name="unit_id"
                                                value="${wish.product.units[0].id}">
                                            <input type="submit" class="button" value="Order Now">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>`;

            });
            return result;
        }
        $(document).ready(function() {
            $('.order_filter').on('change', function() {
                var filter_value = $(this).val();
                let url = (
                    "{{ route('u.wishlist.list', ['filter' => 'filter_value', 'page' => '1']) }}"
                );
                let _url = url.replace('filter_value', filter_value);
                _url = _url.replace(/&amp;/g, '&');
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = '';
                        var wishes = data.wishes.data;
                        if (wishes.length === 0) {
                            result =
                                `<h3 class="my-5 text-danger text-center">Order Not Found</h3>`;
                        } else {
                            result = getHtml(wishes);
                        }


                        $('#wish_wrap').html(result);
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
