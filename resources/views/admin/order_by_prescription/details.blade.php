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
                            <a href="javascript:void(0)" class="btn btn-primary item_add_btn">{{ __('Add New ') }}<i
                                    class="fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('obp.obp_order_create', encrypt($up->customer->id)) }}" method="POST">
                        @csrf
                        <input type="hidden" name="aid" value="{{ encrypt($up->address->id) }}">
                        <input type="hidden" name="delivery_type" value="{{ encrypt($up->delivery_type) }}">
                        <input type="hidden" name="up_id" value="{{ encrypt($up->id) }}">
                        <div id="my_product">
                            <div class="card item_card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h4 class="card-title">{{ __('Item-1') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>{{ __('Medicine') }}</label>
                                        <select name="item[1][medicine]"
                                            class="form-control {{ $errors->has('item.1.medicine') ? ' is-invalid' : '' }} medicine">
                                            <option value="" selected hidden>{{ __('Select Medicine') }}</option>
                                            @foreach ($medicines as $medicine)
                                                <option value="{{ $medicine->id }}"
                                                    {{ old('item.1.medicine') == $medicine->id ? 'selected' : '' }}>
                                                    {{ $medicine->name }}</option>
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', ['field' => 'item.1.medicine'])
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Unit') }}</label>
                                        <select name="item[1][unit]"
                                            class="form-control {{ $errors->has('item.1.unit') ? ' is-invalid' : '' }} unit"
                                            disabled>
                                            <option value="" selected hidden>{{ __('Select Unit') }}</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'item.1.unit'])
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Quantity') }}</label>
                                        <select name="item[1][quantity]"
                                            class="form-control {{ $errors->has('item.1.quantity') ? ' is-invalid' : '' }}">
                                            <option value="" selected hidden>{{ __('Select Quantity') }}</option>
                                            @for ($i = 1; $i < 1000; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('item.1.quantity' == $i ? 'selected' : '') }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @include('alerts.feedback', ['field' => 'item.1.quantity'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-0">
                            <div class="form-group text-end">
                                <input type="submit" value="Submit" class="btn btn-primary">
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
                            <tr>
                                <th>{{ __('Delivery Type') }}</th>
                                <th>:</th>
                                <td>{{ ucwords($up->delivery_type) }}</td>
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
@push('js')
    <script>
        let count = 1;

        function renumberItems() {
            $('.item_card').each(function(index) {
                $(this).find('.card-title').text(`Item-${index + 1}`);
                $(this).find('[name^="item["]').each(function() {
                    let name = $(this).attr('name');
                    let newName = name.replace(/\[\d+\]/, `[${index + 1}]`);
                    $(this).attr('name', newName);
                });
            });
            count = $('.item_card').length;
        }
        $(document).ready(function() {
            renumberItems();
            $(document).on('click', '.item_add_btn', function() {
                count += 1;
                let result = `
                            <div class="card item_card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h4 class="card-title">Item-${count}</h4>
                                        </div>
                                        <div class="col-4 text-end">
                                            <a href="javascript:void(0)" style="background:transparent !important;" class="btn btn-outline-danger item_delete_btn text-danger"><i
                                                    class="fa-solid fa-trash-can"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="medicine">Medicine</label>
                                        <select name="item[${count}][medicine]" id="medicine"
                                            class="form-control {{ $errors->has('item.*.medicine') ? ' is-invalid' : '' }} medicine" >
                                            <option value="" selected hidden>Select Medicine</option>
                                            @foreach ($medicines as $medicine)
                                                <option value="{{ $medicine->id }}">
                                                    {{ $medicine->name }}</option>
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', [
                                            'field' => 'item.*.medicine',
                                        ])
                                    </div>
                                    <div class="form-group">
                                        <label for="unit">Unit</label>
                                        <select name="item[${count}][unit]" id="unit"
                                            class="form-control {{ $errors->has('item.*.unit') ? ' is-invalid' : '' }} unit" disabled>
                                            <option value="" selected hidden>Select Unit</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'item.*.unit'])
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <select name="item[${count}][quantity]" id="quantity"
                                            class="form-control {{ $errors->has('item.*.quantity') ? ' is-invalid' : '' }}">
                                            <option value="" selected hidden>Select Quantity</option>
                                            @for ($i = 1; $i < 1000; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('item.*.quantity' == $i ? 'selected' : '') }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @include('alerts.feedback', ['field' => 'item.*.quantity'])
                                    </div>
                                </div>
                            </div>
                            `;
                $('#my_product').append(result);
            });

            $(document).on('click', '.item_delete_btn', function() {
                $(this).closest('.item_card').remove();
                renumberItems();
            });
        });

        $(document).on('change', '.medicine', function() {
            let id = $(this).val();
            console.log(id);
            if (id === null || id === '') {
                $(this).parent().next('.form-group').find('.unit').html(
                    '<option value="" selected hidden>Select Unit</option>');
                $(this).parent().next('.form-group').find('.unit').prop('disabled', true);
            } else {
                let url = `{{ route('obp.get_unit.obp_details', 'param') }}`;
                let _url = url.replace('param', id);
                let element = $(this);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let result = '';
                        data.units.forEach(function(unit) {
                            result +=
                                `<option value="${unit.id}">${unit.name+'-('+unit.quantity+')'}</option>`;
                        });
                        element.parent().next('.form-group').find('.unit').prop('disabled', false)
                        element.parent().next('.form-group').find('.unit').html(result);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching unit data:', error);
                    }
                });
            }
        });
    </script>
@endpush
