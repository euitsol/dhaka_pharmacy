{{-- @include('frontend.includes.upload_prescription') --}}
<section class="col-3 col-xxl-2 col-12 col-lg-3 sidebar-cat-section">
    <div class="col sticky-col pb-2 pb-lg-4">
        <div class="upload_prescription mb-2">
            <h2 class="text-center cat-title d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#prescriptionModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload me-2" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                </svg> {{ __('Upload Prescription') }}
            </h2>
        </div>
        <div class="categories_menu">
            <h2 class="text-center cat-title d-lg-block d-none">{{ __('Categories') }}</h2>
            <div class="row py-2 px-4 justify-content-center">
                @foreach ($menuItems as $item)
                    <a href="{{ route('category.products', ['category' => $item->slug]) }}"
                        class="col-6 text-center single-cat text-decoration-none {{ isset($category) && $category->id == $item->id ? 'active' : '' }}" title="{{ __($item->name) }}">
                        <div class="icon m-auto">
                            <img class="w-100 h-100"  src="{{ storage_url($item->image) }}" alt="category icon">
                        </div>
                        <h2 class="mt-2">{{ __($item->name) }}</h2>
                    </a>
                @endforeach

            </div>
        </div>
    </div>
</section>
