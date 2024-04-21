<div class="offcanvas offcanvas-end" tabindex="-1" id="cartbtn"
                            aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">{{__('Cart')}}</h5>
                                <a href="javascript:void(0)" class="cart_clear_btn"><i class="fa-solid fa-trash-can"></i> {{__('Clear All')}}</a>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body add_to_carts">
                                @php($count = 0)
                                @forelse ($atcs as $key=>$atc)
                                    <div class="card add_to_cart_item mb-2">
                                        <div class="card-body py-2">
                                            {{-- Product Details  --}}
                                            <div class="row align-items-center product_details mb-2">
                                                <div class="ben">
                                                    <div class="text-end">
                                                        <a href="javascript:void(0)" data-atc_id ="{{$atc->id}}"class="text-danger cart_remove_btn"><i class="fa-solid fa-trash-can"></i></a>
                                                    </div>
                                                </div>
                                                <div class="image col-2">
                                                    <a href="">
                                                        <img class="border border-1 rounded-1"
                                                        src="{{storage_url($atc->product->image)}}"
                                                        alt="{{$atc->product->name}}">
                                                    </a>
                                                </div>
                                                <div class="col-8 info">
                                                    <h4 class="product_title" title="{{$atc->product->attr_title}}"> <a href="">{{$atc->product->name}}</a></h4>
                                                    <p><a href="">{{$atc->product->pro_sub_cat->name}}</a></p>
                                                    <p><a href="">{{{$atc->product->generic->name}}}</a></p>
                                                    <p><a href="">{{$atc->product->company->name}}</a></p>
                                                </div>
                                                <div class="item_price col-2 ps-0">
                                                    {{-- <h4 class="text-end"> <del class="text-danger"> &#2547; </span> <span class="item_count_regular_price">{{  (number_format((($atc->product->regular_price*$atc->unit->quantity)*$atc->quantity),2))  }}</del></h4> --}}
                                                    <h4 class="text-end"> <span> &#2547; </span> <span class="item_count_price">{{  (number_format((($atc->product->price*$atc->unit->quantity)*$atc->quantity),2))  }}</span></h4>
                                                    
                                                </div>
                                            </div>


                                            <div class="row align-items-center atc_functionality">

                                                {{-- Units --}}
                                                <div class="item_units col-8">
                                                    <div class="form-group my-1 boxed">
                                                        
                                                        @foreach ($atc->product->units as $u_key=>$unit)
                                                            @php($count++)
                                                            <input type="radio" data-name="{{$unit->name}}" 
                                                                @if (!empty($atc->unit_id) && ($unit->id == $atc->unit_id)) checked @endif
                                                                class="unit_quantity" id="android-{{$count+20}}"
                                                                name="data-{{$key}}"
                                                                value="{{ $atc->product->price * $unit->quantity }}">
                                                                <label for="android-{{ $count+20 }}">
                                                                    <img src="{{storage_url($unit->image)}}">
                                                                </label>
                                                        @endforeach
                                                    </div>
                                                </div>


                                                {{-- Plus Minus  --}}
                                                <div class="plus_minus col-4 ps-md-4 d-flex align-items-center justify-between">
                                                    <div class="form-group">
                                                        <div class="input-group" role="group">
                                                            <a href="javascript:void(0)" data-id="{{$atc->id}}" class="btn btn-sm minus_btn "><i class="fa-solid fa-minus"></i></a>
                                                            <input type="text" disabled class="form-control text-center plus_minus_quantity" data-item_price="{{ (!empty($atc->unit_id)) ? ($atc->product->price*$atc->unit->quantity) : ($atc->product->price)  }}" value="{{$atc->quantity}}" >
                                                            <a href="javascript:void(0)" data-id="{{$atc->id}}" class="btn btn-sm plus_btn"><i class="fa-solid fa-plus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <h5 class="text-center cart_empty_alert">{{__('Added Some Products')}}</h5>
                                @endforelse
                            </div>
                            <div class="offcanvas-footer cart_sub_total px-4 py-3">
                                <div class="row">
                                    <div class="col-8">
                                        <h3>{{__('Total Item')}}</h3>
                                    </div>
                                    <div class="col-4 text-end">
                                        <h3 class="total_check_item">0</h3>
                                    </div>
                                    <div class="col-8">
                                        <h3>{{__('Subtotal Price')}}</h3>
                                    </div>
                                    <div class="col-4 text-end">
                                        <h3><span> &#2547; </span> <span class="subtotal_price">0.00</span></h3>
                                    </div>
                                    <div class="col-12">
                                        <a href="{{route('product.int','cart-order')}}" class="btn order_button w-100 {{count($atcs)<1 ? 'disabled' : ''}}" >{{__('Proceed To Checkout')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>