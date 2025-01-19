@extends('admin.layouts.master', ['pageSlug' => 'medicine_strength'])
@section('title', 'Edit Medicine Strength')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Medicine Strength') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.medicine_strength.medicine_strength_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST"
                    action="{{ route('product.medicine_strength.medicine_strength_edit', $medicine_strength->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <div class="inptu-group">
                                <div class="name">
                                    <label>{{ __('Name') }}</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter strength name"
                                        value="{{ $medicine_strength->name }}">
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
