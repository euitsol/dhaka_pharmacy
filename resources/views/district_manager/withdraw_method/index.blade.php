@extends('district_manager.layouts.master', ['pageSlug' => 'wm'])
@section('title', 'Withdraw Method')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }} ">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">
                                {{ __('Withdraw Method') }}</h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <span
                                class="{{ $wm ? $wm->statusBg() : 'badge bg-secondary' }}">{{ $wm ? $wm->statusTitle() : 'Not submitted yet' }}</span>
                        </div>
                        @if ($wm && $wm->status == 2)
                            <div class="col-12">
                                <p><strong class="text-danger">{{ __('Declined Reason: ') }}</strong></p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('dm.wm.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Bank Name') }}</label>
                            <input type="text" name="bank_name"
                                class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}"
                                placeholder="Enter bank name" value="{{ $wm ? $wm->bank_name : old('bank_name') }}"
                                {{ $wm->status == 0 || $wm->status == 1 ? 'disabled' : '' }}>
                            @include('alerts.feedback', ['field' => 'bank_name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Bank Brunch Name') }}</label>
                            <input type="text" name="bank_brunch_name"
                                class="form-control {{ $errors->has('bank_brunch_name') ? ' is-invalid' : '' }}"
                                placeholder="Enter bank brunch name"
                                value="{{ $wm ? $wm->bank_brunch_name : old('bank_brunch_name') }}"
                                {{ $wm->status == 0 || $wm->status == 1 ? 'disabled' : '' }}>
                            @include('alerts.feedback', ['field' => 'bank_brunch_name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Routing Number') }}</label>
                            <input type="text" name="routing_number"
                                class="form-control {{ $errors->has('routing_number') ? ' is-invalid' : '' }}"
                                placeholder="Enter routing number"
                                value="{{ $wm ? $wm->routing_number : old('routing_number') }}"
                                {{ $wm->status == 0 || $wm->status == 1 ? 'disabled' : '' }}>
                            @include('alerts.feedback', ['field' => 'routing_number'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Account Name') }}</label>
                            <input type="text" name="account_name"
                                class="form-control {{ $errors->has('account_name') ? ' is-invalid' : '' }}"
                                placeholder="Enter account name"
                                value="{{ $wm ? $wm->account_name : old('account_name') }}"
                                {{ $wm->status == 0 || $wm->status == 1 ? 'disabled' : '' }}>
                            @include('alerts.feedback', ['field' => 'account_name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Type') }}</label>
                            <input type="text" name="type"
                                class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}"
                                placeholder="Enter type" value="{{ $wm ? $wm->type : old('type') }}"
                                {{ $wm->status == 0 || $wm->status == 1 ? 'disabled' : '' }}>
                            @include('alerts.feedback', ['field' => 'type'])
                        </div>
                        <input
                            class="btn btn-primary float-end {{ $wm->status == 0 || $wm->status == 1 ? 'disabled' : '' }}"
                            type="submit" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
