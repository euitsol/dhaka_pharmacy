@extends('user.layouts.master', ['pageSlug' => 'wishlist'])

@section('title', 'Wish List')
@push('css')
    <link rel="stylesheet" href="{{ asset('user/asset/css/wishlist.css') }}">
@endpush
@section('content')
    <section class="my-order-section">
        <div class="container">
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
                {{ $wishes->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </section>
@endsection
@push('js')
    @include('frontend.includes.wishlist_js')
@endpush
