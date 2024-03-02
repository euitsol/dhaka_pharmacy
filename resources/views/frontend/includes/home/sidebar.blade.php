
<section class="col-md-3 col-lg-2 sidebar-cat-section">
    <div class="col sticky-col pb-4">
        <h2 class="text-center cat-title">{{__('Categories')}}</h2>
        <div class="row mt-4 px-4">
            @foreach ($menuItems as $item)
                <a href="{{route('category.products',$item->slug)}}" class="col-6 text-center single-cat text-decoration-none">
                    <div class="icon m-auto">
                        <img class="w-100" src="{{storage_url($item->image) }}"
                            alt="category icon">
                    </div>
                    <h2 class="mt-2">{{__($item->name)}}</h2>
                </a>
            @endforeach
            {{-- <a href="#" class="col-6 text-center single-cat text-decoration-none">
                <div class="icon  m-auto">
                    <img class="w-100" src="{{ asset('frontend/asset/img/Diagnostic-Center.png') }}"
                        alt="category icon">
                </div>
                <h2 class="mt-2">Diagnostic Center</h2>
            </a>
            <a href="#" class="col-6 text-center single-cat text-decoration-none">
                <div class="icon  m-auto">
                    <img class="w-100" src="{{ asset('frontend/asset/img/dental.png') }}"
                        alt="category icon">
                </div>
                <h2 class="mt-2">Dental Care</h2>
            </a>
            <a href="#" class="col-6 text-center single-cat text-decoration-none">
                <div class="icon  m-auto">
                    <img class="w-100" src="{{ asset('frontend/asset/img/Surgical-Product.png') }}"
                        alt="category icon">
                </div>
                <h2 class="mt-2">Surgical Product</h2>
            </a>
            <a href="#" class="col-6 text-center single-cat text-decoration-none">
                <div class="icon m-auto">
                    <img class="w-100" src="{{ asset('frontend/asset/img/Medical-Equipment.png') }}"
                        alt="category icon">
                </div>
                <h2 class="mt-2">Medical Equipment</h2>
            </a>
            <a href="#" class="col-6 text-center single-cat text-decoration-none">
                <div class="icon m-auto">
                    <img class="w-100" src="{{ asset('frontend/asset/img/baby-care.png') }}"
                        alt="category icon">
                </div>
                <h2 class="mt-2">Baby Care</h2>
            </a>
            <a href="#" class="col-6 text-center single-cat text-decoration-none">
                <div class="icon m-auto">
                    <img class="w-100" src="{{ asset('frontend/asset/img/woman-care.png') }}"
                        alt="category icon">
                </div>
                <h2 class="mt-2">Women's Care</h2>
            </a>
            <a href="#" class="col-6 text-center single-cat text-decoration-none">
                <div class="icon m-auto">
                    <img class="w-100" src="{{ asset('frontend/asset/img/personal-care.png') }}"
                        alt="category icon">
                </div>
                <h2 class="mt-2">Personal Care</h2>
            </a>
            <a href="#" class="col-6 text-center single-cat text-decoration-none">
                <div class="icon m-auto">
                    <img class="w-100" src="{{ asset('frontend/asset/img/dental.png') }}"
                        alt="category icon">
                </div>
                <h2 class="mt-2">Dental Care</h2>
            </a>
            <a href="#" class="col-6 text-center single-cat text-decoration-none">
                <div class="icon m-auto">
                    <img class="w-100" src="{{ asset('frontend/asset/img/Surgical-Product.png') }}"
                        alt="category icon">
                </div>
                <h2 class="mt-2">Surgical Product</h2>
            </a> --}}
        </div>
    </div>
</section>
