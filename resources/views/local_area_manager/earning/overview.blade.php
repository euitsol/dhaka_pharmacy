<div class="row px-4">
    <div class="col-md-4">
        <h6 class="card-title fw-bolder">{{ __('Total Balance') }}</h6>
        <div class="card box">
            <div class="card-body">
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Available points for withdrawal') }}</span>
                    <h4 class="my_amount">{{ number_format(getEarningPoints($totalEarnings), 2) }}
                        {{ getPointName() }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Equivalent amount') }}</span>
                    <h4 class="my_amount">{{ number_format(getEarningEqAmounts($totalEarnings), 2) }}
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
                    <h4 class="my_amount">{{ number_format(getPendingEarningPoints($totalEarnings), 2) }}
                        {{ getPointName() }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Equivalent amount') }}</span>
                    <h4 class="my_amount">
                        {{ number_format(getPendingEarningEqAmounts($totalEarnings), 2) }}
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
                    <h4 class="my_amount">
                        {{ number_format(getWithdrawEqAmounts($totalEarnings), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Pending withdrawal amount') }}</span>
                    <h4 class="my_amount">
                        {{ number_format(getPendingWithdrawEqAmounts($totalEarnings), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row px-4">
    <div class="col-md-12">
        <div class="row mb-3 align-items-center justify-content-between">
            <div class="col-md-2">
                <input type="text" name="daterange" id="daterange" class="form-control" />
            </div>
            <div class="col-md-2">
                <a href="javascript:void(0)" class="text-muted email_activity float-end text-decoration-none">
                    <i class="fa-solid fa-file-csv" style="color: rgb(3, 204, 3)"></i>
                    {{ __('Email activity report') }}
                </a>
                <input type="hidden" name="from_date" id="fromDate">
                <input type="hidden" name="to_date" id="toDate">
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Activity') }}</th>
                            <th>{{ __('Per Point Rate') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Order') }}</th>
                            <th>{{ __('Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody class="earning_wrap">
                        @foreach ($paginateEarnings as $earning)
                            <tr>
                                <td>{{ timeFormate($earning->created_at) }}</td>
                                <td><span class="{{ $earning->activityBg() }}">{{ $earning->activityTitle() }}</span>
                                </td>
                                <td>{!! get_taka_icon() !!}{{ number_format($earning->point_history->eq_amount, 2) }}
                                </td>
                                <td>{{ $earning->description ?? '--' }}@if ($earning->activity == 2)
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
        </div>
        <div class="paginate">
            {!! $pagination !!}
        </div>
    </div>
</div>
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4]])
