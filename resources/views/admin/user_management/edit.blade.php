@extends('admin.layouts.master', ['pageSlug' => 'users'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Edit User')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', ['routeName' => 'um.user.user_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{route('um.user.user_edit',$user->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{$user->name}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{$user->email}}">
                      @include('alerts.feedback', ['field' => 'email'])
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
                    <button type="submit" class="btn btn-primary">Update</button>
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
                      <p><b>User Name:</b> This field is required. It is a text field with character limit of 6-255 characters </p>

                      <p><b>Email:</b> This field is required and unique. It is a email field with a maximum character limit of 255. The entered value must follow the standard email format (e.g., user@example.com).</p>

                      <p><b>Password:</b> This field is nullable. It is a password field. Password strength should meet the specified criteria (e.g., include uppercase and lowercase letters, numbers, and special characters). The entered password should be a minimum of 6 characters.</p>

                      <p><b>Confirm Password:</b> This field is required when you fill up the 'Password' field. It is a password field. It should match the entered password in the 'Password' field.</p>
                      
                      <p><b>Role:</b> This field is required. This is an option field. It represents the user's role.</p>
                  </div>
              </div>
          </div>
      </div>
    </div>
@endsection
