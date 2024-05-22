@extends('admin.layouts.master', ['pageSlug' => 'order_'.strtolower($do->statusTitle())])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ __('Distributed Order Details') }}</h4>
                        </div>
                        <div class="col-6 text-end">
                            {{-- @include('admin.partials.button', [
                                'routeName' => 'do.do_edit',
                                'className' => 'btn-success',
                                'params' => [encrypt($do->id),encrypt($do->pharmacy->id)],
                                'label' => 'Edit',
                            ]) --}}
                            @include('admin.partials.button', [
                                'routeName' => 'do.do_list',
                                'className' => 'btn-primary',
                                'params' => strtolower($do->statusTitle()),
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <tbody>
                            <tr>
                                <th>{{__('Order ID')}}</th>
                                <td>:</td>
                                <th>{{$do->order->order_id}}</th>
                                <td>|</td>
                                <th>{{__('Total Price')}}</th>
                                <td>:</td>
                                <th>{!! get_taka_icon(). number_format($totalPrice).".00" !!}</th>
                            </tr>
                            <tr>
                                <th>{{__('Payment Type')}}</th>
                                <td>:</td>
                                <th>{{$do->paymentType()}}</th>
                                <td>|</td>
                                <th>{{__('Distribution Type')}}</th>
                                <td>:</td>
                                <th>{{$do->distributionType()}}</th>
                            </tr>
                            <tr>
                                <th>{{__('Total Product')}}</th>
                                <td>:</td>
                                <th>{{$do->odps_count}}</th>
                                <td>|</td>
                                <th>{{__('Preparation Time')}}</th>
                                <td>:</td>
                                <th>{{readablePrepTime($do->created_at,$do->prep_time)}}</th>
                            </tr>
                            <tr>
                                <th>{{__('Note')}}</th>
                                <td>:</td>
                                <th colspan="5">{!! $do->note !!}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @if($do->status !=0 && $do->status !=1)
                        @if(auth()->user()->can('do_rider'))
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="card-title">{{ __('Rider Management') }}</h4>
                                        </div>
                                        <div class="col-6 text-end">
                                            <span class="{{$do->statusBg()}}">{{ __(ucwords(strtolower((str_replace('-', ' ', $do->statusTitle()))))) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{route('do.do_rider',encrypt($do->id))}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('Rider')}}</label>
                                                @if($do_rider)
                                                    @php
                                                        $area = $do_rider->rider->operation_area ? ($do_rider->rider->operation_sub_area ? "( ".$do_rider->rider->operation_area->name." - " : "( ".$do_rider->rider->operation_area->name." )")  : '';
                                                        $sub_area = $do_rider->rider->operation_sub_area ? ($do_rider->rider->operation_area ? $do_rider->rider->operation_sub_area->name." )" : "( ".$do_rider->rider->operation_sub_area->name." )" )  : '';
                                                    @endphp
                                                    <input type="text" class="form-control" value="{{$do_rider->rider->name.$area.$sub_area}}" disabled>
                                                @else
                                                    <select name="rider_id" class="form-control">
                                                        <option selected hidden value="">{{__('Select Rider')}}</option>
                                                        @foreach ($riders as $rider)
                                                            @php
                                                                $area = $rider->operation_area ? ($rider->operation_sub_area ? "( ".$rider->operation_area->name." - " : "( ".$rider->operation_area->name." )")  : '';
                                                                $sub_area = $rider->operation_sub_area ? ($rider->operation_area ? $rider->operation_sub_area->name." )" : "( ".$rider->operation_sub_area->name." )" )  : '';
                                                            @endphp
                                                            <option value="{{$rider->id}}" {{$rider->id == old('rider_id') ? 'selected' : ''}}>{{$rider->name.$area.$sub_area}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                                @include('alerts.feedback', ['field' => 'rider_id'])

                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>{{__('Priority')}}</label>
                                                @if($do_rider)
                                                    <input type="text" class="form-control" value="{{$do_rider->priority()}}" disabled>
                                                @else
                                                    <select name="priority" class="form-control">
                                                        <option selected hidden value="">{{__('Select Priority')}}</option>
                                                        <option value="0">{{__('Normal')}}</option>
                                                        <option value="1">{{__('Medium')}}</option>
                                                        <option value="2">{{__('High')}}</option>
                                                    </select>
                                                @endif
                                                @include('alerts.feedback', ['field' => 'priority'])
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>{{__('Instraction')}}</label>
                                                <textarea name="instraction" {{$do_rider ? 'disabled' : ''}} class="form-control" placeholder="Write delivery instration here">{{optional($do_rider)->instraction}}</textarea>
                                                @include('alerts.feedback', ['field' => 'instraction'])
                                            </div>
                                            @if(!$do_rider)
                                                <div class="form-group text-end">
                                                    <input type="submit" class="btn btn-primary" value="Assign">
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            @if($do->status !=2)
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped datatable">
                                        <tbody>
                                            <tr>
                                                <th>{{__('Assined Rider')}}</th>
                                                <td>:</td>
                                                <th>{{$do_rider ? $do_rider->rider->name : 'Not Assign Yet'}}</th>
                                                <td>|</td>
                                                <th>{{__('Priority')}}</th>
                                                <td>:</td>
                                                <th>{{ $do_rider ? $do_rider->priority() : '--'}}</th>
                                            </tr>
                                            <tr>
                                                <th>{{__('Delivery Instraction')}}</th>
                                                <td>:</td>
                                                <th colspan="5">{!! $do_rider ? $do_rider->instraction : '__' !!}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        @endif
                    @endif
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
                                                            <option selected hidden>{{__('Select Pharmacy')}}</option>
                                                            @foreach ($pharmacies as $pharmacy)
                                                                @php
                                                                    $area = $pharmacy->operation_area ? ($pharmacy->operation_sub_area ? "( ".$pharmacy->operation_area->name." - " : "( ".$pharmacy->operation_area->name." )")  : '';
                                                                    $sub_area = $pharmacy->operation_sub_area ? ($pharmacy->operation_area ? $pharmacy->operation_sub_area->name." )" : "( ".$pharmacy->operation_sub_area->name." )" )  : '';
                                                                @endphp
                                                                <option @if((isset($do->odps) && $do->odps[$key]->pharmacy_id == $pharmacy->id) || (old('datas.'.$key.'.pharmacy_id') == $pharmacy->id)) selected @endif value="{{$pharmacy->id}}">{{$pharmacy->name.$area.$sub_area}}</option>
                                                            @endforeach
                                                        </select>
                                                        @include('alerts.feedback', ['field' => 'datas.'.$key.'.pharmacy_id'])
                                                    </div>
                                                    @else
                                                        @php
                                                            $area = $do->odps[$key]->pharmacy->operation_area ? ($do->odps[$key]->pharmacy->operation_sub_area ? "( ".$do->odps[$key]->pharmacy->operation_area->name." - " : "( ".$do->odps[$key]->pharmacy->operation_area->name." )")  : '';
                                                            $sub_area = $do->odps[$key]->pharmacy->operation_sub_area ? ($do->odps[$key]->pharmacy->operation_area ? $do->odps[$key]->pharmacy->operation_sub_area->name." )" : "( ".$do->odps[$key]->pharmacy->operation_sub_area->name." )" )  : '';
                                                        @endphp
                                                        <input type="text" class="form-control" disabled value="{{$do->odps[$key]->pharmacy->name.$area.$sub_area}}">
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
            </div>
        </div>
    </div>

@endsection
