@extends('pharmacy.layouts.master', ['pageSlug' => $do->statusTitle() . '_orders'])
@section('title', 'Order Details')
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


        .otp-field {
            flex-direction: row;
            column-gap: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .otp-field input {
            height: 45px;
            background-color: #e9e9e9 !important;
            width: 42px;
            border-radius: 6px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 1px solid var(--bg-1);
            padding: unset !important;
        }

        .otp-field input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .otp-field input::-webkit-inner-spin-button,
        .otp-field input::-webkit-outer-spin-button {
            display: none;
        }

        .submit_button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .verify-btn {
            margin-top: 2rem;
            width: 20rem;
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
                            <h4 class="card-title">
                                {{ __('Order Details') }}
                            </h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ URL::previous() }}" class="btn btn-primary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <tbody>
                            <tr>
                                <th>{{ __('Order ID') }}</th>
                                <td>:</td>
                                <th>{{ $do->order->order_id }}</th>
                                <td>|</td>
                                @if ($do->status == 0 || $do->status == 1)
                                    <td class="fw-bold">{{ __('Preparation Time') }}</td>
                                    <td>:</td>
                                    <td>{!! remainingTime($do->pharmacy_prep_time, true) !!}</td>
                                @else
                                    <td class="fw-bold">{{ __('Prepared At') }}</td>
                                    <td>:</td>
                                    <td>{{ timeFormate($do->pharmacy_preped_at) }}</td>
                                @endif
                            </tr>
                            <tr>
                                <th>{{ __('Total Product') }}</th>
                                <td>:</td>
                                <th>{{ $do->odps->count() }}</th>
                                <td>|</td>
                                <th>{{ __('Total Price') }}</th>
                                <td>:</td>
                                <th>
                                    {!! get_taka_icon() !!}{{ number_format(ceil($do->totalPharmacyAmount)) }}
                                </th>
                            </tr>
                            <tr>
                                <th>{{ __('Payment Type') }}</th>
                                <td>:</td>
                                <th>{{ $do->paymentType() }}</th>
                                <td>|</td>
                                <th>{{ __('Distribution Type') }}</th>
                                <td>:</td>
                                <th>{{ $do->distributionType() }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Note') }}</th>
                                <td>:</td>
                                <th colspan="5">{!! $do->note !!}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @include('pharmacy.orders.includes.otp-verify')
                    <form action="{{ route('pharmacy.order_management.update', encrypt($do->id)) }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12 px-4 text-end">
                                <span class="{{ $do->statusBg() }}">{{ __(ucfirst($do->statusTitle())) }}</span>
                            </div>
                        </div>
                        @foreach ($do->odps as $key => $dop)
                            <div class="col-12 status_wrap">
                                <div class="card card-2 mb-0 mt-3">
                                    <div class="card-body">
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
                                                        <small>{{ $dop->order_product->product->pro_cat->name }} </small>
                                                    </div>
                                                    <div class="col my-auto d-flex justify-content-around"> Quantity :
                                                        {{ $dop->order_product->quantity }} &nbsp; &nbsp; Pack :
                                                        {{ $dop->order_product->unit->name ?? 'Piece' }}
                                                    </div>
                                                    <div class="col my-auto">
                                                        <h6 class="my-auto text-center">
                                                            <span>{{ __('Total Price : ') }}{!! get_taka_icon() !!}

                                                                <span
                                                                    class="">{{ number_format(ceil($dop->discounted_price)) }}
                                                                </span>
                                                                @if ($dop->discounted_price != $dop->selling_price)
                                                                    <del
                                                                        class="text-danger">{{ number_format($dop->selling_price, 2) }}</del>
                                                                @endif
                                                            </span>
                                                            @if ($dop->discount)
                                                                <sup><span class='badge badge-danger'>
                                                                        {{ $dop->discount . '% off' }}
                                                                    </span></sup>
                                                            @endif
                                                        </h6>
                                                        @if ($do->payment_type == 1 && ($dop->status == 0 || $dop->status == 1))
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    name="data[{{ $key }}][open_amount]"
                                                                    class="form-control" placeholder="Enter product price">
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if ($do->payment_type == 1 && $dop->status == 2 && $dop->open_amount > 0)
                                                        <div class="col my-auto">
                                                            <h6 class="my-auto text-center">
                                                                <span><strong>{{ __('Bit Price : ') }}</strong>{!! get_taka_icon() !!}
                                                                    {{ number_format($dop->open_amount, 2) }}</span>
                                                            </h6>
                                                        </div>
                                                    @endif
                                                    @if ($dop->status == 0 || $dop->status == 1)
                                                        <div class="col my-auto mt-3">
                                                            <div class="card mb-0">
                                                                <div class="card-body">
                                                                    <input type="hidden"
                                                                        name="data[{{ $key }}][dop_id]"
                                                                        value="{{ $dop->id }}">

                                                                    <div class="form-check form-check-radio">
                                                                        <label class="form-check-label me-2"
                                                                            for="status_{{ $key }}">
                                                                            <input class="form-check-input do_status"
                                                                                type="radio"
                                                                                name="data[{{ $key }}][status]"
                                                                                id="status_{{ $key }}"
                                                                                value="2" checked>
                                                                            {{ __('Accept') }}
                                                                            <span class="form-check-sign"></span>
                                                                        </label>
                                                                        <label class="form-check-label"
                                                                            for="status{{ $key }}">
                                                                            <input class="form-check-input do_status"
                                                                                type="radio"
                                                                                name="data[{{ $key }}][status]"
                                                                                id="status{{ $key }}"
                                                                                value="3">
                                                                            {{ __('Dispute') }}
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
                                @if ($dop->status == 0 || $dop->status == 1)
                                    <div class="form-group status_note mt-3" style="display: none">
                                        <textarea name="data[{{ $key }}][note]" class="form-control" placeholder="Enter dispute reason"></textarea>
                                    </div>
                                    @include('alerts.feedback', ['field' => 'data.' . $key . '.note'])
                                @elseif($dop->status == 3 || $dop->status == -1)
                                    <span><strong
                                            class="text-danger">{{ __('Reason: ') }}</strong>{{ $dop->note }}</span>
                                @endif

                            </div>
                        @endforeach
                        {{ $do->getPharmacyStatus(pharmacy()->id) }}
                        @if ($do->getPharmacyStatus(pharmacy()->id) == 0 || $do->getPharmacyStatus(pharmacy()->id) == 1)
                            <div class="col-12 text-end mt-2">
                                <input type="submit" value="Confirm" class="btn btn-success">
                            </div>
                        @endif
                    </form>

                </div>
            </div>
        </div>
    </div>
    @include('pharmacy.orders.includes.otp-modal')
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('.do_status').on('change', function() {
                if ($(this).val() == 3) {
                    $(this).closest('.status_wrap').find('.status_note').show();
                } else {
                    $(this).closest('.status_wrap').find('.status_note').hide();
                    $(this).closest('.status_wrap').find('.status_note .form-control').val('');
                }
            });


            $(document).ready(function() {
                const inputs = $(".otp-field > input");
                const button = $(".verify-btn");

                inputs.eq(0).focus();
                button.prop("disabled", true);

                inputs.eq(0).on("paste", function(event) {
                    event.preventDefault();

                    const pastedValue = (event.originalEvent.clipboardData || window.clipboardData)
                        .getData(
                            "text");
                    const otpLength = inputs.length;

                    for (let i = 0; i < otpLength; i++) {
                        if (i < pastedValue.length) {
                            inputs.eq(i).val(pastedValue[i]);
                            inputs.eq(i).removeAttr("disabled");
                            inputs.eq(i).focus();
                        } else {
                            inputs.eq(i).val(""); // Clear any remaining inputs
                            inputs.eq(i).focus();
                        }
                    }
                });

                inputs.each(function(index1) {
                    $(this).on("keyup", function(e) {
                        const currentInput = $(this);
                        const nextInput = currentInput.next();
                        const prevInput = currentInput.prev();

                        if (currentInput.val().length > 1) {
                            currentInput.val("");
                            return;
                        }

                        if (nextInput && nextInput.attr("disabled") && currentInput
                            .val() !== "") {
                            nextInput.removeAttr("disabled");
                            nextInput.focus();
                        }

                        if (e.key === "Backspace") {
                            inputs.each(function(index2) {
                                if (index1 <= index2 && prevInput) {
                                    $(this).attr("disabled", true);
                                    $(this).val("");
                                    prevInput.focus();
                                }
                            });
                        }

                        button.prop("disabled", true);

                        const inputsNo = inputs.length;
                        if (!inputs.eq(inputsNo - 1).prop("disabled") && inputs.eq(
                                inputsNo - 1)
                            .val() !== "") {
                            button.prop("disabled", false);
                            return;
                        }
                    });
                });
            });
        });
    </script>
@endpush
@push('js_link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('pharmacy/js/remaining.js') }}"></script>
@endpush
