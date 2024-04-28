@extends('pharmacy.layouts.master', ['pageSlug' => $statusTitle . '_orders'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ __(ucwords($statusTitle) . ' Order Details') }}</h4>
                        </div>
                        <div class="col-6 text-end">
                            @include('admin.partials.button', [
                                'routeName' => 'pharmacy.order_management.index',
                                'className' => 'btn-primary',
                                'params' => $statusTitle,
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <tbody>
                            <tr>
                                <th>Pharmacy</th>
                                <td>:</td>
                                <th>{{ $do->pharmacy->name }}</th>
                                <td>|</td>
                                <th>Order ID</th>
                                <td>:</td>
                                <th>{{ $do->order->order_id }}</th>
                            </tr>
                            <tr>
                                <th>Payment Type</th>
                                <td>:</td>
                                <th>{{ $do->paymentType() }}</th>
                                <td>|</td>
                                <th>Distribution Type</th>
                                <td>:</td>
                                <th>{{ $do->distributionType() }}</th>
                            </tr>
                            <tr>
                                <th>Total Product</th>
                                <td>:</td>
                                <th>{{ count($do->dops) }}</th>
                                <td>|</td>
                                <th>Preparation Time</th>
                                <td>:</td>
                                <th>{{ $do->prep_time }}</th>
                            </tr>
                            <tr>
                                <th>Note</th>
                                <td>:</td>
                                <th colspan="5">{!! $do->note !!}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <form action="{{'pharmacy.order_management.update'}}" method="POST">
                        <div class="row mb-3">
                            <div class="col-12 px-4 text-end">
                                <span class="{{ $statusBg }}">{{ $statusTitle }}</span>
                            </div>
                        </div>
                        @foreach ($do->dops as $key=>$dop)
                            <div class="col-12">
                                <div class="card card-2">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="sq align-self-center "> <img
                                                    class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                                                    src="{{ storage_url($dop->cart->product->image) }}" width="135"
                                                    height="135" /> </div>
                                            <div class="media-body my-auto text-center">
                                                <div class="row  my-auto flex-column flex-md-row px-3">
                                                    <div class="col text-start">
                                                        <h6 class="mb-0 text-start">{{ $dop->cart->product->name }}</h6>
                                                        <small>{{ $dop->cart->product->pro_cat->name }} </small>
                                                    </div>
                                                    <div class="col-auto my-auto"> </div>
                                                    <div class="col my-auto"> <small>Qty : {{ $dop->cart->quantity }}</small>
                                                    </div>
                                                    <div class="col my-auto"> <small>Pack :
                                                            {{ $dop->cart->unit->name ?? 'Piece' }}</small></div>
                                                    <div class="col my-auto">
                                                        <h6 class="mb-0 text-end">
                                                            <span><strong>{{ __('MRP : ') }}</strong>{!! get_taka_icon() !!}
                                                                {{ number_format($dop->cart->product->price * ($dop->cart->unit->quantity ?? 1) * $dop->cart->quantity, 2) }}</span>
                                                        </h6>
                                                        @if ($do->payment_type == 1)
                                                            <div class="input-group">
                                                                <input type="text" name="data[{{$key}}][ph_price]" class="form-control"
                                                                    placeholder="Enter your product price">
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col my-auto">
                                                        <div class="card mb-0">
                                                            <div class="card-body">
                                                                <input type="hidden" name="data[{{$key}}][dop_id]" value="{{$dop->id}}">
                                                                @if($status == 0)
                                                                    <div class="form-check form-check-radio">
                                                                        <label class="form-check-label me-2" for="status{{$key}}">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="data[{{$key}}][status]" id="status{{$key}}"
                                                                                value="1" checked>
                                                                                Distributed
                                                                            <span class="form-check-sign"></span>
                                                                        </label>
                                                                        <label class="form-check-label" for="status2">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="data[{{$key}}][status]" id="status2"
                                                                                value="2">
                                                                                Dispute
                                                                            <span class="form-check-sign"></span>
                                                                        </label>
                                                                    </div>
                                                                @elseif($status == 1)
                                                                    <div class="form-check form-check-radio">
                                                                        <label class="form-check-label me-2" for="status{{$key}}">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="data[{{$key}}][status]" id="status{{$key}}"
                                                                                value="0">
                                                                                Pending
                                                                            <span class="form-check-sign"></span>
                                                                        </label>
                                                                        <label class="form-check-label" for="status2">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="data[{{$key}}][status]" id="status2"
                                                                                value="2" >
                                                                                Dispute
                                                                            <span class="form-check-sign"></span>
                                                                        </label>
                                                                    </div>
                                                                @else
                                                                    <div class="form-check form-check-radio">
                                                                        <label class="form-check-label me-2" for="status{{$key}}">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="data[{{$key}}][status]" id="status{{$key}}"
                                                                                value="0">
                                                                                Pending
                                                                            <span class="form-check-sign"></span>
                                                                        </label>
                                                                        <label class="form-check-label" for="status2">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="data[{{$key}}][status]" id="status2"
                                                                                value="1" >
                                                                                Distributed
                                                                            <span class="form-check-sign"></span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 text-end">
                            <input type="submit" value="Confirm" class="btn btn-success">
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
