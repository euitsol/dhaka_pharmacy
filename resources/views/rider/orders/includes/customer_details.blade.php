<div class="col-md-6">
    <div class="card">
        <div class="card-header ">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="card-title">{{ __('Customer Details') }}</h4>
                </div>
                <div>
                    <a href="tel:{{ optional($dor->od->order->customer)->phone }}" class="btn btn-success text-white">
                        Call </a>
                </div>
                <div>
                    <a href="javascript:void(0)" class="btn btn-info text-white customer-direction-btn"
                        data-longitude="{{ optional($dor->od->order->address)->longitude }}"
                        data-latitude="{{ optional($dor->od->order->address)->latitude }}">
                        Direction </a>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="customer-location-map" id="cmap"
                data-longitude="{{ optional($dor->od->order->address)->longitude }}"
                data-latitude="{{ optional($dor->od->order->address)->latitude }}">
            </div>
        </div>
    </div>
</div>
