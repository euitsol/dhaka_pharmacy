@include('frontend.includes.upload_prescription')
<section class="col-md-3 col-lg-2 sidebar-cat-section">
    <div class="col sticky-col pb-4">
        <div class="upload_prescription mb-2">
            <h2 class="text-center cat-title up_button">{{ __('Upload Prescription') }}</h2>
        </div>
        <div class="categories_menu">
            <h2 class="text-center cat-title d-lg-block d-none">{{ __('Categories') }}</h2>
            <div class="row py-4 px-4  justify-content-center">
               
                    @foreach ($menuItems as $item)
                        <a href="{{ route('category.products', ['category' => $item->slug]) }}"
                                class="col-6 text-center single-cat text-decoration-none {{ isset($category) && $category->id == $item->id ? 'active' : '' }}">
                            <div class="icon m-auto">
                                <img class="w-100" src="{{ storage_url($item->image) }}" alt="category icon">
                            </div>
                            <h2 class="mt-2">{{ __($item->name) }}</h2>
                        </a>
                    @endforeach
               
            </div>
        </div>
    </div>
</section>
