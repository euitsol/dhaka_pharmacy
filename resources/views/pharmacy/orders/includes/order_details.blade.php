<div class="card order_details_card">
    <div class="card-body">
        <table class="table table-striped datatable">
            <tbody>
                <tr>
                    <td class="fw-bold">{{ __('Order ID') }} </td>
                    <td>:</td>
                    <td>{{ $do->order->order_id }}
                        {{-- <sup><span
                                class="{{ $do->odps->first()->pStatusBg() }}">{{ slugToTitle($do->odps->first()->pStatusTitle()) }}</span></sup> --}}
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Payment Type') }}</td>
                    <td>:</td>
                    <td>{{ $do->paymentType() }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Distribution Type') }}</td>
                    <td>:</td>
                    <td>{{ $do->distributionType() }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Total Product') }}</td>
                    <td>:</td>
                    <td><span class="badge badge-info">{{ $do->odps->count() }}</span></td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Payable Amount') }}</td>
                    <td>:</td>
                    <td>
                        {!! get_taka_icon() !!}
                        @if (empty(
                                $do->odps->where('status', '!=', -1)->pluck('open_amount')->first()
                            ))
                            {{ number_format(ceil($do->totalPharmacyAmount)) }}
                        @else
                            {{ number_format(ceil($do->odps->where('status', '!=', -1)->sum('open_amount'))) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="align-top">{{ __('Note') }}</td>
                    <td class="align-top">:</td>
                    <th class="text-justify">
                        {!! $do->note !!}
                        </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
