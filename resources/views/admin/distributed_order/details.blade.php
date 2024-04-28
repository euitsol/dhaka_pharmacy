@extends('admin.layouts.master', ['pageSlug' => 'order_'.$status])
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
                            @include('admin.partials.button', [
                                'routeName' => 'do.do_edit',
                                'className' => 'btn-success',
                                'params' => [encrypt($do->id),encrypt($do->pharmacy->id)],
                                'label' => 'Edit',
                            ])
                            @include('admin.partials.button', [
                                'routeName' => 'do.do_list',
                                'className' => 'btn-primary',
                                'params' => $status,
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
                                <th>{{$do->pharmacy->name}}</th>
                                <td>|</td>
                                <th>Order ID</th>
                                <td>:</td>
                                <th>{{$do->order->order_id}}</th>
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
                                <th>{{count($do->dops)}}</th>
                                <td>|</td>
                                <th>Preparation Time</th>
                                <td>:</td>
                                <th>{{$do->prep_time}}</th>
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
                    @foreach ($do->dops as $dop)
                        <div class="col-12">
                            <div class="card card-2">
                                <div class="card-body">
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
                                                        <span class="text-danger"><del>{!! get_taka_icon() !!} {{number_format((($dop->cart->product->regular_price*$dop->cart->unit->quantity) * $dop->cart->quantity), 2)}}</del></span> 
                                                        @endif
                                                    </h6>
                                                    <h6 class="mb-0 text-end">
                                                        <span>{!! get_taka_icon() !!} {{number_format((($dop->cart->product->price*($dop->cart->unit->quantity ?? 1)) * $dop->cart->quantity), 2)}}</span> 
                                                    </h6>
                                                </div>
                                                <div class="col my-auto text-end"><span class="{{$dop->statusBg()}}">{{$dop->statusTitle()}}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
