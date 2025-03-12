<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Point Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.ps_update') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="input-group" role="group">
                            <input type="text" name="point_name"
                                style="border-right: 2px solid rgba(29, 37, 59, 0.5)"
                                class="form-control{{ $errors->has('point_name') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Enter point name') }}"
                                value="{{ $point_settings['point_name'] ?? '' }}">
                            <input type="text" name="equivalent_amount"
                                class="form-control{{ $errors->has('equivalent_amount') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Enter equivalent amount (BDT)') }}"
                                value="{{ $point_settings['equivalent_amount'] ?? '' }}">
                            <input type="button" class="btn btn-secondary disabled m-0" value="BDT">
                        </div>
                        @include('alerts.feedback', ['field' => 'point_name'])
                        @include('alerts.feedback', ['field' => 'equivalent_amount'])
                    </div>
                </div>
                {{-- @if (admin()->hasPermissionTo('ps_update')) --}}
                <div class="card-footer text-end">
                    {{-- <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button> --}}
                    @include('admin.partials.button', [
                        'routeName' => 'settings.ps_update',
                        'type' => 'submit',
                    ])
                </div>
                {{-- @endif --}}
            </form>
        </div>
    </div>
    @include('admin.partials.documentation', ['document' => $document])
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">{{ __('Point Setting Histories') }}</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <table class="table table-striped datatable">
                    <thead>
                        <tr>
                            <th>{{ __('SL') }}</th>
                            <th>{{ __('BDT Equivalent') }}</th>
                            <th>{{ __('Activation Time') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Created date') }}</th>
                            <th>{{ __('Created by') }}</th>
                            <th>{{ __('Updated date') }}</th>
                            <th>{{ __('Updated by') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($point_histories as $ph)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{!! get_taka_icon() !!}{{ number_format($ph->eq_amount, 2) }}</td>
                                <td class="nowrap">{{ activatedTime($ph->created_at, $ph->updated_at) }}</td>
                                <td><span class="{{ $ph->getStatusBadgeClass() }}">{{ $ph->getStatus() }}</span></td>
                                <td>{{ timeFormate($ph->created_at) }}</td>
                                <td>{{ c_user_name($ph->created_user) }}</td>
                                <td>{{ $ph->created_at != $ph->updated_at ? timeFormate($ph->updated_at) : '' }}
                                </td>
                                <td>{{ U_user_name($ph->updated_user) }}</td>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7]])
