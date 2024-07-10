@extends('admin.layouts.master', ['pageSlug' => 'order_' . $do->order->statusTitle()])
@push('css')
    <style>
        .rider_image {
            text-align: center;
        }

        .rider_image img {
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
                            <h4 class="card-title">{{ __('Processed Order Details') }}</h4>
                        </div>
                        <div class="col-6 text-end">
                            @include('admin.partials.button', [
                                'routeName' => URL::previous(),
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('admin.distributed_order.includes.order_details', ['od' => $do])
                </div>
                <div class="card-footer">
                    @if ($do->status != 0 && $do->status != 1)
                        @if ($do->disputedRiders->count() > 0)
                            <h4>{{ __('Rider Dispute Reasons:') }}</h4>
                        @endif
                        @foreach ($do->disputedRiders as $ddor)
                            <p class="m-0 mb-1"><b class="fw-bold">{{ $ddor->rider->name . ' : ' }}</b><span
                                    class="text-danger">{{ $ddor->dispute_note }}</span></p>
                        @endforeach

                        @if (auth()->user()->can('assign_order') && !$do->assignedRider->first())
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="card-title">{{ __('Rider Management') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('om.order.assign_order', encrypt($do->id)) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label>{{ __('Rider') }}</label>
                                                <select name="rider_id" class="form-control">
                                                    <option selected hidden value=" ">{{ __('Select Rider') }}
                                                    </option>
                                                    @foreach ($riders as $rider)
                                                        @php
                                                            $area = $rider->operation_area
                                                                ? ($rider->operation_sub_area
                                                                    ? '( ' . $rider->operation_area->name . ' - '
                                                                    : '( ' . $rider->operation_area->name . ' )')
                                                                : '';
                                                            $sub_area = $rider->operation_sub_area
                                                                ? ($rider->operation_area
                                                                    ? $rider->operation_sub_area->name . ' )'
                                                                    : '( ' . $rider->operation_sub_area->name . ' )')
                                                                : '';
                                                        @endphp
                                                        <option value="{{ $rider->id }}"
                                                            {{ $rider->id == old('rider_id') ? 'selected' : '' }}>
                                                            {{ $rider->name . $area . $sub_area }}</option>
                                                    @endforeach
                                                </select>
                                                @include('alerts.feedback', ['field' => 'rider_id'])

                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>{{ __('Priority') }}</label>
                                                <select name="priority" class="form-control">
                                                    <option selected hidden value=" ">{{ __('Select Priority') }}
                                                    </option>
                                                    <option value="0">{{ __('Normal') }}</option>
                                                    <option value="1">{{ __('Medium') }}</option>
                                                    <option value="2">{{ __('High') }}</option>
                                                </select>
                                                @include('alerts.feedback', ['field' => 'priority'])
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="pick_up_time">{{ __('Pick up Time') }}<span
                                                        class="text-danger">*</span></label>
                                                <select id="pick_up_time" class="form-control" name="pick_up_time">
                                                    <option value="5">5 minutes</option>
                                                    <option value="10">10 minutes</option>
                                                    <option value="15">15 minutes</option>
                                                    <option value="30">30 minutes</option>
                                                    <option value="45">45 minutes</option>
                                                    <option value="60">1 hour</option>
                                                    <option value="90">1.5 hours</option>
                                                    <option value="120">2 hours</option>
                                                </select>
                                                @include('alerts.feedback', [
                                                    'field' => 'pick_up_time',
                                                ])
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="delivery_time">{{ __('Delivery Time') }}<span
                                                        class="text-danger">*</span></label>
                                                <select id="delivery_time" class="form-control" name="delivery_time">
                                                    <option value="5">5 minutes</option>
                                                    <option value="10">10 minutes</option>
                                                    <option value="15">15 minutes</option>
                                                    <option value="30">30 minutes</option>
                                                    <option value="45">45 minutes</option>
                                                    <option value="60">1 hour</option>
                                                    <option value="90">1.5 hours</option>
                                                    <option value="120">2 hours</option>
                                                </select>
                                                @include('alerts.feedback', [
                                                    'field' => 'delivery_time',
                                                ])
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>{{ __('Instraction') }}</label>
                                                <textarea name="instraction" class="form-control" placeholder="Write delivery instration here">{{ optional($do->assignedRider->first())->instraction }}</textarea>
                                                @include('alerts.feedback', ['field' => 'instraction'])
                                            </div>
                                            <div class="form-group text-end">
                                                <input type="submit" class="btn btn-primary" value="Assign">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @elseif($do->assignedRider->first())
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="card-title">{{ __('Rider Details') }}</h4>
                                        </div>
                                        <div class="col-6 text-end">
                                            <span
                                                class="{{ $do->assignedRider->first()->statusBg() }}">{{ __(slugToTitle($do->assignedRider->first()->statusTitle())) }}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="rider_image">
                                                        <img src="{{ storage_url($do->assignedRider->first()->rider->image) }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-secondary">
                                                    <h3 class="text-white m-0">
                                                        {{ $do->assignedRider->first()->rider->name }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <table class="table table-striped datatable">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-bold">{{ __('Rider Name') }}</td>
                                                        <td>:</td>
                                                        <td class="fw-bold">{{ $do->assignedRider->first()->rider->name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">{{ __('Rider Gender') }}</td>
                                                        <td>:</td>
                                                        <td class="fw-bold">
                                                            {{ $do->assignedRider->first()->rider->gender }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">{{ __('Rider Contact') }}</td>
                                                        <td>:</td>
                                                        <td class="fw-bold">{{ $do->assignedRider->first()->rider->phone }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">{{ __('Rider Age') }}</td>
                                                        <td>:</td>
                                                        <td class="fw-bold">{{ $do->assignedRider->first()->rider->age }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">{{ __('Delivery Priority') }}</td>
                                                        <td>:</td>
                                                        <td class="fw-bold">{{ $do->assignedRider->first()->priority() }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">{{ __('Operational Area') }}</td>
                                                        <td>:</td>
                                                        <td class="fw-bold">
                                                            {{ $do->assignedRider->first()->rider->operation_area->name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">{{ __('Operational Sub Area') }}</td>
                                                        <td>:</td>
                                                        <td class="fw-bold">
                                                            {{ optional($do->assignedRider->first()->rider->operation_sub_area)->name }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <form action="{{ route('om.order.dispute_update') }}" method="POST" class="px-0">
                        @csrf
                        @foreach ($do->odps as $key => $dop)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-2 mb-0 mt-3">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-9">
                                                    <div class="media">
                                                        <div class="sq align-self-center "> <img
                                                                class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                                                                src="{{ storage_url($dop->order_product->product->image) }}"
                                                                width="135" height="135" /> </div>
                                                        <div class="media-body my-auto text-center">
                                                            <div class="row  my-auto flex-column flex-md-row px-3">
                                                                <div class="col text-start">
                                                                    <h6 class="mb-0 text-start">
                                                                        {{ $dop->order_product->product->name }}</h6>
                                                                    <small>{{ $dop->order_product->product->pro_cat->name }}
                                                                    </small>
                                                                </div>
                                                                <div class="col-auto my-auto"> </div>
                                                                <div class="col my-auto"> <small>{{ __('Qty :') }}
                                                                        {{ $dop->order_product->quantity }}</small></div>
                                                                <div class="col my-auto"> <small>{{ __('Pack :') }}
                                                                        {{ $dop->order_product->unit->name ?? 'Piece' }}</small>
                                                                </div>
                                                                <div class="col my-auto text-end"><span
                                                                        class="{{ $dop->statusBg() }}">{{ slugToTitle($dop->statusTitle()) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    @if ($dop->status == 3)
                                                        <input type="hidden" name="datas[{{ $key }}][op_id]"
                                                            value="{{ $dop->order_product->id }}">
                                                        <input type="hidden" name="datas[{{ $key }}][dop_id]"
                                                            value="{{ $dop->id }}">
                                                        <div class="form-group">
                                                            <select name="datas[{{ $key }}][pharmacy_id]"
                                                                class="form-control {{ $errors->has('datas.' . $key . '.pharmacy_id') ? ' is-invalid' : '' }}">
                                                                <option selected hidden value=" ">
                                                                    {{ __('Select Pharmacy') }}
                                                                </option>
                                                                @foreach ($pharmacies as $pharmacy)
                                                                    @php
                                                                        $area = $pharmacy->operation_area
                                                                            ? ($pharmacy->operation_sub_area
                                                                                ? '( ' .
                                                                                    $pharmacy->operation_area->name .
                                                                                    ' - '
                                                                                : '( ' .
                                                                                    $pharmacy->operation_area->name .
                                                                                    ' )')
                                                                            : '';
                                                                        $sub_area = $pharmacy->operation_sub_area
                                                                            ? ($pharmacy->operation_area
                                                                                ? $pharmacy->operation_sub_area->name .
                                                                                    ' )'
                                                                                : '( ' .
                                                                                    $pharmacy->operation_sub_area
                                                                                        ->name .
                                                                                    ' )')
                                                                            : '';
                                                                    @endphp
                                                                    <option
                                                                        @if (
                                                                            (isset($do->odps) && $do->odps[$key]->pharmacy_id == $pharmacy->id) ||
                                                                                old('datas.' . $key . '.pharmacy_id') == $pharmacy->id) selected @endif
                                                                        value="{{ $pharmacy->id }}"
                                                                        data-location="[{{ optional($pharmacy->address)->longitude }}, {{ optional($pharmacy->address)->latitude }}]">
                                                                        {{ $pharmacy->name . $area . $sub_area }}</option>
                                                                @endforeach
                                                            </select>
                                                            @include('alerts.feedback', [
                                                                'field' => 'datas.' . $key . '.pharmacy_id',
                                                            ])
                                                        </div>
                                                    @else
                                                        @php
                                                            $area = $do->odps[$key]->pharmacy->operation_area
                                                                ? ($do->odps[$key]->pharmacy->operation_sub_area
                                                                    ? '( ' .
                                                                        $do->odps[$key]->pharmacy->operation_area
                                                                            ->name .
                                                                        ' - '
                                                                    : '( ' .
                                                                        $do->odps[$key]->pharmacy->operation_area
                                                                            ->name .
                                                                        ' )')
                                                                : '';
                                                            $sub_area = $do->odps[$key]->pharmacy->operation_sub_area
                                                                ? ($do->odps[$key]->pharmacy->operation_area
                                                                    ? $do->odps[$key]->pharmacy->operation_sub_area
                                                                            ->name . ' )'
                                                                    : '( ' .
                                                                        $do->odps[$key]->pharmacy->operation_sub_area
                                                                            ->name .
                                                                        ' )')
                                                                : '';
                                                        @endphp
                                                        <input type="text" class="form-control" disabled
                                                            value="{{ $do->odps[$key]->pharmacy->name . $area . $sub_area }}">
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @if ($dop->status == 3 || $dop->status == -1)
                                        <span><strong
                                                class="text-danger">{{ __('Reason: ') }}</strong>{{ $dop->note }}</span>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                        @if ($dop->status == 3)
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
@push('js_link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('admin/js/remaining.js') }}"></script>
    <script>
        function getTravelTime() {
            const origin = [longitude1, latitude1];
            const destination = [longitude2, latitude2]; // replace with your destination coordinates
            const url =
                `https://api.mapbox.com/directions/v5/mapbox/cycling/${origin[0]},${origin[1]};${destination[0]},${destination[1]}?access_token=YOUR_MAPBOX_ACCESS_TOKEN`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const travelTime = data.routes[0].duration; // travel time in seconds
                    const travelTimeInMinutes = Math.floor(travelTime / 60); // convert to minutes
                    document.getElementById('travel-time').innerHTML = `Travel time: ${travelTimeInMinutes} min`;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endpush
