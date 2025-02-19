@extends('admin.layouts.master', ['pageSlug' => 'hub_staff'])
@section('title', 'Edit Hub Staff')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Hub Staff') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'hm.hub_staff.hub_staff_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('hm.hub_staff.hub_staff_edit', $hub_staff->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="hub">{{ __('Hub') }}</label>
                            <select name="hub" id="hub"
                                class="form-control {{ $errors->has('hub') ? ' is-invalid' : '' }}">
                                <option selected hidden value=" ">{{ __('Select Hub') }}</option>
                                @foreach ($hubs as $hub)
                                    <option {{ $hub_staff->hub_id == $hub->id ? 'selected' : '' }}
                                        value="{{ $hub->id }}">
                                        {{ $hub->name }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'hub'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name"
                                class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                placeholder="Enter name" value="{{ $hub_staff->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input type="email" name="email"
                                class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                placeholder="Enter email" value="{{ $hub_staff->email }}">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>

                        <div class="form-group">
                            <label>{{ __('Password') }}</label>
                            <input type="password" name="password"
                                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                placeholder="Enter new password">
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
