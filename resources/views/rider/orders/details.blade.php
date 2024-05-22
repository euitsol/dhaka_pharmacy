@extends('rider.layouts.master', ['pageSlug' => $dor->statusTitle() . '_orders'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ __(ucwords($dor->statusTitle()) . ' Order Details') }}</h4>
                        </div>
                        <div class="col-6 text-end">
                            @include('admin.partials.button', [
                                'routeName' => 'rider.order_management.index',
                                'className' => 'btn-primary',
                                'params' => $dor->statusTitle(),
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <tbody>
                            <tr>
                                <th>Customer Name</th>
                                <td>:</td>
                                <th>{{ $dor->od->order->address->name }}</th>
                                <td>|</td>
                                <th>Customer Contact</th>
                                <td>:</td>
                                <th>{{ $dor->od->order->address->phone }}</th>
                            </tr>
                            <tr>
                                <th>Delivery Address</th>
                                <td>:</td>
                                <th>{!! $dor->od->order->address->street_address !!}</th>
                                <td>|</td>
                                <th>Order ID</th>
                                <td>:</td>
                                <th>{{ $dor->od->order->order_id }}</th>
                               
                            </tr>
                            <tr>
                                <th>Priority</th>
                                <td>:</td>
                                <th>{{ $dor->priority() }}</th>
                                <td>|</td>
                                <th>Total Price</th>
                                <td>:</td>
                                <th>{{ $dor->totalPrice }}{!! get_taka_icon() !!}</th>
                            </tr>
                            <tr>
                                <th>Delivery Instraction</th>
                                <td>:</td>
                                <th colspan="5">{{ $dor->instraction }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Pharmacies Details') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row justify-center">
                        @foreach ($dor->pharmacy as $pharmacy)
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ $pharmacy->name }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped datatable">
                                            <tbody>
                                                <tr>
                                                    <th>Pharmacy Name</th>
                                                    <td>:</td>
                                                    <th>{{ $pharmacy->name }}</th>
                                                    <td>|</td>
                                                    <th>Pharmacy Contact</th>
                                                    <td>:</td>
                                                    <th>{{ $pharmacy->phone }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Operational Area</th>
                                                    <td>:</td>
                                                    <th>{{optional($pharmacy->operation_area)->name}}</th>
                                                    <td>|</td>
                                                    <th>Operational Sub Area</th>
                                                    <td>:</td>
                                                    <th>{{ optional($pharmacy->operation_sub_area)->name }}</th>
                                                   
                                                </tr>
                                                <tr>
                                                    <th>Pharmacy Address</th>
                                                    <td>:</td>
                                                    <th colspan="5">{{ $pharmacy->present_address }}</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    @if($dor->status == 3)
                        <div class="buttons text-end">
                            <a href="javascript:void(0)" class="btn btn-danger dispute" data-class="dispute_form">{{__('Dispute')}}</a>
                            <a href="javascript:void(0)" class="btn btn-primary collect" data-class="pharmacy_collect_otp_form">{{__('Collect')}}</a>
                        </div>
                        <form style="display:none;" class="mt-3 form dispute_form" action="" method="POST">
                            <div class="form-group dispute_note">
                                <textarea name="dispute_note" class="form-control" placeholder="Enter dispute reason"></textarea>
                            </div>
                            @include('alerts.feedback', ['field' => 'dispute_note'])
                            <div class="form-group text-end">
                                <input type="submit" class="btn btn-secondary" value="Update">
                            </div>
                            
                        </form>
                        <form style="display:none;" class="mt-3 form pharmacy_collect_otp_form" action="" method="POST">
                            <div class="form-group pharmacy_collect_otp">
                                <input type="text" name="pharmacy_collect_otp" class="form-control" placeholder="Enter pharmacy otp">
                            </div>
                            @include('alerts.feedback', ['field' => 'pharmacy_collect_otp'])
                            <div class="form-group text-end">
                                <input type="submit" class="btn btn-secondary" value="Update">
                            </div>
                        </form>
                    @endif
                    @if($dor->status == 4)
                        <a href="javascript:void(0)" class="btn btn-danger cancel" data-class="cancel_form">{{__('Cancel')}}</a>
                        <a href="javascript:void(0)" class="btn btn-primary delivered" data-class="user_otp_form" >{{__('Delivered')}}</a>

                        <form style="display:none;" class="mt-3 form cancel_form" action="" method="POST">
                            <div class="form-group cancel_note">
                                <textarea name="cancel_note" class="form-control" placeholder="Enter cancel reason"></textarea>
                            </div>
                            @include('alerts.feedback', ['field' => 'cancel_note'])
                            <div class="form-group text-end">
                                <input type="submit" class="btn btn-secondary" value="Update">
                            </div>
                        </form>
                        <form style="display:none;" class="mt-3 form user_otp_form" action="" method="POST">
                            <div class="form-group user_otp">
                                <input type="text" name="user_otp" class="form-control" placeholder="Enter user otp">
                            </div>
                            @include('alerts.feedback', ['field' => 'user_otp'])
                            <div class="form-group text-end">
                                <input type="submit" class="btn btn-secondary" value="Update">
                            </div>
                        </form>
                    @endif
                    @if($dor->status == 5)
                        <a href="javascript:void(0)" class="btn btn-primary complete" data-class="transaction_form">{{__('Complete')}}</a>
                        <form style="display:none;" class="mt-3 form transaction_form" action="" method="POST">
                            <div class="form-group transaction">
                                <input type="text" name="transaction" class="form-control" placeholder="Enter transaction id">
                            </div>
                            @include('alerts.feedback', ['field' => 'transaction'])
                            <div class="form-group text-end">
                                <input type="submit" class="btn btn-secondary" value="Update">
                            </div>
                        </form>
                    @endif
                    @if($dor->status == 7)
                        <a href="javascript:void(0)" class="btn btn-primary cancel_complete" data-class="pharmacy_return_otp_form">{{__('Cancel Complete')}}</a>
                        <form style="display:none;" class="mt-3 form pharmacy_return_otp_form" action="" method="POST">
                            <div class="form-group pharmacy_return_otp">
                                <input type="text" name="pharmacy_return_otp" class="form-control" placeholder="Enter pharmacy return otp">
                            </div>
                            @include('alerts.feedback', ['field' => 'pharmacy_return_otp'])
                            <div class="form-group text-end">
                                <input type="submit" class="btn btn-secondary" value="Update">
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        function showForm(element) {
            $('.form').each(function() {
                $(this).hide();
            });
            var form_class = element.data('class');
            $('.' + form_class).show();
        }

        $(document).on('click', '.dispute, .collect, .cancel, .delivered, .complete, .cancel_complete', function() {
            showForm($(this));
        });
    });
</script>
    
@endpush

