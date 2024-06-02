@extends('admin.layouts.master', ['pageSlug' => 'order_details'])
@push('css')
    <link rel="stylesheet" href="{{asset('admin/css/ordermanagement.css')}}">
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
                                        <h4 class="color-1 mb-0">{{__('Order Details')}}</h4> 
                                        @include('admin.partials.button', [
                                                    'routeName' => 'om.order.order_list',
                                                    'className' => 'btn-primary',
                                                    'params'=>'pending',
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
                                                <th>{{__('Order ID')}}</th>
                                                <td>:</td>
                                                <td>{{$order->order_id}}</td>
                                                <th>{{__('Delivery Type')}}</th>
                                                <td>:</td>
                                                <td>{{ucwords($order->delivery_type)}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Order Date')}}</th>
                                                <td>:</td>
                                                <td>{{timeFormate($order->created_at)}}</td>
                                                <th>{{__('Order Status')}}</th>
                                                <td>:</td>
                                                <td><span class="{{$order->statusBg()}}">{{$order->statusTitle()}}</span></td>
                                                
                                            </tr>
                                            <tr>
                                                <th>{{__('Delivery Fee')}}</th>
                                                <td>:</td>
                                                <th><span>{!! get_taka_icon() !!} </span>{{number_format(ceil($order->delivery_fee))}}</th>
                                                <th>{{__('Payable Amount')}}</th>
                                                <td>:</td>
                                                <th><span>{!! get_taka_icon() !!} </span>{{number_format(ceil($totalPrice+$order->delivery_fee))}}</th>
                                            </tr>
                                            <tr>
                                                <th>{{__('Delivery Address')}}</th>
                                                <td>:</td>
                                                <td colspan="4">{!! optional($order->address)->address !!}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('om.order.order_distribution',encrypt($order->id))}}" method="POST" class="px-0">
                        @csrf
                        <div class="col-md-12 ">
                            <div class="card ">
                                <div class="card-header">
                                    <div class="row justify-content-between mb-3">
                                        <div class="col-auto"> <h4 class="color-1 mb-0">{{__('Order Distribution')}}</h4> </div>
                                        <div class="col-auto  ">{{__(' Distribution Status :')}} <span class="{{isset($order_distribution) ? $order_distribution->statusBg() : 'badge badge-danger'}}">{{isset($order_distribution) ? "Distributed" : 'Not Distributed'}}</span> </div>
                                    </div>
                                </div>
                                <div class="card-body order_items">
                                    
                                        <div class="row">
                                            @foreach ($order_items as $key=>$item)
                                            <div class="col-12">
                                                    <input type="hidden" name="datas[{{$key}}][cart_id]" value="{{$item->id}}">
                                                    <div class="card card-2 mb-3">
                                                        <div class="card-body">
                                                            <div class="row align-items-center">
                                                                <div class="col-9">
                                                                    <div class="media">
                                                                        <div class="sq align-self-center "> <img class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="{{storage_url($item->product->image)}}" width="135" height="135" /> </div>
                                                                        <div class="media-body my-auto text-center">
                                                                            <div class="row  my-auto flex-column flex-md-row px-3">
                                                                                <div class="col my-auto"> <h6 class="mb-0 text-start">{{$item->product->name}}</h6>  </div>
                                                                                <div class="col-auto my-auto"> <small>{{$item->product->pro_cat->name}} </small></div>
                                                                                <div class="col my-auto"> <small>{{__('Qty :')}} {{$item->quantity}}</small></div>
                                                                                <div class="col my-auto"> <small>{{__('Pack :')}} {{$item->unit->name ?? 'Piece'}}</small></div>
                                                                                <div class="col my-auto">
                                                                                    <h6 class="mb-0 text-end">
                                                                                        @if (productDiscountPercentage($item->product->id))
                                                                                        <span class="text-danger">
                                                                                            <del>
                                                                                                {!! get_taka_icon() !!} {{number_format((($item->product->price*($item->unit->quantity ?? 1)) * $item->quantity), 2)}}
                                                                                            </del>
                                                                                        </span> 
                                                                                        @endif
                                                                                    </h6>
                                                                                    <h6 class="mb-0 text-end">
                                                                                        <span>
                                                                                            {!! get_taka_icon() !!} {{number_format((($item->product->discountPrice()*$item->unit->quantity) * $item->quantity), 2)}}
                                                                                        </span> 
                                                                                    </h6>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        @if(isset($order_distribution) && $order_distribution->status == 0)

                                                                            @php
                                                                                $area = $order_distribution->odps[$key]->pharmacy->operation_area ? ($order_distribution->odps[$key]->pharmacy->operation_sub_area ? "( ".$order_distribution->odps[$key]->pharmacy->operation_area->name." - " : "( ".$order_distribution->odps[$key]->pharmacy->operation_area->name." )")  : '';
                                                                                $sub_area = $order_distribution->odps[$key]->pharmacy->operation_sub_area ? ($order_distribution->odps[$key]->pharmacy->operation_area ? $order_distribution->odps[$key]->pharmacy->operation_sub_area->name." )" : "( ".$order_distribution->odps[$key]->pharmacy->operation_sub_area->name." )" )  : '';
                                                                            @endphp

                                                                            <input type="text" value="{{$order_distribution->odps[$key]->pharmacy->name}}" disabled class="form-control">
                                                                        @else
                                                                        
                                                                            <select name="datas[{{$key}}][pharmacy_id]" class="form-control {{ $errors->has('datas.'.$key.'.pharmacy_id') ? ' is-invalid' : '' }}">
                                                                                <option selected hidden>{{__('Select Pharmacy')}}</option>
                                                                                @foreach ($pharmacies as $pharmacy)
                                                                                @php
                                                                                    $area = $pharmacy->operation_area ? ($pharmacy->operation_sub_area ? "( ".$pharmacy->operation_area->name." - " : "( ".$pharmacy->operation_area->name." )")  : '';
                                                                                    $sub_area = $pharmacy->operation_sub_area ? ($pharmacy->operation_area ? $pharmacy->operation_sub_area->name." )" : "( ".$pharmacy->operation_sub_area->name." )" )  : '';
                                                                                @endphp
                                                                                    <option @if((old('datas.'.$key.'.pharmacy_id') == $pharmacy->id)) selected @endif value="{{$pharmacy->id}}">{{$pharmacy->name.$area.$sub_area}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        @endif
                                                                        
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
                                                        <label>{{__('Payment Type')}}</label>
                                                        @if(isset($order_distribution) && $order_distribution->status == 0)
                                                            <input type="text" value="{{($order_distribution->payment_type == 0) ? 'Fixed Payment' : (($order_distribution->payment_type == 1) ? 'Open Payment' : '') }}" class="form-control" disabled>
                                                        @else
                                                            <select name="payment_type" class="form-control {{ $errors->has('payment_type') ? ' is-invalid' : '' }}">
                                                                <option selected hidden>{{__('Select Payment Type')}}</option>
                                                                <option value="0" {{(old('payment_type') == 0) ? 'selected' : ''}}>{{__('Fixed Payment')}}</option>
                                                                <option value="1" {{(old('payment_type') == 1) ? 'selected' : ''}}>{{__('Open Payment')}}</option>
                                                            </select>
                                                        @endif
                                                        @include('alerts.feedback', ['field' => 'payment_type'])
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>{{__('Distribution Type')}}</label>
                                                        @if(isset($order_distribution) && $order_distribution->status == 0)
                                                            <input type="text" value="{{($order_distribution->distribution_type == 0) ? 'Normal Distribution' : (($order_distribution->distribution_type == 1) ? 'Priority Distribution' : '') }}" class="form-control" disabled>
                                                        @else
                                                            <select name="distribution_type" class="form-control {{ $errors->has('distribution_type') ? ' is-invalid' : '' }}">
                                                                <option selected hidden>{{__('Select Distribution Type')}}</option>
                                                                <option value="0" {{(old('distribution_type') == 0) ? 'selected' : ''}}>{{__('Normal Distribution')}}</option>
                                                                <option value="1" {{(old('distribution_type') == 1) ? 'selected' : ''}}>{{__('Priority Distribution')}}</option>
                                                            </select>
                                                        @endif
                                                        @include('alerts.feedback', ['field' => 'distribution_type'])
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label >{{__('Prepare Time')}}</label>
                                                        <input type="datetime-local" @if(isset($order_distribution) && $order_distribution->status == 0) disabled @endif name="prep_time" value="{{isset($order_distribution->prep_time) ? $order_distribution->prep_time : old('prep_time')}}"  class="form-control {{ $errors->has('prep_time') ? ' is-invalid' : '' }}">
                                                        @include('alerts.feedback', ['field' => 'prep_time'])
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label >{{__('Note')}}</label>
                                                        <textarea name="note" @if(isset($order_distribution) && $order_distribution->status == 0) disabled @endif class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}" placeholder="Enter order instraction for pharmacy">{{isset($order_distribution->note) ? $order_distribution->note : old('note')}}</textarea>
                                                        @include('alerts.feedback', ['field' => 'note'])
                                                    </div>
                                                    @if(!isset($order_distribution))
                                                        <div class="form-group col-md-12 text-end">
                                                            <input type="submit" value="Distribute" class="btn btn-primary">
                                                        </div>
                                                    @endif
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
