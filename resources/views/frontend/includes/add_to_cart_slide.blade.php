<div class="offcanvas offcanvas-end" tabindex="-1" id="cartbtn" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ __('Cart') }}</h5>
        <a href="javascript:void(0)" class="cart_clear_btn"><i class="fa-solid fa-trash-can"></i>
            {{ __('Clear All') }}</a>
        <button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body cart_items">

    </div>
    <div class="offcanvas-footer cart_sub_total px-4 py-3">
        <div class="row">
            <div class="col-8">
                <h3>{{ __('Total Item') }}</h3>
            </div>
            <div class="col-4 text-end">
                <h3 class="total_check_item">0</h3>
            </div>
            <div class="col-8">
                <h3>{{ __('Subtotal Price') }}</h3>
            </div>
            <div class="col-4 text-end">
                <h3><span> {!! get_taka_icon() !!} </span> <span class="subtotal_price">0.00</span></h3>
            </div>
            <div class="col-12">
                <a href="javascript:void(0)" class="btn order_button w-100 d-flex align-items-center justify-content-center"
                    id="checkoutBtn">{{ __('Proceed To Checkout') }}</a>
            </div>
        </div>
    </div>
</div>



<form action="{{ route('u.ck.init') }}" method="POST" id="checkoutForm">
    @csrf
</form>
