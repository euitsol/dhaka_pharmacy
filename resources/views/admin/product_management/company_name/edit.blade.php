@extends('admin.layouts.master', ['pageSlug' => 'medicine_company_name'])
@section('title', 'Edit Company')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Edit Company')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', ['routeName' => 'product.company_name.company_name_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{route('product.company_name.company_name_edit',$company_name->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>{{__('Name')}}</label>
                      <input type="text" id="title" name="name" class="form-control" placeholder="Enter name" value="{{$company_name->name}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                        <label>{{ _('Slug') }}</label>
                        <input type="text" value="{{$company_name->slug}}" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug" name="slug" placeholder="{{ _('Enter Slug (must be use - on white speace)') }}">
                        @include('alerts.feedback', ['field' => 'slug'])
                    </div>
                    <div class="form-group">
                      <label>{{__('Address')}}</label>
                      <textarea name="address" class="form-control">{{$company_name->address}}</textarea>
                      @include('alerts.feedback', ['field' => 'address'])
                  </div>
                  <div class="form-group">
                      <label>{{__('Note')}}</label>
                      <textarea name="note" class="form-control">{{$company_name->note}}</textarea>
                      @include('alerts.feedback', ['field' => 'note'])
                  </div>
                    <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                  </form>
                </div>
              </div>
        </div>
        @include('admin.partials.documentation',['document'=>$document])
    </div>
@endsection
