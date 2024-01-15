@extends('admin.layouts.master', ['pageSlug' => 'admin'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="{{$document ? 'col-md-8' : 'col-md-12'}} ">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Admin') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'am.admin.admin_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('am.admin.admin_create') }}">
                        @csrf
                        <div class="form-group">

                            <label>{{__('Name')}}</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name"
                                value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{__('Email')}}</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email"
                                value="{{ old('email') }}">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>
                        <div class="form-group {{ $errors->has('role') ? ' has-danger' : '' }}">
                            <label>{{ __('Role') }}</label>
                            <select name="role" class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}">
                                <option selected hidden>{{ __('Select Role') }}</option>
                                @foreach ($roles as $role)
                                    <option {{ old('role') == $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'role'])
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
        @if($document)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p class="card-header">
                            <b>{{ ucfirst($document->module_key)}}</b>
                        </p>
                        <div class="card-body">
                            {{$document->documentation}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
