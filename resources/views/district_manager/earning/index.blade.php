@extends('district_manager.layouts.master', ['pageSlug' => 'earning'])
@section('title', 'My Earnings')
@push('css_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@section('content')
    <div class="row earning">
        <div class="col-md-12">
            <div class="card wrap">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title">{{ __('My Earnings') }}</h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('dm.earning.withdraw') }}" class="btn btn-primary">{{ __('Withdraw') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="myTab nav-link active text-muted" id="nav-overview-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-overview" type="button" role="tab" aria-controls="nav-overview"
                                aria-selected="true">{{ __('Overview') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content py-4" id="nav-tabContent">
                        <div class="myContent tab-pane fade show active" id="nav-overview" role="tabpanel"
                            aria-labelledby="nav-overview-tab">
                            @include('district_manager.earning.overview')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_link')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endpush
@push('js')
    <script>
        const myRoutes = {
            'filter': `{{ route('dm.earning.index', ['page' => '1', 'from' => '_from', 'to' => '_to']) }}`,
            'report': `{{ route('dm.earning.report') }}`,
        };
    </script>
    <script src="{{ asset('earning/earning.js') }}"></script>
@endpush
