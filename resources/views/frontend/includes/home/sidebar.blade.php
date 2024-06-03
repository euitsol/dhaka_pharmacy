
<section class="col-md-3 col-lg-2 sidebar-cat-section">
    <div class="col sticky-col pb-4">
        <h2 class="text-center cat-title">{{__('Categories')}}</h2>
        <div class="row mt-4 px-4">
            @foreach ($menuItems as $item)
                <a href="{{route('category.products',['category'=>$item->slug])}}" class="col-6 text-center single-cat text-decoration-none {{(isset($category) && $category->id == $item->id) ? 'active' : ''}}">
                    <div class="icon m-auto">
                        <img class="w-100" src="{{storage_url($item->image) }}"
                            alt="category icon">
                    </div>
                    <h2 class="mt-2">{{__($item->name)}}</h2>
                </a>
            @endforeach
        </div>
    </div>
</section>
