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
                    <div class="page-title mb-0 mb-sm-3">
                        <h3>{{ __('My Wishlist') }}</h3>
                    </div>
                </div>
            </div>
            <div class="order_wrap" id="wish_wrap">
                @forelse ($wishes as $wish)
                    <div class="order-row wish_item">
                        <div class="row px-4 py-3 py-sm-0 row-gap-sm-0 row-gap-3" style="position: relative;">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="row py-0 py-sm-3">
                                    <div class="col-xl-2 col-lg-4 col-md-5 col-sm-2 col-3 px-md-3 px-0">
                                        <div class="img">
                                            <img class="w-100" src="{{ optional($wish->product)->image }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-10 col-lg-8 col-md-7 col-sm-10 col-8">
                                        <div class="product-info">
                                            <h2 class="name" title="{{ optional($wish->product)->attr_title }}">
                                                {{ optional($wish->product)->name }}</h2>
                                            <h3 class="cat" title="{{ optional($wish->product->pro_sub_cat)->name }}">{{ optional($wish->product->pro_sub_cat)->name }}</h3>
                                            <h3 class="cat" title="{{ optional($wish->product->generic)->name }}">{{ optional($wish->product->generic)->name }}</h3>
                                            <h3 class="cat" title="{{ optional($wish->product->company)->name }}">{{ optional($wish->product->company)->name }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 d-flex justify-content-md-end align-items-center py-0 py-sm-3 px-0 px-md-3">
                                <div class="order-status p-0 d-md-block d-flex flex-column flex-sm-row-reverse flex-md-row">
                                    <div class="total mb-2">
                                        <p class="total text-center ms-0">{{ __('Total:') }}
                                            <span>{{ number_format($wish->product->discounted_price, 2) }}{{ __('tk') }}</span>
                                            @if ($wish->product->discounted_price != $wish->product->price)
                                                <sup>
                                                    <del
                                                        class="text-danger">{{ number_format($wish->product->price, 2) }}{{ __('tk') }}</del>
                                                </sup>
                                            @endif
                                        </p>
                                        <div class="favorite wishlist_item me-0 text-danger">
                                            <a href="{{ route('u.wishlist.update', encrypt($wish->product->id)) }}">
                                            <i class="fa-solid fa-trash-can wish_update wish_remove_btn"
                                                data-pid="{{ $wish->product->pid }}"></i></a>
                                        </div>
                                    </div>
                                    <div class="btns w-100 mx-auto">
                                        <a class="button"
                                            href="{{ route('product.single_product', $wish->product->slug) }}">{{ __('Details') }}</a>
                                        <div class="add_to_card">
                                            <a class="cart-btn button" href="javascript:void(0)"
                                                data-product_slug="{{ $wish->product->slug }}">
                                                {{ __('Add To Cart') }}</a>
                                        </div>
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
                <span class="float-end">
                    {{ $wishes->firstItem() }} - {{ $wishes->lastItem() }} {{ __('of') }} {{ $wishes->total() }}
                    {{ __('items') }}
                </span>
                {{ $wishes->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>
@endsection
