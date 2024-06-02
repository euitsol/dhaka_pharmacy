@extends('pharmacy.layouts.master', ['pageSlug' => $statusTitle . '_orders'])
@push('css')

    <style>
        .rider_image{
            text-align: center;
        }
        .rider_image img{
            height: 250px;
            width: 250px;
            border-radius: 50%; 
        }
    </style>
    
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ __(ucwords(strtolower((str_replace('-', ' ', $statusTitle)))).' Order Details') }}</h4>
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
                                <th>{{__('Order ID')}}</th>
                                <td>:</td>
                                <th>{{ $do->order->order_id }}</th>
                                <td>|</td>
                                <th>{{__('Total Price')}}</th>
                                <td>:</td>
                                <th>{!! get_taka_icon() !!}{{ number_format(ceil($do->dops->sum('totalPrice'))) }}</th>
                            </tr>
                            <tr>
                                <th>{{__('Payment Type')}}</th>
                                <td>:</td>
                                <th>{{ $do->paymentType() }}</th>
                                <td>|</td>
                                <th>{{__('Distribution Type')}}</th>
                                <td>:</td>
                                <th>{{ $do->distributionType() }}</th>
                            </tr>
                            <tr>
                                <th>{{__('Total Product')}}</th>
                                <td>:</td>
                                <th>{{ count($do->dops) }}</th>
                                <td>|</td>
                                <th>{{__('Preparation Time')}}</th>
                                <td>:</td>
                                <th>{{ $do->prep_time }}</th>
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
                    @if($odr)
                        @if($status == 2)
                            <h5><b>{{__('Note:')}}</b> <span class="text-danger">{{__('Please verify your order before handing it over to the rider. Your OTP is : ')}} </span> <strong class="text-success">{{optional($otp)->otp}}</strong></h5>
                        @endif
                        @if($status == 4)
                            <h4 class="text-success m-0 py-3">{{__('Order successfully collected.')}}</h4>
                        @endif
                        @if($status == 5)
                            <h4 class="text-success m-0 py-3">{{__('Order successfully delivered.')}}</h4>
                        @endif
                        
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Rider Details')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="rider_image">
                                                    <img src="{{storage_url($odr->rider->image)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="card-footer bg-secondary">
                                                <h3 class="text-white m-0">{{$odr->rider->name}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table table-striped datatable">
                                            <tbody>
                                                <tr>
                                                    <th>{{__('Rider Name')}}</th>
                                                    <td>:</td>
                                                    <th>{{ $odr->rider->name }}</th>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Rider Gender')}}</th>
                                                    <td>:</td>
                                                    <th>{{ $odr->rider->gender }}</th>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Rider Contact')}}</th>
                                                    <td>:</td>
                                                    <th>{{ $odr->rider->phone }}</th>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Rider Age')}}</th>
                                                    <td>:</td>
                                                    <th>{{ $odr->rider->age }}</th>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Delivery Priority')}}</th>
                                                    <td>:</td>
                                                    <th>{{ $odr->priority() }}</th>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Operational Area')}}</th>
                                                    <td>:</td>
                                                    <th>{{ $odr->rider->operation_area->name }}</th>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Operational Sub Area')}}</th>
                                                    <td>:</td>
                                                    <th>{{ $odr->rider->operation_sub_area->name }}</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <form action="{{route('pharmacy.order_management.update',encrypt($do->id))}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12 px-4 text-end">
                                <span class="{{ $statusBg }}">{{  __(ucwords(strtolower((str_replace('-', ' ', $statusTitle))))) }}</span>
                            </div>
                        </div>
                        @foreach ($do->dops as $key=>$dop)
                            <div class="col-12 status_wrap">
                                <div class="card card-2 mb-0 mt-3">
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
                                                    <div class="col my-auto d-flex justify-content-around"> <small>Qty : {{ $dop->cart->quantity }}</small><small>Pack : {{ $dop->cart->unit->name ?? 'Piece' }}</small>
                                                    </div>
                                                    <div class="col my-auto">
                                                        <h6 class="my-auto text-center">
                                                            <span><strong>{{ __('Total Price : ') }}</strong>{!! get_taka_icon() !!}
                                                                
                                                                {{ number_format(ceil($dop->totalPrice)) }}</span> <sup><span class='badge badge-danger'>@if(isset($dop->discount)){{$dop->discount.'% off'}}@endif</span></sup>
                                                        </h6>
                                                        @if ($do->payment_type == 1 && ($status == 0 || $status == 1))
                                                            <div class="input-group">
                                                                <input type="text" name="data[{{$key}}][open_amount]" class="form-control"
                                                                    placeholder="Enter your product price">
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if ($do->payment_type == 1 && ($status == 1 || $status == 0) && $dop->open_amount>0)
                                                        <div class="col my-auto">
                                                            <h6 class="my-auto text-center">
                                                                <span><strong>{{ __('Bit Price : ') }}</strong>{!! get_taka_icon() !!}
                                                                    {{ number_format($dop->open_amount, 2) }}</span>
                                                            </h6>
                                                        </div>
                                                    @endif
                                                    @if($status == 0 || $status == 1)
                                                    <div class="col my-auto">
                                                        <div class="card mb-0">
                                                            <div class="card-body">
                                                                <input type="hidden" name="data[{{$key}}][dop_id]" value="{{$dop->id}}">
                                                                
                                                                    <div class="form-check form-check-radio">
                                                                        <label class="form-check-label me-2" for="status_{{$key}}">
                                                                            <input class="form-check-input do_status" type="radio"
                                                                                name="data[{{$key}}][status]" id="status_{{$key}}"
                                                                                value="2" checked>
                                                                                {{__('Accept')}}
                                                                            <span class="form-check-sign"></span>
                                                                        </label>
                                                                        <label class="form-check-label" for="status{{$key}}">
                                                                            <input class="form-check-input do_status" type="radio"
                                                                                name="data[{{$key}}][status]" id="status{{$key}}"
                                                                                value="3">
                                                                                {{__("Dispute")}}
                                                                            <span class="form-check-sign"></span>
                                                                        </label>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($status == 0 || $status == 1)
                                    <div class="form-group status_note" style="display: none">
                                        <textarea name="data[{{$key}}][note]" class="form-control" placeholder="Enter dispute reason"></textarea>
                                    </div>
                                    @include('alerts.feedback', ['field' => 'data.'.$key.'.note'])
                                @elseif($status == 3 || $status == -1)
                                    <span><strong class="text-danger">{{__('Resoan: ')}}</strong>{{$dop->note}}</span>
                                @endif
                                
                            </div>
                        @endforeach
                        @if($status == 0 || $status == 1)
                            <div class="col-12 text-end">
                                <input type="submit" value="Confirm" class="btn btn-success">
                            </div>
                        @endif
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $('.do_status').on('change',function(){
            if($(this).val() == 3){
                $(this).closest('.status_wrap').find('.status_note').show();
            }else{
                $(this).closest('.status_wrap').find('.status_note').hide();
                $(this).closest('.status_wrap').find('.status_note .form-control').val('');
            }
        });
    });
</script>
    
@endpush
