@extends('admin.layouts.master', ['pageSlug' => 'product_sub_category'])
@section('title', 'Edit Product Sub Category')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Product Sub Category') }}</h4>
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
                <form method="POST"
                    action="{{ route('product.product_sub_category.product_sub_category_edit', $product_sub_category->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Product Category') }}<span class="text-danger">*</span></label>
                            <select name="pro_cat_id" class="form-control">
                                @foreach ($pro_cats as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $product_sub_category->pro_cat->id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'pro_cat_id'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }}<span class="text-danger">*</span></label>
                            <input type="text" id="title" name="name" class="form-control"
                                placeholder="Enter name" value="{{ $product_sub_category->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                            <input type="text" value="{{ $product_sub_category->slug }}"
                                class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug"
                                name="slug" placeholder="{{ __('Enter Slug (must be use - on white speace)') }}">
                            @include('alerts.feedback', ['field' => 'slug'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" accept="image/*" name="image" class="form-control image-upload"
                                value="{{ old('image') }}" multiple
                                @if (isset($product_sub_category->image)) data-existing-files="{{ storage_url($product_sub_category->image) }}"
                                    data-delete-url="" @endif>
                            @include('alerts.feedback', ['field' => 'image'])
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
