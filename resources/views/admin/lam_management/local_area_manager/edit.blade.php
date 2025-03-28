@extends('admin.layouts.master', ['pageSlug' => 'local_area_manager'])
@section('title', 'Edit Local Area Manager')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Local Area Manager') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'lam_management.local_area_manager.local_area_manager_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST"
                    action="{{ route('lam_management.local_area_manager.local_area_manager_edit', $lam->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name"
                                value="{{ $lam->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input type="phone" name="phone" class="form-control" placeholder="Enter phone"
                                value="{{ $lam->phone }}">
                            @include('alerts.feedback', ['field' => 'phone'])
                        </div>
                        <div class="form-group {{ $errors->has('dm_id') ? ' has-danger' : '' }}">
                            <label>{{ __('District Manager') }}</label>
                            <select name="dm_id" class="form-control dm {{ $errors->has('dm_id') ? ' is-invalid' : '' }}">
                                @foreach ($dms as $dm)
                                    <option {{ $lam->dm->id == $dm->id ? 'selected' : '' }} value="{{ $dm->id }}">
                                        {{ $dm->name }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'dm_id'])
                        </div>

                        <div class="form-group">
                            <label>{{ __('District Manager Area') }}</label>
                            <input type="text" value="{{ $lam->dm->operation_area->name }}" class="form-control dm_area"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Local Area Manager Area') }}</label>
                            <select name="osa_id"
                                class="form-control lam_area {{ $errors->has('osa_id') ? ' is-invalid' : '' }}">
                                @foreach ($lam->dm->operation_area->operation_sub_areas as $area)
                                    <option {{ $lam->osa_id == $area->id ? 'selected' : '' }} value="{{ $area->id }}">
                                        {{ $area->name }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'osa_id'])
                        </div>


                        <div class="form-group">
                            <label>{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm password">
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
<script>
    $(document).ready(function() {
        $('.dm').on('change', function() {
            let dm_area = $('.dm_area');
            let lam_area = $('.lam_area');
            let dm_id = $(this).val();

            dm_area.prop('disabled', true);

            let url = (
                "{{ route('lam_management.local_area_manager.operation_area.local_area_manager_list', ['dm_id']) }}"
            );
            let _url = url.replace('dm_id', dm_id);

            $.ajax({
                url: _url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    lam_area.prop('disabled', false);
                    dm_area.val(data.dm.operation_area.name);
                    var result = '';
                    data.operation_sub_areas.forEach(function(area) {
                        result +=
                            `<option value="${area.id}">${area.name}</option>`;
                    });
                    lam_area.html(result);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching local area manager data:', error);
                }
            });
        });
    });
</script>
