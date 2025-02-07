<div class="modal fade voucher-modal" id="addVoucherModal" style="z-index: 999999;" tabindex="-1" role="dialog"
    aria-labelledby="address_add_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVoucherModalLable">{{ __('Add Voucher') }}</h5>

                <button type="button" class="close btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('u.ck.voucher.check') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ encrypt($order->order_id) }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <input class="form-control" type="text" name="voucher_code" id="" placeholder="Enter voucher code">
                                </div>

                                <div class="form-group col-md-12 p-2">
                                    <button type="submit"
                                        class="btn btn-sm btn-success w-100 p-2">{{ __('Verify Voucher') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
