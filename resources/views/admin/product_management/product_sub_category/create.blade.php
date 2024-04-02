@extends('admin.layouts.master', ['pageSlug' => 'product_sub_category'])

@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Product Sub Category') }}</h4>
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
                    <form method="POST" action="{{ route('product.product_sub_category.product_sub_category_create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Product Category') }}</label>
                            <select name="pro_cat_id" class="form-control">
                                <option selected hidden>{{__('Select Product Category')}}</option>
                                @foreach ($pro_cats as $cat)
                                    <option value="{{$cat->id}}" {{(old('pro_cat_id') == $cat->id) ? 'selected' : ''}}>{{$cat->name}}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'pro_cat_id'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" id="title" name="name" class="form-control" placeholder="Enter name"
                                value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ _('Slug') }}</label>
                            <input type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug" name="slug" placeholder="{{ _('Enter Slug (must be use - on white speace)') }}">
                            @include('alerts.feedback', ['field' => 'slug'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" accept="image/*" name="image" class="form-control image-upload"
                                value="{{ old('image') }}">
                            @include('alerts.feedback', ['field' => 'image'])
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
