@extends('admin.layouts.master', ['pageSlug' => 'local_area_manager'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Update Local Area Manager')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', ['routeName' => 'lam_management.local_area_manager.local_area_manager_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{route('lam_management.local_area_manager.local_area_manager_edit',$lam->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>{{__('Name')}}</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{$lam->name}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                      <label>{{__('Phone')}}</label>
                      <input type="phone" name="phone" class="form-control" placeholder="Enter phone" value="{{$lam->phone}}">
                      @include('alerts.feedback', ['field' => 'phone'])
                    </div>
                    <div class="form-group {{ $errors->has('dm_id') ? ' has-danger' : '' }}">
                        <label>{{ _('District Manager') }}</label>
                        <select name="dm_id" class="form-control {{ $errors->has('dm_id') ? ' is-invalid' : '' }}">
                            @foreach ($dms as $dm)
                                <option {{($lam->dm->id == $dm->id) ? 'selected' : ''}} value="{{$dm->id}}">{{$dm->name}}</option>
                            @endforeach
                        </select>
                        @include('alerts.feedback', ['field' => 'dm_id'])
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
