@php
    $submitted = \App\Models\Order::SUBMITTED == $order->status;
    $assigend = \App\Models\Order::HUB_ASSIGNED == $order->status;
    $collected = \App\Models\Order::ITEMS_COLLECTED == $order->status;
@endphp

<form action="{{ route('om.order.hub_assign') }}" method="POST" class="px-0">
    @csrf
    <input type="hidden" name="order_id" value="{{ encrypt($order_id) }}" class="d-none">
    <div class="card ">
        <div class="card-header">
            <div class="col-auto">
                <h4 class="color-1 mb-0">{{ __('Ordered Products') }}</h4>
            </div>
            <div class="col-auto"> </div>
        </div>
        <div class="card-body order_items">
            <div class="row">
                @foreach ($products as $key => $product)
                    <div class="col-12">
                        <input type="hidden" name="data[{{ $key }}][p_id]" value="{{ $product->id }}">
                        <div class="card card-2 mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <div class="media">
                                            <div class="sq align-self-center "> <img
                                                    class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                                                    src="{{ $product->image }}"
                                                    width="50" height="50" /> </div>
                                            <div class="media-body my-auto text-center">
                                                <div
                                                    class="row  my-auto flex-column flex-md-row px-3">
                                                    <div class="col my-auto">
                                                        <h6 class="mb-0 text-start">
                                                            {{ $product->name }}</h6>
                                                    </div>
                                                    <div class="col-auto my-auto">
                                                        <small>{{ optional($product->pro_cat)->name }}
                                                        </small>
                                                    </div>
                                                    <div class="col my-auto">
                                                        <small>{{ __('Qty :') }}
                                                            {{ optional($product->pivot)->quantity }}</small>
                                                    </div>
                                                    <div class="col my-auto">
                                                        <small>{{ __('Pack :') }}
                                                            {{ optional($product->pivot)->unit->name ?? '--' }}</small>
                                                    </div>
                                                    @if ($submitted)
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
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Hub Assignment Column --}}
                                    <div class="col-3">
                                        <div class="form-group">
                                            @if($submitted)
                                                {{-- Editable Hub Selection --}}
                                                <label>{{ __('Assign Hub') }}</label>
                                                <select class="form-control no-select" name="data[{{ $key }}][hub_id]">
                                                    <option value="">Select Hub</option>
                                                    @foreach ($hubs as $hub)
                                                        <option value="{{ $hub->id }}"
                                                            {{ $product->hub?->id === $hub->id ? 'selected' : '' }}>
                                                            {{ $hub->name.' | '.$hub->address->address }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                {{-- Read-only Hub Display --}}
                                                <label>{{ __('Assigned Hub') }}</label>
                                                <div class="hub-display">
                                                    @if(isset($product->pivot->hub_id) && !empty($product->pivot->hub_id))
                                                        <div class="text-success">
                                                            <i class="fas fa-warehouse"></i>
                                                            {{ $product->pivot->hub_name }}
                                                        </div>
                                                    @else
                                                        <div class="text-danger">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                            {{ __('Not assigned') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            @if ($collected)
                                                <label>{{ __('Collected from Pharmacy') }}</label>
                                                <div class="hub-display">
                                                    @if(isset($product->pivot->pharmacy_id) && !empty($product->pivot->pharmacy_id))
                                                        <div class="text-success">
                                                            <i class="fa-solid fa-shop"></i>
                                                            {{ $product->pivot->pharmacy_name }}
                                                        </div>
                                                    @else
                                                        <div class="text-danger">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                            {{ __('Not collected yet') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($submitted)
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label>{{ __('Note') }}</label>
                            <textarea name="note" @if (isset($order->od) && $order->od->status == 0) disabled @endif
                                class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}"
                                placeholder="Enter order instraction for pharmacy">{{ isset($order->od->note) ? $order->od->note : old('note') }}</textarea>
                            @include('alerts.feedback', [
                                'field' => 'note',
                            ])
                        </div>
                        <div class="form-group col-md-12 text-end">
                            <input type="submit" value="Distribute"
                                class="btn btn-primary">
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</form>
