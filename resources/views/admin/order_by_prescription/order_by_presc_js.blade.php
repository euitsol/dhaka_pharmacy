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
                                        class="form-control {{ $errors->has('item.*.medicine') ? ' is-invalid' : '' }} medicine select-${count}" >
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
            $('.select-' + count).select2();
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
                    element.parent().next('.form-group').find('.unit').select2();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching unit data:', error);
                }
            });
        }
    });
</script>
