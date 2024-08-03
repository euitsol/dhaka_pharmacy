@extends('user.layouts.master', ['pageSlug' => 'feedback'])
@section('title', 'Feedback')
@push('css')
    <link rel="stylesheet" href="{{ asset('user/asset/css/feedback.css') }}">
@endpush
@section('content')
    <section class="form-section">
        <div class="container">
            <div class="form-content">
                <div class="form-column">
                    <h2>{{ __('FEEDBACK') }}</h2>
                    <form action="{{ route('u.fdk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="subject" placeholder="Topic of your feedback">
                        @include('alerts.feedback', ['field' => 'subject'])
                        <textarea name="description" placeholder="Share your detailed feedback here"></textarea>
                        @include('alerts.feedback', ['field' => 'description'])
                        <input type="file" name="uploadfiles" data-actualName="files[]" class="form-control filepond"
                            id="files" multiple>
                        @include('alerts.feedback', ['field' => 'files'])
                        <input class="submit-button ms-auto" type="submit" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('filepond.fileupload')
@push('js')
    <script>
        file_upload(["#files"], "uploadfiles", "user", true);
    </script>
@endpush
