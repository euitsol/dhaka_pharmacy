@extends('admin.layouts.master', ['pageSlug' => 'product_sub_category'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Update Product Sub Category') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.product_sub_category.product_sub_category_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('product.product_sub_category.product_sub_category_edit', $product_sub_category->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('Product Category') }}</label>
                            <select name="pro_cat_id" class="form-control">
                                @foreach ($pro_cats as $cat)
                                    <option value="{{$cat->id}}" {{($product_sub_category->id == $cat->id) ? 'selected' : ''}}>{{$cat->name}}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'pro_cat_id'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name"
                                value="{{ $product_sub_category->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" accept="image/*" name="image" class="form-control image-upload"
                                value="{{ old('image') }}" multiple
                                @if(isset($product_sub_category->image))
                                    data-existing-files="{{ storage_url($product_sub_category->image) }}"
                                    data-delete-url=""
                                @endif
                                            >
                            @include('alerts.feedback', ['field' => 'image'])
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection