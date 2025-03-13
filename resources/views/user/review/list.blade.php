@extends('user.layouts.master', ['pageSlug' => 'review'])
@section('title', 'Review')
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
    <style>
        .review_wrap .review_submit {
            font-size: 16px;
            font-weight: 400;
            line-height: 19px;
            text-decoration: none;
            color: var(--white);
            background: var(--btn_bg);
            padding: 7px 11px;
            border-radius: 5px;
            border: 1px solid var(--btn_bg);
            transition: 0.4s;
        }

        .review_wrap .review_submit:hover {
            background: transparent;
            color: var(--btn_bg);
        }
    </style>
@endpush
@section('content')
    <section class="my-order-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title mb-3">
                        <h3>{{ __('All Reviews') }}</h3>
                    </div>
                </div>
            </div>
            <div class="review_wrap">
                @forelse ($products as $product)
                    <div class="order-row">
                        <div class="row align-items-center py-4 px-xl-3 px-xxl-0 px-3">
                            <div class="col-lg-1 col-md-2 col-sm-2 col-3">
                                <div class="img w-100 text-center">
                                    <div id="lightbox" class="lightbox tips_image">
                                        <div class="lightbox-content">
                                            <img src="{{ $product->image }}" class="lightbox_image">
                                        </div>
                                        <div class="close_button fa-beat">X</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg col-md-5 col-sm-10 col-9">
                                <div class="product-info">
                                    <h5 class="mb-0" title="{{ $product->attr_title }}">
                                        {{ $product->name }}
                                    </h5>
                                    <p class="mb-0" title="{{ $product->pro_sub_cat?->name }}">
                                        {{ $product->pro_sub_cat?->name }}
                                    </p>
                                    <p class="mb-0" title="{{ $product->pro_cat?->name }}">{{ $product->pro_cat?->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg col-md-5 col-12">
                                <div class="product-info">
                                    <p class="mb-0">
                                        <strong>{{ __('Generic Name: ') }}</strong>{{ $product->generic?->name }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>{{ __('Company: ') }}</strong>{{ $product->company?->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-5 ms-auto col-xl col-sm-12 col-12">
                                <div class="product-info">
                                    <p class="mb-0 text-md-start text-lg-center">
                                        <strong>{{ __('Strength: ') }}</strong>{{ $product->strength?->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-5 col-xl col-sm-12 ms-auto ms-md-0 col-12">
                                <div class="product-info">
                                    <p class="mb-0 text-md-start text-lg-center text-left">
                                        <strong>{{ __('Price: ') }}</strong>
                                        <span>{{ number_format($product->discounted_price, 2) }}{{ __('tk') }}</span><sup
                                            class="text-danger"><del>{{ $product->discounted_price != $product->price ? number_format($product->price, 2) . 'tk' : '' }}</del></sup>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-4">
                            <div class="col-12">
                                @if ($product->self_review !== null)
                                    <div class="review px-3">
                                        <p class="mb-0" style="text-align: justify">
                                            <strong>{{ __('Your Review: ') }}</strong>{{ $product->self_review?->description }}
                                        </p>
                                    </div>
                                @else
                                    <form action="{{ route('u.review.store') }}" method="POST" class="px-3">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <textarea name="description" class="w-100 p-2" rows="10" placeholder="Tell us about your experience..."></textarea>
                                        @include('alerts.feedback', ['field' => 'description'])
                                        <input type="submit" class="btn review_submit float-end mt-2" value="Submit">
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <h3 class="my-5 text-danger text-center">{{ __('Product Not Found For Review') }}</h3>
                @endforelse
            </div>
            <div class="paginate mt-3">
                {!! $products->links('vendor.pagination.bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    <script>
        const myDatas = {
            'review_update': `{{ route('u.review.store') }}`,
            'csrf': `@csrf`,
            'validation_error': `@include('alerts.feedback', ['field' => 'description'])`,
        };
    </script>
    <script src="{{ asset('user/asset/js/review.js') }}"></script>
@endpush
