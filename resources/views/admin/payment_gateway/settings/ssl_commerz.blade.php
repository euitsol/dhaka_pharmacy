@extends('admin.layouts.master', ['pageSlug' => 'ssl_commerz'])
@section('title', 'Payment Gateway Settings')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('SSL Commerz') }}</h5>
                </div>
                <form method="POST" action="{{ route('payment_gateway.update.pg_settings') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group{{ $errors->has('store_id') ? ' has-danger' : '' }}">
                            <label>{{ _('Store ID') }}</label>
                            <input type="text" name="store_id"
                                class="form-control{{ $errors->has('store_id') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Store ID') }}"
                                value="{{ $pg_settings['store_id'] ?? '' }}">
                            @include('alerts.feedback', ['field' => 'store_id'])
                        </div>
                        <div class="form-group{{ $errors->has('store_password') ? ' has-danger' : '' }}">
                            <label>{{ _('Store Password') }}</label>
                            <input type="text" name="store_password"
                                class="form-control{{ $errors->has('store_password') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Store Password') }}"
                                value="{{ $pg_settings['store_password'] ?? '' }}">
                            @include('alerts.feedback', ['field' => 'store_password'])
                        </div>
                        <div class="form-group{{ $errors->has('test_mode') ? ' has-danger' : '' }}">
                            <label>{{ _('Test Mode') }}
                                <small>({{ _('Best to keep in false') }})</small></label>
                            <select name="test_mode"
                                class="form-control no-select {{ $errors->has('test_mode') ? ' is-invalid' : '' }}">
                                <option value="1" @if (isset($pg_settings['test_mode']) && $pg_settings['test_mode'] == '1') selected @endif>
                                    {{ _('True') }}</option>
                                <option value="0" @if (isset($pg_settings['test_mode']) && $pg_settings['test_mode'] == '0') selected @endif>
                                    {{ _('False') }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'test_mode'])
                        </div>
        

                        


                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation',['document'=>$document])
    </div>
@endsection
@push('js')
    <script src="{{ asset('admin/js/site_settings.js') }}"></script>
@endpush