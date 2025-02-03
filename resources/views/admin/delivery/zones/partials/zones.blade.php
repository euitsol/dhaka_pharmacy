<div class="accordion" id="accordionZones">
    @foreach($zones as $zone)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading-{{ $zone->id }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $zone->id }}"  aria-controls="collapse-{{ $zone->id }}">
                    {{ $zone->name }}
                </button>
            </h2>
            <div id="collapse-{{ $zone->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $zone->id }}" data-bs-parent="#accordionZones">
                <div class="accordion-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Title</th>
                            <td>{{ $zone->name }}</td>
                        </tr>
                        <tr>
                            <th>Delivery Charge</th>
                            <td>{{ number_format($zone->charge) }} {!! get_taka_icon() !!}</td>
                        </tr>
                        <tr>
                            <th>Delivery Time (Hours)</th>
                            <td>{{ $zone->delivery_time_hours }} hours</td>
                        </tr>
                        <tr>
                            <th>Express Enabled</th>
                            <td>{{  $zone->allows_express ? 'Yes' : 'No' }}</td>
                        </tr>
                        @if ($zone->allows_express)
                            <tr>
                                <th>Express Delivery Charge</th>
                                <td>{{ number_format($zone->express_charge) }} {!! get_taka_icon() !!}</td>
                            </tr>
                            <tr>
                                <th>Express Delivery Time (Hours)</th>
                                <td>{{ $zone->express_delivery_time_hours }} hours</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Cities</th>
                            <td>
                                @foreach ($zone->cities as $city)
                                    {{ $city->city_name }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
