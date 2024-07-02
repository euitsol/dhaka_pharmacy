@extends('admin.layouts.master', ['pageSlug' => 'review'])
@section('title', 'Update Review')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Update Review') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'review.review_list',
                                'params' => $review->product_id,
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('review.review_edit', $review->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="product_id" value="{{ $review->product_id }}">
                        <div class="form-group">
                            <label>{{ __('Review') }}</label>
                            <textarea name="description" class="form-control" placeholder="Tell us about your experience...">{!! $review->description !!}</textarea>
                            @include('alerts.feedback', ['field' => 'description'])
                        </div>
                        <button type="submit" class="btn btn-primary float-end">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
