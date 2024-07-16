@extends('district_manager.layouts.master', ['pageSlug' => 'earning'])
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
                            <a href="{{ route('dm.earning.index') }}" class="btn btn-primary">{{ __('Back') }}</a>
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
                            <form action="{{ route('dm.earning.withdraw') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('Amount') }}</label>
                                    <input type="text" class="form-control" name="amount" placeholder="Enter amount">
                                    @include('alerts.feedback', ['field' => 'amount'])
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Withdraw Method') }}</label>
                                    <select name="withdraw_method" class="form-control">
                                        <option value=" " selected hidden>{{ __('Select withdraw method') }}</option>
                                        @foreach ($wms as $wm)
                                            <option value="{{ $wm->id }}"
                                                {{ $wm->id == old('withdraw_method') ? 'selected' : '' }}>
                                                {{ $wm->bank_name . ' ( ' . $wm->routing_number . ' )' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'withdraw_method'])
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary w-100" value="Confirm">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row withdraw_history mt-5">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Withdraw Method') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Note') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals as $w)
                                    <tr>
                                        <td>{{ timeFormate($w->created_at) }}</td>
                                        <td><a href="javascript:void(0)" class="btn btn-sm btn-primary view"
                                                data-id="{{ encrypt($w->wm_id) }}">{{ __('Details') }}</a>
                                        </td>
                                        <td><span class="{{ $w->statusBg() }}">{{ $w->statusTitle() }}</span>
                                        </td>
                                        <td>{!! $w->reason ? "<p class='text-danger'>$w->reason</p>" : '--' !!}</td>
                                        <td>{!! get_taka_icon() !!}{{ number_format($w->amount, 2) }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Withdraw Method Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Withdraw Method Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">

                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4], 'order' => 'desc'])
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('dm.wm.details', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 2) {
                            $('#declained_reason').html(
                                `<p> <strong class = "text-danger"> Declined Reason: </strong>${data.note}</p>`
                            )
                        }
                        var result = `
                                <div id='declained_reason mb-2'></div>
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Account Name</th>
                                        <th>:</th>
                                        <td>${data.account_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Bank Name</th>
                                        <th>:</th>
                                        <td>${data.bank_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Bank Brunch Name</th>
                                        <th>:</th>
                                        <td>${data.bank_brunch_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Routing Number</th>
                                        <th>:</th>
                                        <td>${data.routing_number}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Type</th>
                                        <th>:</th>
                                        <td>${data.type}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Note</th>
                                        <th>:</th>
                                        <td><span class="text-danger">${data.note ?? '--'}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.statusBg}">${data.statusTitle}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created At</th>
                                        <th>:</th>
                                        <td>${data.creating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created By</th>
                                        <th>:</th>
                                        <td>${data.created_by}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated At</th>
                                        <th>:</th>
                                        <td>${data.creating_time != data.updating_time ? data.updating_time : ''}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated By</th>
                                        <th>:</th>
                                        <td>${data.updated_by}</td>
                                    </tr>
                                </table>
                                `;
                        $('.modal_data').html(result);
                        $('.view_modal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching admin data:', error);
                    }
                });
            });
        });
    </script>
@endpush
