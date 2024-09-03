<div class="card order_details_card">
    <div class="card-body">
        <table class="table table-striped datatable">
            <tbody>
                <tr>
                    <td class="fw-bold">{{ __('Order ID') }} </td>
                    <td>:</td>
                    <td>{{ $do->order->order_id }}
                        <sup><span
                                class="{{ $do->odps->first()->pStatusBg() }}">{{ slugToTitle($do->odps->first()->pStatusTitle()) }}</span></sup>
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
                        {!! get_taka_icon() !!}{{ number_format(ceil($do->totalPharmacyAmount)) }}
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
