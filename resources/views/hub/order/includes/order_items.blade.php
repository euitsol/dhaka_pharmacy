@php
    $collecting = \App\Models\Order::ITEMS_COLLECTING == $order->status;
    $assigend = \App\Models\Order::HUB_ASSIGNED == $order->status;
    $collected = \App\Models\Order::ITEMS_COLLECTED == $order->status;
@endphp


<div class="card ">
    <div class="card-header">
        <div class="col-auto">
            <h4 class="color-1 mb-0">{{ __('Ordered Products') }}</h4>
        </div>
        <div class="col-auto"> </div>
    </div>
    <div class="card-body order_items">
        <form action="{{ route('hub.order.collected') }}" method="POST" class="px-0" id="order_collecting_form">
            @csrf
            <input type="hidden" name="order_id" value="{{ encrypt($order->id) }}" class="d-none">
        <div class="row">
            @foreach ($order_hub_products as $key => $ohp)
                <div class="col-12 product-container">
                    <input type="hidden" name="data[{{ $key }}][p_id]" value="{{ optional($ohp->product)->id }}">
                    <div class="card card-2 mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <div class="media">
                                        <div class="sq align-self-center "> <img
                                                class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                                                src="{{ optional($ohp->product)->image }}"
                                                width="50" height="50"/> </div>
                                        <div class="media-body my-auto text-center">
                                            <div
                                                class="row  my-auto flex-column flex-md-row px-3">
                                                <div class="col my-auto">
                                                    <h6 class="mb-0 text-start">
                                                        {{ optional($ohp->product)->name }}</h6>
                                                </div>
                                                <div class="col-auto my-auto">
                                                    <small>{{ optional(optional($ohp->product)->pro_cat)->name }}
                                                    </small>
                                                </div>
                                                <div class="col my-auto">
                                                    <small>{{ __('Qty :') }}
                                                        <span class="quantity">
                                                            {{ $ohp->quantity ?? '--' }}
                                                        </span>
                                                    </small>
                                                </div>
                                                <div class="col my-auto">
                                                    <small>{{ __('Unit :') }}
                                                        {{ optional($ohp->pivot)->unit_name ?? '--' }}</small>
                                                </div>
                                                <div class="col my-auto unit_total" style="display: none;">
                                                    <small>
                                                        {{ __('Unit Total Price :') }}
                                                        {!! get_taka_icon() !!}
                                                        <span class="unit_total_price"></span>
                                                    </small>
                                                </div>
                                                {{-- @if ($collecting)
                                                    <div class="col my-auto">
                                                        <small>
                                                            {{ __('Total Price :') }}
                                                            {{ optional($product->pivot)->unit_price * optional($product->pivot)->quantity ?? '--' }}
                                                        </small> <br>
                                                        <small>
                                                            {{ __('Discount :') }}
                                                            {{ optional($product->pivot)->unit_discount * optional($product->pivot)->quantity ?? '--' }}
                                                        </small> <br>
                                                        <small>
                                                            {{ __('Total Payable :') }}
                                                            {{ optional($product->pivot)->total_price ?? '--' }}
                                                        </small>
                                                    </div>
                                                @endif --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Hub Assignment Column --}}
                                @if ($collecting)
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>{{ __('Collected from Pharmacy') }}</label>
                                        <select class="form-control pharmacy_id" name="data[{{ $key }}][pharmacy_id]" class="no-select" required>
                                            <option value="">{{ __('Select Pharmacy') }}</option>
                                            @foreach ($pharmacies as $pharmacy)
                                                <option value="{{ $pharmacy->id }}"
                                                    {{ $pharmacy->id == $oh->pharmacy_id ? 'selected' : '' }}>
                                                    {{ $pharmacy->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Payable Price Per Unit') }}</label>
                                        <input type="number" class="form-control unit_price" name="data[{{ $key }}][unit_payable_price]" value="{{ optional(optional($ohp->product)->pivot)->collecting_price ?? '' }}" required>
                                    </div>
                                </div>
                                @endif
                                @if ($collected)
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>{{ __('Collected from Pharmacy') }}</label>
                                        <div class="hub-display">
                                            @if(isset($ohp->pivot->pharmacy_id) && !empty($ohp->pivot->pharmacy_id))
                                                <div class="text-success">
                                                    <i class="fa-solid fa-shop"></i>
                                                    {{ $ohp->pivot->pharmacy_name }}
                                                </div>
                                            @else
                                                <div class="text-danger">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    {{ __('Not collected yet') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($assigend)
            <div class="col-12">
                <div class="row mt-3">
                    <div class="form-group col-md-12 text-end">
                        <a type="button" href="{{ route('hub.order.collecting', encrypt($order->id)) }}"
                            class="btn btn-primary" onclick="return confirm('Are you sure?')">{{ __('Start Collecting') }}</a>
                    </div>
                </div>
            </div>
            @endif
            @if ($collecting)
            <div class="col-12">
                <div class="row mt-3">
                    <div class="col-md-9">
                        <label>{{ __('Note') }}</label>
                        <textarea name="note" class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}">
                            {{ old('note') }}
                        </textarea>
                        @include('alerts.feedback', [
                            'field' => 'note',
                        ])
                    </div>
                    <div class="col-md-3 mt-2">
                        <table class="table table-striped">
                            <tr>
                                <td class="fw-bolder">{{ __('Total Collecting Price') }}</td>
                                <td>:</td>
                                <td class="fw-bolder">
                                    {!! get_taka_icon() !!}
                                    <span class="total_collecting_price"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    {{-- <div class="form-group col-md-12">
                    </div> --}}
                    <div class="form-group col-md-12 text-end">
                        <input type="submit" value="Collect"
                            class="btn btn-primary">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </form>
    </div>
</div>

@if ($collected)
<div class="card-body">
    <form action="{{ route('hub.order.prepared') }}" id="order_prepared_form" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ encrypt($order->id) }}" class="d-none">
        <div class="col-12">
            <div class="row mt-3">
                <div class="col-md-8"></div>
                {{-- <div class="form-group col-md-8">
                    <label>{{ __('Note') }}</label>
                    <textarea name="note" class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}">
                        {{ old('note') }}
                    </textarea>
                    @include('alerts.feedback', [
                        'field' => 'note',
                    ])
                </div> --}}
                <div class="form-group col-md-4 text-end">
                    <button type="submit"
                        class="btn btn-primary">{{ __('Mark as Prepared') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endif
