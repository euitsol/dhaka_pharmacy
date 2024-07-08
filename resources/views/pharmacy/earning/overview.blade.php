@push('css_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('css')
    <style>
        .amount .my_amount {
            font-size: 30px;
            font-weight: 900;
            margin: 15px 0;
            font-family: auto;
        }
    </style>
@endpush

@push('js_link')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endpush

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var startDate = moment().startOf('month');
            var endDate = moment().endOf('month');

            $('#daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                startDate: startDate,
                endDate: endDate,
                autoUpdateInput: false
            }, function(start, end, label) {
                $('#daterange').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });

            $('#daterange').attr('placeholder', 'Select Date Range');
        });
    </script>
@endpush
<div class="row px-4">
    <div class="col-md-4">
        <h6 class="card-title fw-bolder">{{ __('Total Balance') }}</h6>
        <div class="card ">
            <div class="card-body">
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Available points for withdrawal') }}</span>
                    <h4 class="my_amount">{{ number_format($totalEarnings->where('activity', 1)->sum('point'), 2) }}
                        {{ getPointName() }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Equivalent amount') }}</span>
                    <h4 class="my_amount">{{ number_format($totalEarnings->where('activity', 1)->sum('amount'), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h6 class="card-title fw-bolder">{{ __('Total Payments') }}</h6>
        <div class="card ">
            <div class="card-body">
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Payments being cleared') }}</span>
                    <h4 class="my_amount">{{ number_format($totalEarnings->where('activity', 3)->sum('point'), 2) }}
                        {{ getPointName() }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Equivalent amount') }}</span>
                    <h4 class="my_amount">{{ number_format($totalEarnings->where('activity', 3)->sum('amount'), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h6 class="card-title fw-bolder">{{ __('Total Withdrawn') }}</h6>
        <div class="card ">
            <div class="card-body">
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Withdrawal amount') }}</span>
                    <h4 class="my_amount">{{ number_format($totalEarnings->where('activity', 2)->sum('amount'), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
                <hr>
                <div class="amount">
                    <span class="text-muted fw-bold">{{ __('Pending withdrawal amount') }}</span>
                    <h4 class="my_amount">{{ number_format($totalEarnings->where('activity', -1)->sum('amount'), 2) }}
                        {{ __('BDT') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2 mb-3">
                <input type="text" name="daterange" id="daterange" class="form-control" />
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">

                <table class="table table-striped">
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
                        @foreach ($paginateEarnings as $earning)
                            <tr>
                                <td>{{ timeFormate($earning->created_at) }}</td>
                                <td><span class="{{ $earning->activityBg() }}">{{ $earning->activityTitle() }}</span>
                                </td>
                                <td>{{ $earning->description }}</td>
                                <td>{{ $earning->order->order_id }}</td>
                                <td>{{ number_format($earning->amount, 2) }}{{ __(' BDT') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $pagination !!}
    </div>
</div>
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4]])
