<!-- Delivery Information Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white py-3" id="deliveryInfoHeader">
        <h5 class="mb-0">
            <div class="cursor-pointer text-white text-decoration-none d-flex align-items-center w-100 justify-content-between" data-toggle="collapse" data-target="#deliveryInfoContent" aria-expanded="false" aria-controls="deliveryInfoContent">
                <span class="d-flex align-items-center">
                    <i class="fas fa-truck me-2"></i>
                    Delivery Information
                </span>
                <i class="fas fa-chevron-down transition-rotate"></i>
            </div>
        </h5>
    </div>

    <div id="deliveryInfoContent" class="collapse" aria-labelledby="deliveryInfoHeader">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="row g-4 mt-2">
                        <div class="col-md-6 m-auto">
                            <div class="info-section p-3 bg-light rounded">
                                <a href="{{ route('hub.order.print', encrypt($oh->order_id)) }}" target="_blank" class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-print"></i> Print Invoice
                                </a>

                                <a id="refreshBtn" href="{{ route('hub.order.delivery_refresh', encrypt($delivery_info->id)) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </a>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row g-4">
                        <div class="col-md-6 mt-4">
                            <div class="info-section p-3 bg-light rounded">
                                <h6 class="font-weight-bold border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Basic Information
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><strong class="text-primary">Invoice:</strong> <span class="ms-2">{{ $delivery_info->invoice ?? 'N/A' }}</span></li>
                                    <li class="mb-2"><strong class="text-primary">Type:</strong> <span class="ms-2">{{ $delivery_info->type ?? 'N/A' }}</span></li>
                                    <li class="mb-2"><strong class="text-primary">Order ID:</strong> <span class="ms-2">{{ $delivery_info->order_id ?? 'N/A' }}</span></li>
                                    <li class="mb-2">
                                        <strong class="text-primary">Status Code:</strong>
                                        <span class="ms-2 badge {{ $delivery_info->status_code == 'in_review' ? 'bg-warning' : 'bg-info' }} text-white">
                                            {{ ucfirst($delivery_info->status_code ?? 'N/A') }}
                                        </span>
                                    </li>
                                    <li class="mb-2"><strong class="text-primary">Receiver ID:</strong> <span class="ms-2">{{ $delivery_info->receiver_id ?? 'N/A' }}</span></li>
                                    <li class="mb-2"><strong class="text-primary">Receiver Type:</strong> <span class="ms-2">{{ $delivery_info->receiver_type ?? 'N/A' }}</span></li>
                                    <li class="mb-2"><strong class="text-primary">Address ID:</strong> <span class="ms-2">{{ $delivery_info->address_id ?? 'N/A' }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if($delivery_info->payload)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="info-section p-3 bg-light rounded">
                                <h6 class="font-weight-bold border-bottom pb-2 mb-3">
                                    <i class="fas fa-box me-2"></i>Payload Information
                                </h6>
                                @php
                                    $payloadData = json_decode($delivery_info->payload, true);
                                @endphp
                                @if(is_array($payloadData))
                                    <ul class="list-unstyled mb-0">
                                        @foreach($payloadData as $key => $value)
                                            <li class="mb-2">
                                                <strong class="text-primary">{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                                <span class="ms-2">
                                                    @if(is_array($value))
                                                        @include('partials.dynamic_json', ['data' => $value])
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="mb-0">{{ $delivery_info->payload }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-12">
                    @if($delivery_info->response)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="info-section p-3 bg-light rounded">
                                <h6 class="font-weight-bold border-bottom pb-2 mb-3">
                                    <i class="fas fa-reply me-2"></i>Response Information
                                </h6>
                                @php
                                    $responseData = json_decode($delivery_info->response, true);
                                @endphp
                                @if(is_array($responseData))
                                    <ul class="list-unstyled mb-0">
                                        @foreach($responseData as $key => $value)
                                            <li class="mb-2">
                                                <strong class="text-primary">{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                                <span class="ms-2">
                                                    @if(is_array($value))
                                                        @include('partials.dynamic_json', ['data' => $value])
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="mb-0">{{ $delivery_info->response }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const button = document.querySelector('[data-target="#deliveryInfoContent"]');
    if (button) {
        button.addEventListener('click', function() {
            this.classList.toggle('collapsed');
        });
    }
});
</script>
