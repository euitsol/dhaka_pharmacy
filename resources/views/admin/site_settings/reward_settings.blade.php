<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Reward Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.rs_update') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @foreach ($reward_settings as $type => $rewards)
                                <strong>{{ $rewards->first()->type_string . ' Reward' }}</strong>
                                @foreach ($rewards as $reward)
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>{{ __('Reward Amount Type') }}</label><br>
                                            <div class="form-check form-check-radio">
                                                @foreach (App\Models\RewardSetting::getRewardTypes() as $reward_type => $reward_type_string)
                                                    <label class="form-check-label me-3">
                                                        <input class="form-check-input" type="radio"
                                                            name="rewards[{{ $reward->id }}][reward_type]"
                                                            value="{{ $reward_type }}"
                                                            {{ $reward->reward_type == $reward_type ? 'checked' : '' }}>
                                                        {{ $reward_type_string }}
                                                        <span class="form-check-sign"></span>
                                                    </label>
                                                @endforeach

                                            </div>
                                            @include('alerts.feedback', [
                                                'field' => 'rewards.' . $reward->id . '.reward_type',
                                            ])
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>{{ __($reward->receiver_type_string . ' Reward Point Amount') }}</label>
                                            <input type="text" name="rewards[{{ $reward->id }}][reward]"
                                                class="form-control" value="{{ $reward->reward }}">
                                            @include('alerts.feedback', [
                                                'field' => 'rewards.' . $reward->id . '.reward',
                                            ])
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>{{ __('Status') }}</label><br>
                                            <div class="form-check form-check-radio">
                                                @foreach (collect(App\Models\RewardSetting::getStatusStrings())->except(App\Models\RewardSetting::STATUS_PREVIOUS) as $status => $status_string)
                                                    <label class="form-check-label me-3">
                                                        <input class="form-check-input" type="radio"
                                                            name="rewards[{{ $reward->id }}][status]"
                                                            value="{{ $status }}"
                                                            {{ $reward->status == $status ? 'checked' : '' }}>
                                                        {{ $status_string }}
                                                        <span class="form-check-sign"></span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @include('alerts.feedback', [
                                                'field' => 'rewards.' . $reward->id . '.status',
                                            ])
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    @include('admin.partials.button', [
                        'routeName' => 'settings.ps_update',
                        'type' => 'submit',
                        'className' => 'btn-primary',
                        'label' => 'Save',
                    ])
                </div>
            </form>
        </div>
    </div>
    @include('admin.partials.documentation', ['document' => $document])
</div>
