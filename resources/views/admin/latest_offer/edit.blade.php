@extends('admin.layouts.master', ['pageSlug' => 'latest_offer'])
@section('title', 'Edit Latest Offer')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Latest Offer') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'latest_offer.lf_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('latest_offer.lf_edit', $latest_offer->id) }}"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Title') }}</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter offer title"
                                value="{{ $latest_offer->title }}">
                            @include('alerts.feedback', ['field' => 'title'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" name="image" class="form-control image-upload" accept="image/*"
                                @if (isset($latest_offer->image)) data-existing-files="{{ storage_url($latest_offer->image) }}"
                                    data-delete-url="" @endif>
                            @include('alerts.feedback', ['field' => 'image'])
                        </div>
                    </div>
                    <div class="card-footer  text-end">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
