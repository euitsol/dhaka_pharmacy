@extends('local_area_manager.layouts.master', ['pageSlug' => 'feedback'])
@section('title', 'Feedback')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">
                                {{ __('Feedback') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('lam.fdk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Subject') }}</label>
                            <input type="text" name="subject"
                                class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Topic of your feedback') }}">
                            @include('alerts.feedback', ['field' => 'subject'])
                        </div>

                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" class="form-control  {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Share your detailed feedback here') }}"></textarea>
                            @include('alerts.feedback', ['field' => 'description'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Attached Files') }}</label>
                            <input type="file" name="uploadfiles" data-actualName="files[]" class=" filepond"
                                id="files" multiple>
                            @include('alerts.feedback', ['field' => 'files'])
                        </div>
                        <input class="btn btn-primary float-end" type="submit" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('filepond.fileupload')
@push('js')
    <script>
        file_upload(["#files"], "uploadfiles", "lam", true);
    </script>
@endpush
