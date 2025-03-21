@extends('admin.layouts.master', ['pageSlug' => 'ssl_commerz'])
@section('title', 'SSL Payment Gateway Settings')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('SSL Commerz') }}</h5>
                </div>
                <form method="POST" action="{{ route('payment_gateway.update.pg_settings') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group{{ $errors->has('store_id') ? ' has-danger' : '' }}">
                            <label>{{ __('Store ID') }}</label>
                            <input type="text" name="store_id"
                                class="form-control{{ $errors->has('store_id') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Store ID') }}" value="{{ $pg_settings['store_id'] ?? '' }}">
                            @include('alerts.feedback', ['field' => 'store_id'])
                        </div>
                        <div class="form-group{{ $errors->has('store_password') ? ' has-danger' : '' }}">
                            <label>{{ __('Store Password') }}</label>
                            <input type="text" name="store_password"
                                class="form-control{{ $errors->has('store_password') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Store Password') }}"
                                value="{{ $pg_settings['store_password'] ?? '' }}">
                            @include('alerts.feedback', ['field' => 'store_password'])
                        </div>
                        <div class="form-group{{ $errors->has('mode') ? ' has-danger' : '' }}">
                            <label>{{ __('Mode') }}
                                <small>({{ __('Best to keep in false') }})</small></label>
                            <select name="mode"
                                class="form-control no-select {{ $errors->has('mode') ? ' is-invalid' : '' }}">
                                <option value="1" @if (isset($pg_settings['mode']) && $pg_settings['mode'] == '1') selected @endif>
                                    {{ __('True') }}</option>
                                <option value="0" @if (isset($pg_settings['mode']) && $pg_settings['mode'] == '0') selected @endif>
                                    {{ __('False') }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'mode'])
                        </div>





                    </div>
                    {{-- @if (admin()->hasPermissionTo('pg_settings')) --}}
                    <div class="card-footer text-end">
                        @include('admin.partials.button', [
                            'routeName' => 'payment_gateway.update.pg_settings',
                            'type' => 'submit',
                            'className' => 'btn-primary',
                            'label' => 'Save',
                        ])
                        {{-- <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button> --}}
                    </div>
                    {{-- @endif --}}
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
@push('js')
    <script src="{{ asset('admin/js/site_settings.js') }}"></script>
@endpush
