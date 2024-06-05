@extends('user.layouts.master', ['pageSlug' => 'wishlist'])

@section('title', 'Wish List')
@push('css')
    <style>
        .my-order-section .order-row .order-status .btns .button {
            height: 60px;
            width: 185px;
            border: 2px solid #000;
            border-radius: 10px;
            color: var(--text);
            text-decoration: none;
            font-size: 24px;
            font-weight: 400;
            line-height: 60px;
            display: inline-block;
            transition: 0.4s;
            text-align: center
        }

        .my-order-section .order-row .order-status .btns .button:hover {
            background: var(--primary);
            border-color: var(--primary);
            ;
        }

        .my-order-section .order-row .order-status .btns {
            display: flex;
            gap: 15px;
            transition: .4s;
        }

        .my-order-section .order-row .order-status .btns:hover a {
            color: var(--bs-btn-hover-color);
            background-color: var(--bs-btn-hover-bg);
            border-color: var(--bs-btn-hover-border-color);
        }

        .my-order-section .order-row .order-status .total {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: space-between;
        }
    </style>
@endpush
@section('content')
    <section class="my-order-section">
        <div class="container">
            <div class="order_wrap">
                @forelse ($wishes as $wish)
                    <div class="order-row">
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
                                            <i class="{{ $wish->product->wish && $wish->product->wish->status == 1 ? 'fa-solid' : 'fa-regular' }} fa-heart wish_update"
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
                    <h3 class="my-5 text-danger text-center">{{ __('Wish Item Not Found') }}</h3>
                @endforelse
            </div>
            <div class="paginate mt-3">
                {{ $wishes->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="{{ asset('user/asset/js/wishlist.js') }}"></script>
    <script>
        const data = {
            wishlist_url: `{{ route('u.wishlist.update', 'param') }}`,
        };
    </script>
@endpush
