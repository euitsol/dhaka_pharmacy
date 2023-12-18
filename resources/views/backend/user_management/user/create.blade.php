@extends('backend.layouts.master', ['pageSlug' => 'user'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Create User')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('backend.partial.button', ['routeName' => 'um.user.user_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('um.user.user_create')}}">
                    @csrf
                    <div class="form-group">

                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{old('name')}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{old('email')}}">
                      @include('alerts.feedback', ['field' => 'email'])
                    </div>
                    <div class="form-group {{ $errors->has('role') ? ' has-danger' : '' }}">
                        <label>{{ _('Role') }}</label>
                        <select name="role" class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}">
                            <option selected hidden>{{_('Select Role')}}</option>
                            @foreach ($roles as $role)
                                <option {{(old('role') == $role->id) ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @include('alerts.feedback', ['field' => 'role'])
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="password" class="form-control" placeholder="Enter new password">
                      @include('alerts.feedback', ['field' => 'password'])
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection
