<div class="row">
    <div class="col-12 col-lg-6">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#generalOne"
                        aria-expanded="true" aria-controls="generalOne">
                        {{ __('What is Dhaka Pharmacy?') }}
                    </button>
                </h2>
                <div id="generalOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ __('Dhaka Pharmacy is a reliable online platform where you can order prescription and over-the-counter medicines, health supplements, wellness products, and more. We deliver a wide range of healthcare products directly to your doorstep.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#generalTwo" aria-expanded="false" aria-controls="generalTwo">
                        {{__('How does the ordering process work?') }}
                    </button>
                </h2>
                <div id="generalTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ __('Browse our categories, add your chosen products to the cart, and proceed to checkout. For prescription medicines, upload your doctor’s prescription securely. Once your order is placed, our delivery system ensures prompt arrival.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#generalThree" aria-expanded="false" aria-controls="generalThree">
                        {{ __('What types of products can I order?') }}
                    </button>
                </h2>
                <div id="generalThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ __('We offer a variety of products, including prescription and over-the-counter medicines, vitamins, health supplements, personal care items, and medical devices.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#generalFour" aria-expanded="false" aria-controls="generalFour">
                        {{ __('How do I upload my prescription?') }}
                    </button>
                </h2>
                <div id="generalFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ __('Click the prescription upload button. Upload your prescription and phone number, then verify the OTP to submit your prescription.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#generalFive" aria-expanded="false" aria-controls="generalFive">
                        {{ __('What payment options are available?') }}
                    </button>
                </h2>
                <div id="generalFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ __('We support multiple secure payment methods, including cash on delivery, mobile banking, and online payment gateways.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-6">
        <div class="accordion" id="accordionExample0">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#generalSix" aria-expanded="false" aria-controls="generalSix">
                        {{ __('How does the delivery process work?') }}
                    </button>
                </h2>
                <div id="generalSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample0">
                    <div class="accordion-body">
                        {{ __('After your order is placed, our team processes and dispatches it quickly. We provide fast and reliable delivery across Bangladesh to ensure your products reach you safely.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#generalSeven" aria-expanded="false" aria-controls="generalSeven">
                        {{ __('Can I track my order?') }}
                    </button>
                </h2>
                <div id="generalSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample0">
                    <div class="accordion-body">
                        {{ __('Yes, our app offers a real-time tracking feature so you can monitor your order’s progress from dispatch to delivery.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#generalEight" aria-expanded="false" aria-controls="generalEight">
                        {{ __('Are there any exclusive discounts or offers?') }}
                    </button>
                </h2>
                <div id="generalEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample0">
                    <div class="accordion-body">
                        {{ __('Yes, we regularly offer special deals, discounts, and competitive pricing on our products.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#generalNine" aria-expanded="false" aria-controls="generalNine">
                        {{ __('What if I need help or have a question about my order?') }}
                    </button>
                </h2>
                <div id="generalNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample0">
                    <div class="accordion-body">
                        {{ __('Our customer support team is available 24/7 to assist you with any inquiries or issues related to your order.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#generalTen" aria-expanded="false" aria-controls="generalTen">
                        {{ __('How do I create an account on Dhaka Pharmacy?') }}
                    </button>
                </h2>
                <div id="generalTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample0">
                    <div class="accordion-body">
                        {{ __('Visit our') }} 
                        <a href="{{route('login')}}" >{{__('login page')}}</a>  {{__('at, enter your phone number, and verify it using an OTP. You are then ready to order your healthcare products.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
