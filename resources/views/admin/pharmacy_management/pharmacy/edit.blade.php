@extends('admin.layouts.master', ['pageSlug' => 'pharmacy'])

@section('content')
    <div class="row px-3 pt-3">
        <div class=" {{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Edit Pharmacy')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', ['routeName' => 'pm.pharmacy.pharmacy_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{route('pm.pharmacy.pharmacy_edit',$pharmacy->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{$pharmacy->name}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{$pharmacy->email}}">
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
       
@if ($document)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p class="card-header">
                            <b>{{ ucfirst($document->module_key) }}</b>
                        </p>
                        <div class="card-body">
                            {{ $document->documentation }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
