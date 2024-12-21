@extends('local_area_manager.layouts.master', ['pageSlug' => 'wm'])
@section('title', 'Add Withdraw Method')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }} ">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">
                                {{ __('Add Withdraw Method') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('lam.wm.list') }}" class="btn btn-primary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('lam.wm.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Bank Name') }}</label>
                            <input type="text" name="bank_name"
                                class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}"
                                placeholder="Enter bank name" value="{{ old('bank_name') }}">
                            @include('alerts.feedback', ['field' => 'bank_name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Bank Brunch Name') }}</label>
                            <input type="text" name="bank_brunch_name"
                                class="form-control {{ $errors->has('bank_brunch_name') ? ' is-invalid' : '' }}"
                                placeholder="Enter bank brunch name" value="{{ old('bank_brunch_name') }}">
                            @include('alerts.feedback', ['field' => 'bank_brunch_name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Routing Number') }}</label>
                            <input type="text" name="routing_number"
                                class="form-control {{ $errors->has('routing_number') ? ' is-invalid' : '' }}"
                                placeholder="Enter routing number" value="{{ old('routing_number') }}">
                            @include('alerts.feedback', ['field' => 'routing_number'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Account Name') }}</label>
                            <input type="text" name="account_name"
                                class="form-control {{ $errors->has('account_name') ? ' is-invalid' : '' }}"
                                placeholder="Enter account name" value="{{ old('account_name') }}">
                            @include('alerts.feedback', ['field' => 'account_name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Type') }}</label>
                            <select name="type" class="form-control">
                                <option value=" " selected hidden>{{ __('Select Account Type') }}</option>
                                <option value="0" {{ old('type') == '0' ? 'selected' : '' }}>
                                    {{ __('Personal') }}</option>
                                <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>
                                    {{ __('Business') }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'type'])
                        </div>
                        <input class="btn btn-primary float-end" type="submit" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
