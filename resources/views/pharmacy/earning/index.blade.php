@extends('pharmacy.layouts.master', ['pageSlug' => 'earning'])
@section('title', 'My Earnings')
@push('css')
    <style>
        .myTab.active {
            color: var(--primary-color) !important;
            border: 0;
            border-bottom: 1px solid var(--primary) !important;
            background: transparent !important;


        }
    </style>
@endpush
@section('content')
    <div class="row ">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">{{ __('My Earnings') }}</h4>
                </div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="myTab nav-link active text-muted" id="nav-overview-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-overview" type="button" role="tab" aria-controls="nav-overview"
                                aria-selected="true">{{ __('Overview') }}</button>
                            <button class="myTab nav-link text-muted" id="nav-financial-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-financial" type="button" role="tab" aria-controls="nav-financial"
                                aria-selected="false">{{ __('Financial documents') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content py-4" id="nav-tabContent">
                        <div class="myContent tab-pane fade show active" id="nav-overview" role="tabpanel"
                            aria-labelledby="nav-overview-tab">
                            @include('pharmacy.earning.overview')
                        </div>
                        <div class="myContent tab-pane fade" id="nav-financial" role="tabpanel"
                            aria-labelledby="nav-financial-tab">
                            @include('pharmacy.earning.finance')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('filepond.fileupload')
@push('js')
    <script>
        file_upload(["#files"], "uploadfiles", "pharmacy", true);
    </script>
@endpush
