<div class="col-md-12" id="location_map" style="display: none">
    <div class="card card-user mt-3 mb-0">
        <div class="card-header p-0">
            <div class="map w-100" id="map" data-lat="{{ optional($pharmacy->address)->latitude }}"
                data-lng="{{ optional($pharmacy->address)->longitude }}"></div>
        </div>
        <div class="card-body contact_info" style="border: 0;
                    border-radius: 0 0 5px 5px;">
            <ul class="m-0 list-unstyled d-flex justify-content-between">
                <li>
                    <i class="fa-solid fa-mountain-city mr-2"></i>
                    <span class="title">{{ __('City : ') }}</span>
                    <span class="content">{{ $pharmacy->address ? $pharmacy->address->city : 'null' }}</span>
                </li>
                <li>
                    <i class="fa-solid fa-road mr-2"></i>
                    <span class="title">{{ __('Street Name : ') }}</span>
                    <span class="content">{{ $pharmacy->address ? $pharmacy->address->street_address : 'null' }}</span>
                </li>
                <li>
                    <i class="fa-solid fa-door-open mr-2"></i>
                    <span class="title">{{ __('Apartment Name : ') }}</span>
                    <span class="content">{{ $pharmacy->address ? $pharmacy->address->apartment : 'null' }}</span>
                </li>
                <li>
                    <i class="fa-solid fa-stairs mr-2"></i>
                    <span class="title">{{ __('Floor : ') }}</span>
                    <span class="content">{{ $pharmacy->address ? $pharmacy->address->floor : 'null' }}</span>
                </li>
            </ul>
            <ul class="m-0 list-unstyled">
                <li class="text-justify">
                    <i class="fa-solid fa-hand-point-right mr-2"></i>
                    <span class="title">{{ __('Delivery Man Instruction : ') }}</span>
                    <span class="content">{!! $pharmacy->address ? $pharmacy->address->delivery_instruction : 'null' !!}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
