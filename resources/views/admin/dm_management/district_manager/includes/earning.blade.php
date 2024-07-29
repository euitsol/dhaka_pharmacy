<div class="row px-4 earning">
    <div class="col-md-4">
        <h6 class="card-title fw-bolder">{{ __('Available Balance') }}</h6>
        <div class="card box">
            <div class="card-body">
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Available points for withdrawal') }}</span>
                    <h4 class="my_amount">{{ number_format(getEarningPoints($earnings), 2) }}
                        {{ getPointName() }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Equivalent amount') }}</span>
                    <h4 class="my_amount">{{ number_format(getEarningEqAmounts($earnings), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h6 class="card-title fw-bolder">{{ __('Future Payments') }}</h6>
        <div class="card box">
            <div class="card-body">
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Payments being cleared') }}</span>
                    <h4 class="my_amount">{{ number_format(getPendingEarningPoints($earnings), 2) }}
                        {{ getPointName() }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Equivalent amount') }}</span>
                    <h4 class="my_amount">{{ number_format(getPendingEarningEqAmounts($earnings), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h6 class="card-title fw-bolder">{{ __('Total Withdraw') }}</h6>
        <div class="card box">
            <div class="card-body">
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Withdrawal amount') }}</span>
                    <h4 class="my_amount">{{ number_format(getWithdrawEqAmounts($earnings), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Pending withdrawal amount') }}</span>
                    <h4 class="my_amount">{{ number_format(getPendingWithdrawEqAmounts($earnings), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <table class="table table-striped earning_datatable">
        <thead>
            <tr>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Activity') }}</th>
                <th>{{ __('Total Point') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Order') }}</th>
                <th>{{ __('Amount') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($earnings as $earning)
                <tr>
                    <td>{{ timeFormate($earning->created_at) }}</td>
                    <td><span class="{{ $earning->activityBg() }}">{{ $earning->activityTitle() }}</span>
                    </td>
                    <td>{{ number_format($earning->point, 2) }}({!! get_taka_icon() !!}{{ number_format($earning->point_history->eq_amount, 2) }})
                    </td>
                    <td>{{ $earning->description }}@if ($earning->activity == 2)
                            {{ ' - ' . $earning->withdraw_earning->withdraw->withdraw_method->account_name . ' ( ' . $earning->withdraw_earning->withdraw->withdraw_method->bank_name . ' )' }}
                        @endif
                    </td>
                    <td>{{ $earning->order->order_id ?? '--' }}</td>
                    <td>{!! get_taka_icon() !!}{{ number_format($earning->eq_amount, 2) }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
@include('admin.partials.datatable', [
    'columns_to_show' => [0, 1, 2, 3, 4],
    'mainClass' => 'earning_datatable',
    'order' => 'desc',
])
