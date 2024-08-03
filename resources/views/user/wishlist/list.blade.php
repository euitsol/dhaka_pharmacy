@extends('user.layouts.master', ['pageSlug' => 'wishlist'])
@section('title', 'Wishlist')
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
                                            <span>{{ number_format($wish->product->discounted_price, 2) }}{{ __('tk') }}</span>
                                            @if ($wish->product->discounted_price != $wish->product->price)
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
                    <h3 class="my-5 text-danger text-center wish_empty_alert">{{ __('Wished Item Not Found') }}</h3>
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
    <script src="{{ asset('user/asset/js/wishlist.js') }}"></script>
    <script>
        const myDatas = {
            'login_route': `{{ route('login') }}`,
            'w_update_route': `{{ route('u.wishlist.update', 'param') }}`,
            'w_refresh_route': `{{ route('u.wishlist.refresh') }}`,
            'single_product_route': `{{ route('product.single_product', 'param') }}`,
            'single_order_route': `{{ route('u.ck.product.single_order') }}`,
            'taka_icon': `{!! get_taka_icon() !!}`,
        };
    </script>
@endpush
