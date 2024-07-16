<div class="row px-4 earning">
    <div class="col-md-4">
        <h6 class="card-title fw-bolder">{{ __('Total Balance') }}</h6>
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
        <h6 class="card-title fw-bolder">{{ __('Total Payments') }}</h6>
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
        <h6 class="card-title fw-bolder">{{ __('Total Withdrawn') }}</h6>
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
    <table class="table table-striped datatable">
        <thead>
            <tr>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Activity') }}</th>
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
                    <td>{{ $earning->description }}</td>
                    <td>{{ $earning->order->order_id ?? '--' }}</td>
                    <td>{{ number_format($earning->eq_amount, 2) }}{{ __(' BDT') }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
