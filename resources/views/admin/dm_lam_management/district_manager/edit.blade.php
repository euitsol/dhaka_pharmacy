@extends('admin.layouts.master', ['pageSlug' => 'district_manager'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Update District Manager')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', ['routeName' => 'dmlam.district_manager.district_manager_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{route('dmlam.district_manager.district_manager_edit',$dm->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>{{__('Name')}}</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{$dm->name}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                      <label>{{__('Phone')}}</label>
                      <input type="text" name="phone" class="form-control" placeholder="Enter phone" value="{{$dm->phone}}">
                      @include('alerts.feedback', ['field' => 'phone'])
                    </div>
                    <div class="form-group">
                      <label>{{__('Password')}}</label>
                      <input type="password" name="password" class="form-control" placeholder="Enter new password">
                      @include('alerts.feedback', ['field' => 'password'])
                    </div>
                    <div class="form-group">
                      <label>{{__('Confirm Password')}}</label>
                      <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                  </form>
                </div>
              </div>
        </div>
        @include('admin.partials.documentation',['document'=>$document])
    </div>
@endsection
