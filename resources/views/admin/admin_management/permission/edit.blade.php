@extends('admin.layouts.master', ['pageSlug' => 'permission'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Update Permission')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', ['routeName' => 'am.permission.permission_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('am.permission.permission_edit',$permission->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>{{_('Name')}}</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter permission name" value="{{$permission->name}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                      <label>{{_('Prefix')}}</label>
                      <input type="text" name="prefix" class="form-control" placeholder="Enter permission prefix" value="{{$permission->prefix}}">
                      @include('alerts.feedback', ['field' => 'prefix'])
                    </div>

                    <button type="submit" class="btn btn-primary">{{_('Update')}}</button>
                  </form>
                </div>
              </div>
        </div>
        <div class="col-md-4">
          <div class="card">
              <div class="card-body">
                  <p class="card-header">
                      <b>User</b>
                  </p>
                  <div class="card-body">
                      <p><b>User Name:</b> This field is required. It is a text field with character limit of 6-255
                          characters </p>

                      <p><b>Email:</b> This field is required and unique. It is a email field with a maximum character
                          limit of 255. The entered value must follow the standard email format (e.g., user@example.com).
                      </p>

                      <p><b>Password:</b> This field is required. It is a password field. Password strength should meet
                          the specified criteria (e.g., include uppercase and lowercase letters, numbers, and special
                          characters). The entered password should be a minimum of 6 characters.</p>

                      <p><b>Confirm Password:</b> This field is required. It is a password field. It should match the
                          entered password in the "Password" field.</p>

                      <p><b>Role:</b> This field is required. This is an option field. It represents the user's role.</p>
                  </div>
              </div>
          </div>
      </div>
    </div>
@endsection
