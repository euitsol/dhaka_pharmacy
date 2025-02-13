@extends('frontend.layouts.master')
@section('title', __('Not Found'))

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center error-card" style="min-height: 100vh;">
        <div class="col-md-8 text-center">
            <div class="card mb-5">
                <div class="card-body">
                    <h6 class="card-title mb-4 text-justify">{{ __('You can always upload your prescription. We will take care of the rest') }}</h6>
                        <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#prescriptionModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload me-2" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                            </svg>
                            Upload Prescription
                        </button>
                </div>
            </div>
            <h1 class="display-4 text-primary mb-4">404 - Page Not Found</h1>
            <p class="lead mb-4">Oops! The page you're looking for doesn't exist.</p>
            <a href="{{ route('home') }}" class="text-decoration-none mb-5 d-inline-block">Go back to homepage</a>

        </div>
    </div>
</div>
@endsection
