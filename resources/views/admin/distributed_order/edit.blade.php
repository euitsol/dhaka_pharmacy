@extends('admin.layouts.master', ['pageSlug' => 'order_'.$status])
@push('css')

<style>
    

        .order_details_wrap p {
            font-size: 14px;
            margin-bottom: 7px;

        }

        .order_details_wrap .small {
            letter-spacing: 0.5px !important;
        }

        .order_details_wrap .card-1 {
            box-shadow: 2px 2px 10px 0px rgb(190, 108, 170);
        }

        .order_details_wrap hr {
            background-color: rgba(248, 248, 248, 0.667);
        }


        .order_details_wrap .bold {
            font-weight: 500;
        }

        .order_details_wrap .change-color {
            color: #AB47BC !important;
        }

        .order_details_wrap .card-2 {
            box-shadow: 1px 1px 3px 0px rgb(112, 115, 139);

        }

        .order_details_wrap .fa-circle.active {
            font-size: 8px;
            color: #AB47BC;
        }

        .order_details_wrap .fa-circle {
            font-size: 8px;
            color: #aaa;
        }

        .order_details_wrap .rounded {
            border-radius: 2.25rem !important;
        }
        .order_details_wrap .invoice {
            position: relative;
            top: -70px;
        }

        .order_details_wrap .Glasses {
            position: relative;
            top: -12px !important;
        }

        .order_details_wrap .card-footer {
            background-color: #0093E9;
            background-image: linear-gradient( 288deg,  rgba(0,85,255,1) 1.5%, rgb(4, 56, 115) 91.6% );
        }
        .order_details_wrap .card-footer h2,
        .order_details_wrap .card-footer h1{
            color: #fff;
            font-size: 30px;
        }

        .order_details_wrap h2 {
            color: rgb(78, 0, 92);
            letter-spacing: 2px !important;
        }

        .order_details_wrap .display-3 {
            font-weight: 500 !important;
        }

        @media (max-width: 479px) {
            .order_details_wrap .invoice {
                position: relative;
                top: 7px;
            }

            .order_details_wrap .border-line {
                border-right: 0px solid rgb(226, 206, 226) !important;
            }

        }

        @media (max-width: 700px) {

            .order_details_wrap h2 {
                color: rgb(78, 0, 92);
                font-size: 17px;
            }

            .order_details_wrap .display-3 {
                font-size: 28px;
                font-weight: 500 !important;
            }
        }

        .order_details_wrap .card-footer small {
            letter-spacing: 7px !important;
            font-size: 12px;
        }

        .order_details_wrap .border-line {
            border-right: 1px solid rgb(226, 206, 226)
        }
        .order_items{
            overflow-y: auto;
        }
</style>
    
