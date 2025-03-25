<div class="row px-4">
    <div class="col-md-4">
        <div class="d-flex justify-content-between">
            <h6 class="card-title fw-bolder">{{ __('Available Balance') }}</h6>
            <a href="javascript:void(0)" class="view_info" data-activity="1" data-title="Available balance history"
                data-type='Earning'><i class="fa-solid fa-circle-info"></i></a>
        </div>
        <div class="card box">
            <div class="card-body">
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Available points for withdrawal') }}</span>
                    <h4 class="my_amount">{{ number_format(getEarningPoints($totalEarnings), 2) }}
                        {{ $point_name }}</h4>
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
        <div class="d-flex justify-content-between">
            <h6 class="card-title fw-bolder">{{ __('Future Payments') }}</h6>
            <a href="javascript:void(0)" class="view_info" data-activity="3" data-title="Future payment history"
                data-type='Pending Clearance'><i class="fa-solid fa-circle-info"></i></a>
        </div>
        <div class="card box">
            <div class="card-body">
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Pending income') }}</span>
                    <h4 class="my_amount">{{ number_format(getPendingEarningEqAmounts($totalEarnings), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Pending clearance') }}</span>
                    <h4 class="my_amount">
                        {{ number_format(getPendingClearanceEarningEqAmounts($totalEarnings), 2) }}
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

                    <div class="d-flex justify-content-between">
                        <span class="text-muted fw-bold">{{ __('Withdrawal amount') }}</span>
                        <a href="javascript:void(0)" class="view_info" data-activity="2"
                            data-title="Total withdraw history" data-type='Withdraw'><i
                                class="fa-solid fa-circle-info"></i></a>
                    </div>
                    <h4 class="my_amount">
                        {{ number_format(getWithdrawEqAmounts($totalEarnings), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted fw-bold">{{ __('Pending withdrawal amount') }}</span>
                        <a href="javascript:void(0)" class="view_info" data-activity="4"
                            data-title="Pending withdraw history" data-type='Withdraw'><i
                                class="fa-solid fa-circle-info"></i></a>
                    </div>
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
                <input type="hidden" name="from_date" id="fromDate" autocomplete="off">
                <input type="hidden" name="to_date" id="toDate" autocomplete="off">
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Activity') }}</th>
                            <th>{{ __('Total Point ( Per Point Rate )') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody class="earning_wrap">
                        @foreach ($paginateEarnings as $earning)
                            <tr>
                                <td>{{ timeFormate($earning->created_at) }}</td>
                                <td><span
                                        class="{{ $earning->activityBg() }}">{{ slugToTitle($earning->activityTitle()) }}</span>
                                </td>
                                <td>{{ number_format($earning->point, 2) }}
                                    ({!! get_taka_icon() !!}{{ number_format($earning->point_history->eq_amount, 2) }})
                                </td>
                                <td>{!! $earning->description ?? '--' !!}@if ($earning->activity == 3)
                                        {{ ' - ' . $earning->withdraw_earning->withdraw->withdraw_method->account_name . ' ( ' . $earning->withdraw_earning->withdraw->withdraw_method->bank_name . ' )' }}
                                    @endif
                                </td>
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
{{-- Information Modal  --}}
<div class="modal info_modal fade" id="exampleModal55" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Information') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal_data">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Activity') }}</th>
                            <th>{{ __('Per Point Rate') }}</th>
                            <th>{{ __('Total Point') }}</th>
                            <th>{{ __('Total Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody class="info_wrap">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('.view_info').on('click', function() {
            let activity = $(this).data('activity');
            let type = $(this).data('type');
            let title = $(this).data('title');
            let total_amount = 0;
            let total_point = 0;


            let result = `
            @foreach ($totalEarnings->groupBy('ph_id') as $earnings)`;
            if (activity == 1) {
                total_amount =
                    `{!! get_taka_icon() !!}{{ number_format(getEarningEqAmounts($earnings), 2) }}`;
                total_point = `{{ number_format(getEarningPoints($earnings), 2) }}`;
            } else if (activity == 2) {
                total_amount =
                    `{!! get_taka_icon() !!}{{ number_format(getWithdrawEqAmounts($earnings), 2) }}`;
                total_point = `{{ number_format(getWithdrawPoints($earnings), 2) }}`;
            } else if (activity == 3) {
                total_amount =
                    `{!! get_taka_icon() !!}{{ number_format(getPendingClearanceEarningEqAmounts($earnings), 2) }}`;
                total_point = `{{ number_format(getPendingClearanceEarningPoints($earnings), 2) }}`;
            } else if (activity == 4) {
                total_amount =
                    `{!! get_taka_icon() !!}{{ number_format(getPendingWithdrawEqAmounts($earnings), 2) }}`;
                total_point = `{{ number_format(getPendingWithdrawPoints($earnings), 2) }}`;
            }
            if (total_point != 0) {
                result += `
                <tr>
                    <td>${type}</td>
                    <td>{!! get_taka_icon() !!}{{ number_format($earnings->pluck('point_history')->first()->eq_amount, 2) }}
                    </td>
                    <td>${total_point}</td>
                    <td>${total_amount}</td>
                </tr>`;
            }
            result += `
                @endforeach
            `;
            $('.modal-title').html(title)
            $('.info_wrap').html(result);
            $('.info_modal').modal('show');
        });
    </script>
@endpush
