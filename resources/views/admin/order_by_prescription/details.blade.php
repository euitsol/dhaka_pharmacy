@extends('admin.layouts.master', ['pageSlug' => 'ubp'])
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Order From Prescription') }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <a href="" class="btn btn-primary">{{ __('Add New ') }}<i class="fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div id="my_product">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="medicine">{{ __('Medicine') }}</label>
                                        <select name="medicine_id" id="medicine" class="form-control">
                                            <option value="" selected hidden>{{ __('Select Medicine') }}</option>
                                            @foreach ($medichines as $medichine)
                                                <option value="{{ $medichine->id }}"
                                                    {{ old('medicine_id') == $medichine->id ? 'selected' : '' }}>
                                                    {{ $medichine->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="unit">{{ __('Unit') }}</label>
                                        <select name="unit_id" id="unit" class="form-control">
                                            <option value="" selected hidden>{{ __('Select Unit') }}</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">{{ __('Quantity') }}</label>
                                        <select name="quantity" id="quantity" class="form-control">
                                            <option value="" selected hidden>{{ __('Select Quantity') }}</option>
                                            @for ($i = 1; $i < 1000; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Order By Prescription Details') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>{{ __('Customart Name') }}</th>
                                <th>:</th>
                                <td>{{ $up->customer->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Customart Phone') }}</th>
                                <th>:</th>
                                <td>{{ $up->customer->phone }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Delivery Address') }}</th>
                                <th>:</th>
                                <td>{{ $up->address->address }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer w-100">
                    <img src="{{ storage_url($up->image) }}" class="w-100" alt="Prescription">
                </div>
            </div>
        </div>
    </div>
@endsection
