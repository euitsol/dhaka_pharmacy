@extends('admin.layouts.master', ['pageSlug' => 'user_tips'])
@section('title', 'Create User Tips')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create User Tips') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'user_tips.tips_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('user_tips.tips_create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" name="image" class="form-control image-upload" accept="image/*">
                            @include('alerts.feedback', ['field' => 'image'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" placeholder="Write here tips">{{ old('description') }}</textarea>
                            @include('alerts.feedback', ['field' => 'description'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Product') }}</label>
                            <select name="products[]"
                                class="form-control product {{ $errors->has('products') ? ' is-invalid' : '' }}"
                                multiple="multiple">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ in_array($product->id, (array) old('products')) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'products'])
                        </div>
                    </div>
                    <div class="card-footer  text-end">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
