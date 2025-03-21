@extends('local_area_manager.layouts.master', ['pageSlug' => 'operational_area'])
@section('title', 'Operation Area List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Operation Area List') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table bordered datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Operation Areas') }}</th>
                                <th>{{ __('Operation Sub Areas') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operational_areas as $key => $area)
                                @forelse ($area->operation_sub_areas as $sub_area)
                                    <tr>
                                        @if ($loop->first)
                                            <td rowspan="{{ count($area->operation_sub_areas) }}">{{ ++$key }}</td>
                                            <td rowspan="{{ count($area->operation_sub_areas) }}">{{ $area->name }}</td>
                                        @endif
                                        <td>{{ $sub_area->name }}</td>
                                        <td>
                                            <span class="{{ $sub_area->getMultiStatusClass() }}">
                                                {{ $sub_area->status == 1 ? __('Operational') : ($sub_area->status == 0 ? __('Pending') : __('Not Operational')) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $area->name }}</td>
                                        <td>{{ __('empty') }}</td>
                                        <td>{{ __('empty') }}</td>
                                    </tr>
                                @endforelse
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
