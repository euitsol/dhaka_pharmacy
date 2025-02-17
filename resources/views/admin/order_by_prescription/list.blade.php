@extends('admin.layouts.master', ['pageSlug' => "ubp_$status"])
@section('title', 'Submitted Prescription List')
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Submitted Prescription List') }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <span class="">{{ slugToTitle($status) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Prescription ID') }}</th>
                                <th>{{ __('Prescription Images') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Submitted at') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_prescriptions as $order_prescription)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $order_prescription->id}}</td>
                                    <td class="d-flex align-items-center">
                                        @if (optional($order_prescription->prescription)->images)
                                            @foreach ($order_prescription->prescription->images as $image)
                                                <div id="lightbox" class="lightbox mr-2">
                                                    <div class="lightbox-content">
                                                        <img src="{{ storage_url($image->path) }}" class="lightbox_image">
                                                    </div>
                                                    <div class="close_button fa-beat">X</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td><span class=" badge {{ $order_prescription->statusBg() }}">{{ $order_prescription->status_string }}</span></td>
                                    <td>{{ timeFormate($order_prescription->created_at) }}</td>
                                    <td>
                                            @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'obp.obp_details',
                                                        'params' => [encrypt($order_prescription->id)],
                                                        'label' => 'Details',
                                                    ],
                                                ],
                                            ])
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4]])
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
@endpush
