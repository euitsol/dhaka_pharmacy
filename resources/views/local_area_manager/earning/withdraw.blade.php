@extends('local_area_manager.layouts.master', ['pageSlug' => 'earning'])
@section('title', 'Withdraw')
@section('content')
    <div class="row earning">
        <div class="col-md-12">
            <div class="card wrap">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title">{{ __('Withdraw') }}</h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('lam.earning.index') }}" class="btn btn-primary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row earning">
                        <div class="col-md-4">
                            <div class="card box">
                                <div class="card-body">
                                    <div class="amount">
                                        <span class="text-muted fw-bold">{{ __('Available amounts for withdrawal') }}</span>
                                        <h4 class="my_amount">{{ number_format(getEarningEqAmounts($earnings), 2) }}
                                            {{ __('BDT') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card box">
                                <div class="card-body">
                                    <div class="amount">
                                        <span class="text-muted fw-bold">{{ __('Withdrawal being cleared') }}</span>
                                        <h4 class="my_amount">{{ number_format(getPendingWithdrawEqAmounts($earnings), 2) }}
                                            {{ __('BDT') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card box">
                                <div class="card-body">
                                    <div class="amount">
                                        <span class="text-muted fw-bold">{{ __('Your withdrawals since joining') }}</span>
                                        <h4 class="my_amount">
                                            {{ number_format(getWithdrawEqAmounts($earnings), 2) }}
                                            {{ __('BDT') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row withdraw_form">
                        <div class="col-md-8 col-lg-6 col-12 mx-auto">
                            <form action="{{ route('lam.earning.withdraw') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('Amount') }}</label>
                                    <input type="text" class="form-control" name="amount"
                                        placeholder="{{ __('Enter amount') }}">
                                    @include('alerts.feedback', ['field' => 'amount'])
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Withdraw Method') }}</label>
                                    <select name="withdraw_method" class="form-control">
                                        <option value=" " selected hidden>{{ __('Select withdraw method') }}</option>
                                        @foreach ($wms as $wm)
                                            <option value="{{ $wm->id }}"
                                                {{ $wm->id == old('withdraw_method') ? 'selected' : '' }}>
                                                {{ $wm->account_name . ' ( ' . $wm->bank_name . ' )' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'withdraw_method'])
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary w-100" value="{{ __('Confirm') }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
