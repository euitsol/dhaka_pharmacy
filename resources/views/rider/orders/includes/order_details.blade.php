<div class="card order_details_card">
    <div class="card-body">
        <table class="table table-striped datatable">
            <tbody>
                <tr>
                    <td class="fw-bold">{{ __('Order ID') }} </td>
                    <td>:</td>
                    <td>{{ $dor->od->order->order_id }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Status') }} </td>
                    <td>:</td>
                    <td><span class="{{ $dor->statusBg() }}">{{ slugToTitle($dor->statusTitle()) }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Priority') }}</td>
                    <td>:</td>
                    <td>{{ $dor->priority() }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Total Pharmacies') }}</td>
                    <td>:</td>
                    <td><span
                            class="badge badge-info">{{ $dor->od->odps->where('status', '!=', '-1')->unique('pharmacy_id')->count() }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Price') }}</td>
                    <td>:</td>
                    <td>
                        {!! get_taka_icon() !!}{{ number_format(ceil($dor->od->order->totalDiscountPrice + $dor->od->order->delivery_fee)) }}
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold align-top">{{ __('Instraction') }}</td>
                    <td class="align-top">:</td>
                    <td class="text-justify">
                        {!! $dor->instraction !!}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
