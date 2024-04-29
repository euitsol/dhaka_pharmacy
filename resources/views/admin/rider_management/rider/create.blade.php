@extends('admin.layouts.master', ['pageSlug' => 'rider'])
@section('title', 'Create Rider')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Rider') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'rider_management.rider.rider_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('rider_management.rider.rider_create') }}">
                        @csrf
                        <div class="form-group">

                            <label>{{__('Name')}}</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name"
                                value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{__('Phone')}}</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone"
                                value="{{ old('phone') }}">
                            @include('alerts.feedback', ['field' => 'phone'])
                        </div>
                        <div class="form-group {{ $errors->has('oa_id') ? ' has-danger' : '' }}">
                            <label>{{ __('Operation Area') }}</label>
                            <select name="oa_id" class="form-control oa {{ $errors->has('oa_id') ? ' is-invalid' : '' }}">
                                <option selected hidden>{{ __('Select Operation Area') }}</option>
                                @foreach ($operational_areas as $oa)
                                    <option {{ old('oa_id') == $oa->id ? 'selected' : '' }} value="{{ $oa->id }}">
                                        {{ $oa->name }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'oa_id'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Operation Sub Area') }}</label>
                            <select name="osa_id" class="form-control osa {{ $errors->has('osa_id') ? ' is-invalid' : '' }}" disabled>
                                <option selected hidden>{{ __('Select Operation Sub Area') }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'osa_id'])
                        </div>
                        <div class="form-group">
                            <label>{{__('Password')}}</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{__('Confirm Password')}}</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm password">
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation',['document'=>$document])
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('.oa').on('change', function() {
            let oa_id = $(this).val();
            let osa = $('.osa');
            osa.prop('disabled',true);

            let url = ("{{ route('rider_management.rider.operation_sub_area.rider_list', ['oa_id']) }}");
            let _url = url.replace('oa_id', oa_id);
            
            $.ajax({
                url: _url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    osa.prop('disabled',false);
                    var result = '';
                    data.operation_area.operation_sub_areas.forEach(function(area) {
                        result += `<option value="${area.id}">${area.name}</option>`;
                    });
                    osa.html(result);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching local area manager data:', error);
                }
            });
        });
    });
</script>
@endpush
