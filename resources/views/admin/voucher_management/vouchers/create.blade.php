@extends('admin.layouts.master', ['pageSlug' => 'vouchers'])
@section('title', 'Create Voucher')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Voucher') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'vm.vouchers.voucher_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('vm.vouchers.voucher_create') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Voucher Code') }}</label>
                                <input type="text" name="code" class="form-control"
                                    placeholder="{{ __('Voucher code') }}" value="{{ old('code') }}">
                                @include('alerts.feedback', ['field' => 'code'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Minimum Order Amount') }}</label>
                                <input type="text" name="min_order_amount" class="form-control"
                                    placeholder="{{ __('Minimum order amount') }}" value="{{ old('min_order_amount') }}">
                                @include('alerts.feedback', ['field' => 'min_order_amount'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Discount') }}</label>
                                <input type="text" name="discount_amount" class="form-control"
                                    placeholder="{{ __('Voucher discount') }}" value="{{ old('discount_amount') }}">
                                @include('alerts.feedback', ['field' => 'discount_amount'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Type ') }}(<small
                                        class="text-muted">{{ __("Want a flexible discount? 'Percentage' is the best choice!") }}</small>)</label>
                                @php
                                    $voucher = new \App\Models\Voucher();
                                @endphp
                                <div class="form-check form-check-radio">
                                    @foreach ($voucher->types as $key => $label)
                                        <label class="form-check-label me-3">
                                            <input class="form-check-input" type="radio" name="type"
                                                value="{{ $key }}">
                                            {{ __($label) }}
                                            <span class="form-check-sign"></span>
                                        </label>
                                    @endforeach
                                </div>
                                @include('alerts.feedback', ['field' => 'type'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Start At') }}</label>
                                <input type="datetime-local" name="starts_at" class="form-control"
                                    value="{{ old('starts_at') }}">
                                @include('alerts.feedback', ['field' => 'starts_at'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Expires At') }}</label>
                                <input type="datetime-local" name="expires_at" class="form-control"
                                    value="{{ old('expires_at') }}">
                                @include('alerts.feedback', ['field' => 'expires_at'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Usage Limit') }}</label>
                                <input type="text" name="usage_limit" class="form-control"
                                    placeholder="{{ __('Voucher usage limit') }}" value="{{ old('usage_limit') }}">
                                @include('alerts.feedback', ['field' => 'usage_limit'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('User Usage Limit') }}</label>
                                <input type="text" name="user_usage_limit" class="form-control"
                                    placeholder="{{ __('Per user usage limit') }}" value="{{ old('user_usage_limit') }}">
                                @include('alerts.feedback', ['field' => 'user_usage_limit'])
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
