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
                    <form action="{{route('pharmacy.order_management.update',encrypt($do->id))}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12 px-4 text-end">
                                <span class="{{ $statusBg }}">{{ $statusTitle }}</span>
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
                                                    <div class="col my-auto d-flex justify-content-around"> <small>Qty : {{ $dop->cart->quantity }}</small><small>Pack :
                                                        {{ $dop->cart->unit->name ?? 'Piece' }}</small>
                                                    </div>
                                                    <div class="col my-auto">
                                                        <h6 class="my-auto text-center">
                                                            @php
                                                                $totalPrice = ($dop->cart->product->price * ($dop->cart->unit->quantity ?? 1) * $dop->cart->quantity);
                                                                if ($do->payment_type == 0 && $pharmacy_discount){
                                                                    $totalPrice -= (($totalPrice/100)*$pharmacy_discount->discount_percent);
                                                                    $discount = "<span class='badge badge-danger'>$pharmacy_discount->discount_percent.'% off'</span>";
                                                                }
                                                            @endphp
                                                            <span><strong>{{ __('Total Price : ') }}</strong>{!! get_taka_icon() !!}
                                                                
                                                                {{ number_format($totalPrice, 2) }}</span> <sup>{!! isset($discount) ? $discount : '' !!}</sup>
                                                        </h6>
                                                        @if ($do->payment_type == 1 && $status == 0)
                                                            <div class="input-group">
                                                                <input type="text" name="data[{{$key}}][open_amount]" class="form-control"
                                                                    placeholder="Enter your product price">
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if ($do->payment_type == 1 && $status == 1 && $dop->open_amount>0)
                                                        <div class="col my-auto">
                                                            <h6 class="my-auto text-center">
                                                                <span><strong>{{ __('Bit Price : ') }}</strong>{!! get_taka_icon() !!}
                                                                    {{ number_format($dop->open_amount, 2) }}</span>
                                                            </h6>
                                                        </div>
                                                    @endif
                                                    @if($status == 0)
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
                        @if($status == 0)
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
