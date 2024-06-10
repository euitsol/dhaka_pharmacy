{{-- Prescription Upload Modal  --}}
<div class="modal up_modal fade" style="z-index: 99999999999999;" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Order By Prescription') }}</h5>
                <button type="button" class="close  px-2 border-1 border-danger rounded-1 text-danger"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="up_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="prescription">{{ __('Prescription Image') }}<span
                                class="text-danger">*</span></label>
                        <input type="file" name="uploadfile" data-actualName="image" class="form-control filepond"
                            id="prescription" accept="image/*">
                    </div>
                    <div class="form-group mb-3">
                        <label for="address">{{ __('Delivery Address') }}<span class="text-danger">*</span></label>
                        <select name="address_id" id="address" class="form-control">
                            <option value="">{{ __('Select Delivery Address') }}</option>
                            @if (user())
                                @foreach (user()->address as $address)
                                    <option value="{{ $address->id }}"
                                        {{ $address->is_default == 1 ? 'selected' : '' }}>
                                        {{ str_limit($address->address, 90) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ __('Shipping') }}<span class="text-danger">*</span></label>
                        <select name="delivery_type" class="form-control" id="delivery_type">
                            <option value="">{{ __('Select Delivery Type') }} </option>
                            <option value="normal">{{ __('Normal-Delivery') }} </option>
                            <option value="standard">{{ __('Standard-Delivery') }} </option>
                        </select>
                    </div>
                    <div class="form-group text-end mt-3">
                        <a href="javascript:void(0)" class="btn btn-success up_submit_btn">{{ __('Submit') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('filepond.fileupload')
@push('js')
    <script src="{{ asset('user/asset/js/up.js') }}"></script>
    <script>
        file_upload(["#prescription"], "uploadfile", "user");
        const data = {
            'auth': `{{ Auth::guard('web')->check() }}`,
            'login_route': `{{ route('login') }}`,
            'upload_route': `{{ route('u.obp.up') }}`,
        };
    </script>
@endpush
