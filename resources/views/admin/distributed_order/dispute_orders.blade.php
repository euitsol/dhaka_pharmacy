@extends('admin.layouts.master', ['pageSlug' => 'dispute_orders'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ __('Dispute Orders') }}</h4>
                        </div>
                    </div>
                </div>
                @forelse ($dos as $do)
                    <div class="card-body">
                        <table class="table table-striped datatable">
                            <tbody>
                                <tr>
                                    <th>Order ID</th>
                                    <td>:</td>
                                    <th>{{$do->order->order_id}}</th>
                                    <td>|</td>
                                    <th>Total Price</th>
                                    <td>:</td>
                                    <th>{!! get_taka_icon(). $do->total_price !!}</th>
                                </tr>
                                <tr>
                                    <th>Payment Type</th>
                                    <td>:</td>
                                    <th>{{$do->paymentType()}}</th>
                                    <td>|</td>
                                    <th>Distribution Type</th>
                                    <td>:</td>
                                    <th>{{$do->distributionType()}}</th>
                                </tr>
                                <tr>
                                    <th>Total Product</th>
                                    <td>:</td>
                                    <th>{{$do->odps_count}}</th>
                                    <td>|</td>
                                    <th>Preparation Time</th>
                                    <td>:</td>
                                    <th>{{readablePrepTime($do->created_at,$do->prep_time)}}</th>
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
                        <form action="{{route('do.do_update')}}" method="POST" class="px-0">
                        @csrf
                            @php
                                $dop_status = '';
                            @endphp
                            @foreach ($do->odps as $key=>$dop)
                                @php
                                    if($dop->status == 3){
                                        $dop_status = 3;
                                    }
                                @endphp
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-2 mb-0 mt-3">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-9">
                                                        <div class="media">
                                                            <div class="sq align-self-center "> <img class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="{{storage_url($dop->cart->product->image)}}" width="135" height="135" /> </div>
                                                            <div class="media-body my-auto text-center">
                                                                <div class="row  my-auto flex-column flex-md-row px-3">
                                                                    <div class="col text-start"> 
                                                                        <h6 class="mb-0 text-start">{{$dop->cart->product->name}}</h6> 
                                                                        <small>{{$dop->cart->product->pro_cat->name}} </small> 
                                                                    </div>
                                                                    <div class="col-auto my-auto"> </div>
                                                                    <div class="col my-auto"> <small>Qty : {{$dop->cart->quantity}}</small></div>
                                                                    <div class="col my-auto"> <small>Pack : {{$dop->cart->unit->name ?? 'Piece'}}</small></div>
                                                                    <div class="col my-auto">
                                                                        <h6 class="mb-0 text-end">
                                                                            @if (productDiscountPercentage($dop->cart->product->id))
                                                                            <span class="text-danger">
                                                                                <del>
                                                                                    {!! get_taka_icon() !!} {{number_format((($dop->cart->product->price*($dop->cart->unit->quantity ?? 1)) * $dop->cart->quantity), 2)}}
                                                                                </del>
                                                                            </span> 
                                                                            @endif
                                                                        </h6>
                                                                        <h6 class="mb-0 text-end">
                                                                            <span>
                                                                                {!! get_taka_icon() !!} {{number_format((($dop->cart->product->discountPrice()*$dop->cart->unit->quantity) * $dop->cart->quantity), 2)}}
                                                                            </span> 
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col my-auto text-end"><span class="{{$dop->statusBg()}}">{{$dop->statusTitle()}}</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-3">
                                                        @if($dop->status == 3)
                                                        <input type="hidden" name="datas[{{$key}}][cart_id]" value="{{$dop->cart->id}}">
                                                        <input type="hidden" name="datas[{{$key}}][dop_id]" value="{{$dop->id}}">
                                                        <div class="form-group">
                                                            <select name="datas[{{$key}}][pharmacy_id]" class="form-control {{ $errors->has('datas.'.$key.'.pharmacy_id') ? ' is-invalid' : '' }}">
                                                                <option selected hidden>Select Pharmacy</option>
                                                                @foreach ($pharmacies as $pharmacy)
                                                                    <option @if((isset($do->odps) && $do->odps[$key]->pharmacy_id == $pharmacy->id) || (old('datas.'.$key.'.pharmacy_id') == $pharmacy->id)) selected @endif value="{{$pharmacy->id}}">{{$pharmacy->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            @include('alerts.feedback', ['field' => 'datas.'.$key.'.pharmacy_id'])
                                                        </div>
                                                        @else
                                                            <input type="text" class="form-control" disabled value="{{$do->odps[$key]->pharmacy->name}}">
                                                        @endif
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    @if($dop->status == 3 || $dop->status == -1)
                                        <span><strong class="text-danger">{{__('Resoan: ')}}</strong>{{$dop->note}}</span>
                                    @endif
                                    </div>
                                    
                                </div>
                            @endforeach
                            @if( $dop_status == 3)
                                <div class="row">
                                    <div class="form-group col-md-12 text-end">
                                        <input type="submit" value="Update" class="btn btn-primary">
                                    </div>
                                </div>   
                            @endif     
                        </form>
                    </div>
                @empty
                    <h1 class="text-danger text-center my-5">No dispute orders available.</h1>
                @endforelse
            </div>
        </div>
    </div>

@endsection
