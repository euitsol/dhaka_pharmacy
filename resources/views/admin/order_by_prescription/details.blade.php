@extends('admin.layouts.master', ['pageSlug' => "ubp_$details->status_string"])
@section('title', 'Order By Prescription Details')
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/css/ordermanagement.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Order By Prescription') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('User Information') }}</h4>
                                </div>
                                <div class="card-body">
                                @if($details->creater)
                                    <table class="table table-striped">
                                        <tr>
                                            <td>{{ __('Name') }}</td>
                                            <td>:</td>
                                            <td>{{ optional($details->creater)->name ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Joined at') }}</td>
                                            <td>:</td>
                                            <td>{{ optional($details->creater)->created_at ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Current Status') }}</td>
                                            <td>:</td>
                                            <td>
                                                <span class="{{ optional($details->creater)->getStatusBadgeClass() ?? 'secondary' }}">
                                                    {{ optional($details->creater)->getStatus() ?? '--' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                @else
                                    <p>{{ __('N/A') }}</p>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin/js/ordermanagement.js') }}"></script>
@endpush
