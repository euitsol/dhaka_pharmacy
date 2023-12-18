@extends('backend.layouts.master', ['pageSlug' => 'permission'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Create Permission')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('backend.partial.button', ['routeName' => 'um.permission.permission_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('um.permission.permission_create')}}">
                    @csrf
                    <div class="form-group">
                      <label>{{_('Name')}}</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter permission name" value="{{old('name')}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                      <label>{{_('Prefix')}}</label>
                      <input type="text" name="prefix" class="form-control" placeholder="Enter permission prefix" value="{{old('prefix')}}">
                      @include('alerts.feedback', ['field' => 'prefix'])
                    </div>

                    <button type="submit" class="btn btn-primary">{{_('Create')}}</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection
