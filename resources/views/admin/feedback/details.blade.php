@extends('admin.layouts.master', ['pageSlug' => 'feedback'])
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
                            <h4 class="card-title">{{ __('Feedback Details') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'feedback.fdk_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>{{ __('Submitted By') }}</th>
                                <th>:</th>
                                <td>{{ $feedback->creater->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Subject') }}</th>
                                <th>:</th>
                                <td>{{ $feedback->subject }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Description') }}</th>
                                <th>:</th>
                                <td>{!! $feedback->description !!}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Opened By') }}</th>
                                <th>:</th>
                                <td>{{ $feedback->openedBy->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Submitted Date') }}</th>
                                <th>:</th>
                                <td>{{ timeFormate($feedback->created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @php
                        $imageHtml = '';
                        $videoHtml = '';
                        $pdfHtml = '';
                        $otherHtml = '';

                        foreach (json_decode($feedback->files, true) as $file) {
                            $fileType = getFileType($file);
                            if ($fileType == 'image') {
                                $imageHtml .=
                                    '<div id="lightbox" class="lightbox">
                                        <div class="lightbox-content">
                                            <img src="' .
                                    storage_url($file) .
                                    '" class="lightbox_image" style="height: 300px; width:350px">
                                        </div>
                                        <div class="close_button fa-beat">X</div>
                                    </div>';
                            } elseif ($fileType == 'video') {
                                $videoHtml .=
                                    '<div class="video" style="height: 300px; width:350px">
                                        <video controls width="100%" height="100%" style="object-fit: cover; border-radius:5px;">
                                            <source src="' .
                                    storage_url($file) .
                                    '">
                                        </video>
                                    </div>';
                            } elseif ($fileType == 'pdf') {
                                $pdfHtml .=
                                    '<div class="pdf">
                                        <iframe src="' .
                                    pdf_storage_url($file) .
                                    '" width="350px" height="300px"></iframe>
                                    </div>';
                            } else {
                                $otherHtml .=
                                    '<a href="' .
                                    route('feedback.download.fdk_details', encrypt($file)) .
                                    '" title="' .
                                    ucfirst(str_replace('-', ' ', basename($file))) .
                                    '" class="btn btn-info me-2 text-white">
                                        <i class="fa-solid fa-download"></i>
                                    </a>';
                            }
                        }
                    @endphp

                    <div class="view-files d-flex align-items-center gap-3 flex-wrap">
                        {!! $imageHtml !!}
                        {!! $videoHtml !!}
                        {!! $pdfHtml !!}
                    </div>
                    <!-- Other Files -->
                    <div id="other-files d-flex align-items-center gap-3">
                        {!! $otherHtml !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
@endpush
