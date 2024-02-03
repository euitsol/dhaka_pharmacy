@extends('admin.layouts.master', ['pageSlug' => 'medicine_unit'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Update Medicine Unit')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', ['routeName' => 'product.medicine_unit.medicine_unit_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{route('product.medicine_unit.medicine_unit_edit',$medicine_unit->id)}}">
                    @csrf
                    @method('PUT')
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>{{__('Name')}}</label>
                          <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{$medicine_unit->name}}">
                          @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group col-md-6">
        
                          <label>{{__('Quantity')}}</label>
                          <input type="text" name="quantity" class="form-control" placeholder="Enter quantity"
                              value="{{ $medicine_unit->quantity }}">
                          @include('alerts.feedback', ['field' => 'quantity'])
                        </div>
                      </div>
                    <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                  </form>
                </div>
              </div>
        </div>
        @include('admin.partials.documentation',['document'=>$document])
    </div>
@endsection
