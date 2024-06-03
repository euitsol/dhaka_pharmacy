@extends('pharmacy.layouts.master', ['pageSlug' => $status.'_orders'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __(ucwords(strtolower((str_replace('-', ' ', $status))))." Order List") }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                @if($rider && $status != 'dispute')
                                    <th>{{ __('Rider') }}</th>
                                @endif
                                <th>{{ __('Total Product') }}</th>
                                <th>{{ __('Total Price') }}</th>
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Distribution Type') }}</th>
                                @if($prep_time)
                                    <th>{{ __('Preparetion Time') }}</th>
                                @endif
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($dops as $dop)
                        
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $dop->od->order->order_id }} </td>
                                    @if($rider && $status != 'dispute')
                                        <td> 
                                            @if($dop->odr)
                                                <span class="badge badge-info">{{$dop->odr->rider->name}}</span> 
                                            @else 
                                                <span class="badge badge-warning">{{__("Not Assign Yet")}}</span> 
                                            @endif 
                                        </td>
                                    @endif
                                    <td> {{ count($dop) }} </td>
                                    <td> {{ number_format(ceil($dop->sum('price'))) }} </td>
                                    <td> {{ $dop->od->paymentType() }} </td>
                                    <td> {{ $dop->od->distributionType() }} </td>
                                    @if($prep_time)
                                    <td> <span class="countdown ms-2" data-seconds="{{prepTotalSeconds($dop->od->created_at, $dop->od->prep_time)}}"></span></td>
                                    @endif
                                    <td>
                                        <span class="{{ $dop->statusBg }}">{{ __(ucwords(strtolower(str_replace('-', ' ', $dop->statusTitle))))  }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{route('pharmacy.order_management.details',['do_id'=>encrypt($dop->od->id), 'status'=>$status])}}">{{ __("View Details") }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>


@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7]])
@push('js')
<script>

        $(document).ready(function(){
            $(".countdown").each(function() {
                var countdown = $(this); // Current countdown element

                // Parse the duration from the data attribute
                var durationInSeconds = parseInt(countdown.data('seconds'));
                var countDownDate = new Date(Date.now() + durationInSeconds * 1000).getTime();

                // Update the countdown every 1 second
                var x = setInterval(function() {
                    // Get the current date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;

                    // Calculate remaining time
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Display the result
                    countdown.html(minutes + "m " + seconds + "s ");

                    // If the countdown is over, display a message
                    if (distance < 0) {
                        clearInterval(x);
                        countdown.html("EXPIRED");
                    }
                }, 1000);
            });
            
        });

</script>
@endpush

