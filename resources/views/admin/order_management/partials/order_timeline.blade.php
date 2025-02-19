<div class="card">
    <div class="card-header">
        <div class="row justify-content-between mb-4">
            <div class="col-auto">
                <h4 class="color-1 mb-0">{{ __('Order Timeline') }}</h4>
            </div>
            <div class="col-auto"> </div>
        </div>
    </div>
    <div class="card-body order_timeline">
        @if($timelines->count() > 0)
            <div class="timeline">
                @if($order_status == -1 || $order_status == -2)
                    @foreach($timelines as $timeline)
                        @if($timeline->status == -1 || $timeline->status == -2)
                            <div class="timeline-item d-flex mb-4">
                                <div class="timeline-icon pending">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="timeline-content">
                                    <h3 class="fs-5 fw-bold">{{ $timeline->status_string }}</h3>
                                    @if($timeline->actual_completion_time != null)
                                        <p class="text-success mb-1">Completed: {{ $timeline->actual_completion_time }}</p>
                                    @endif
                                    @if($timeline->expected_completion_time != null)
                                        <p class="text-muted mb-1">Expected: {{ $timeline->expected_completion_time }}</p>
                                    @endif
                                    @if($timeline->created_by != null)
                                        <p class="text-muted mb-0">By: {{ $timeline->created_by }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    @foreach($timelines as $timeline)
                        @if($timeline->status != -1 && $timeline->status != -2)
                            <div class="timeline-item d-flex mb-4">
                                @if($timeline->actual_completion_time != null)
                                    <div class="timeline-icon completed">
                                        <i class="fas fa-check"></i>
                                    </div>
                                @else
                                    <div class="timeline-icon pending">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                @endif
                                <div class="timeline-content">
                                    <h3 class="fs-5 fw-bold">{{ $timeline->status_string }}</h3>
                                    @if($timeline->actual_completion_time != null)
                                        <p class="text-success mb-1">Completed: {{ $timeline->actual_completion_time }}</p>
                                    @endif
                                    @if($timeline->expected_completion_time != null)
                                        <p class="text-muted mb-1">Expected: {{ $timeline->expected_completion_time }}</p>
                                    @endif
                                    @if($timeline->created_by != null)
                                        <p class="text-muted mb-0">By: {{ $timeline->created_by }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        @else
            <div class="text-center">
                <h5 class="color-1 mb-0">{{ __('No Timeline Found') }}</h5>
            </div>
        @endif
    </div>
</div>