@endpush
@section('content')
<div class="order_details_wrap">
    <div class="row px-3">
        <div class="card px-0">
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row mb-3">
                                    <div class="col-12 d-flex justify-content-between align-items-center"> 
                                        <h4 class="color-1 mb-0">{{__('Distributed Order Edit')}}</h4> 
                                        @include('admin.partials.button', [
                                                'routeName' => 'do.do_details',
                                                'className' => 'btn-success',
                                                'params' => [encrypt($do->id),encrypt($do->pharmacy->id)],
                                                'label' => 'Back',
                                            ])
                                    </div>
                                </div>
                            </div>
                            <div class="card-body order_details">
                                
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Order ID</th>
                                                <td>:</td>
                                                <td>{{$do->order->order_id}}</td>
                                                <th>Delivery Address</th>
                                                <td>:</td>
                                                <td>Mirpur-10, Dhaka</td>
                                            </tr>
                                            <tr>
                                                <th>Order Date</th>
                                                <td>:</td>
                                                <td>{{$do->order->created_date()}}</td>
                                                <th>Order Status</th>
                                                <td>:</td>
                                                <td><span class="{{$do->order->statusBg($do->order->status)}}">{{$do->order->statusTitle($do->order->status)}}</span></td>
                                                
                                            </tr>
                                            <tr>
                                                <th>Payable Amount</th>
                                                <td>:</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th><span>&#2547; </span>{{number_format($totalPrice,2)}}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('do.do_update',['order_id'=>encrypt($do->order->id), 'status'=>$status])}}" method="POST" class="px-0">
                        @csrf
                        <div class="col-md-12 ">
                            <div class="card ">
                                <div class="card-header">
                                    <div class="row justify-content-between mb-3">
                                        <div class="col-auto"> <h4 class="color-1 mb-0">Order Distribution</h4> </div>
                                        <div class="col-auto  "> Distribution Status : <span class="{{$do->statusBg($do->status) ?? 'badge badge-danger'}}">{{$do->statusTitle($do->status) ?? 'Not Distributed'}}</span> </div>
                                    </div>
                                </div>
                                <div class="card-body order_items">
                                    
                                        <div class="row">
                                            @foreach ($do->dops as $key=>$dop)
                                            <div class="col-12">
                                                    <input type="hidden" name="datas[{{$key}}][cart_id]" value="{{$dop->cart->id}}">
                                                    <div class="card card-2 mb-3">
                                                        <div class="card-body">
                                                            <div class="row align-items-center">
                                                                <div class="col-9">
                                                                    <div class="media">
                                                                        <div class="sq align-self-center "> <img class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="{{storage_url($dop->cart->product->image)}}" width="135" height="135" /> </div>
                                                                        <div class="media-body my-auto text-center">
                                                                            <div class="row  my-auto flex-column flex-md-row px-3">
                                                                                <div class="col my-auto"> <h6 class="mb-0 text-start">{{$dop->cart->product->name}}</h6>  </div>
                                                                                <div class="col-auto my-auto"> <small>{{$dop->cart->product->pro_cat->name}} </small></div>
                                                                                <div class="col my-auto"> <small>Qty : {{$dop->cart->quantity}}</small></div>
                                                                                <div class="col my-auto"> <small>Pack : {{$dop->cart->unit->name ?? 'Piece'}}</small></div>
                                                                                <div class="col my-auto">
                                                                                    <h6 class="mb-0 text-end">
                                                                                        @if (productDiscountPercentage($dop->cart->product->id))
                                                                                        <span class="text-danger"><del>&#2547; {{number_format((($dop->cart->product->regular_price*$dop->cart->unit->quantity) * $dop->cart->quantity), 2)}}</del></span> 
                                                                                        @endif
                                                                                    </h6>
                                                                                    <h6 class="mb-0 text-end">
                                                                                        <span>&#2547; {{number_format((($dop->cart->product->price*($dop->cart->unit->quantity ?? 1)) * $dop->cart->quantity), 2)}}</span> 
                                                                                    </h6>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <select name="datas[{{$key}}][pharmacy_id]" class="form-control {{ $errors->has('datas.'.$key.'.pharmacy_id') ? ' is-invalid' : '' }}">
                                                                            <option selected hidden>Select Pharmacy</option>
                                                                            @foreach ($pharmacies as $pharmacy)
                                                                                <option @if((isset($do->odps) && $do->odps[$key]->pharmacy_id == $pharmacy->id) || (old('datas.'.$key.'.pharmacy_id') == $pharmacy->id)) selected @endif value="{{$pharmacy->id}}">{{$pharmacy->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        
                                                                        @include('alerts.feedback', ['field' => 'datas.'.$key.'.pharmacy_id'])
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                            
                                                
                                            </div>
                                            @endforeach
                                            <div class="col-12">
                                                <div class="row mt-3">
                                                    <div class="form-group col-md-4">
                                                        <label>Payment Type</label>
                                                        <select name="payment_type" class="form-control {{ $errors->has('payment_type') ? ' is-invalid' : '' }}">
                                                            <option selected hidden>Select Payment Type</option>
                                                            <option value="0" {{((isset($do->payment_type) && $do->payment_type == 0) || old('payment_type') == 0) ? 'selected' : ''}}>Fixed Payment</option>
                                                            <option value="1" {{((isset($do->payment_type) && $do->payment_type == 1) || old('payment_type') == 1) ? 'selected' : ''}}>Open Payment</option>
                                                        </select>
                                                        @include('alerts.feedback', ['field' => 'payment_type'])
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Distribution Type</label>
                                                        <select name="distribution_type" class="form-control {{ $errors->has('distribution_type') ? ' is-invalid' : '' }}">
                                                            <option selected hidden>Select Distribution Type</option>
                                                            <option value="0" {{((isset($do->distribution_type) && $do->distribution_type == 0) || old('distribution_type') == 0) ? 'selected' : ''}}>Normal Distribution</option>
                                                            <option value="1" {{((isset($do->distribution_type) && $do->distribution_type == 1) || old('distribution_type') == 1) ? 'selected' : ''}}>Priority Distribution</option>
                                                        </select>
                                                        @include('alerts.feedback', ['field' => 'distribution_type'])
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label >Prepare Time</label>
                                                        <input type="datetime-local" name="prep_time" value="{{isset($do->prep_time) ? $do->prep_time : old('prep_time')}}" class="form-control {{ $errors->has('prep_time') ? ' is-invalid' : '' }}">
                                                        @include('alerts.feedback', ['field' => 'prep_time'])
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label >Note</label>
                                                        <textarea name="note" class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}" placeholder="Enter order instraction for pharmacy">{{isset($do->note) ? $do->note : old('note')}}</textarea>
                                                        @include('alerts.feedback', ['field' => 'note'])
                                                    </div>
                                                    
                                                    <div class="form-group col-md-12 text-end">
                                                        <input type="submit" value="Update" class="btn btn-primary">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        

    </div>
</div>
@endsection
