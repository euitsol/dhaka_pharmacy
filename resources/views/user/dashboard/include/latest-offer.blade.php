{{-- <div class="latest-offer">
    <!-- <h2 class="d d-none">{{ __('Our Latest Offers') }}</h2> -->
    <div class="slider">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @if ($latest_offers->count() > 2)
                    @foreach ($latest_offers->chunk(2) as $key => $lf)
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="{{ $key }}"
                            class="{{ $key == 0 ? 'active' : '' }}" aria-current="true"
                            aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                @endif
            </div>

            <div class="carousel-inner">
                @foreach ($latest_offers as $key => $lf)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="items d-flex">

                                <div class="img-col w-100">
                                    <a href="#">
                                        <div id="lightbox" class="lightbox offer_image">
                                            <div class="lightbox-content">
                                                <img src="{{ storage_url($lf->image) }}" class="lightbox_image">
                                            </div>
                                            <div class="close_button fa-beat">X</div>
                                        </div>
                                    </a>
                                </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div> --}}



<div class="latest-offer">
    <div class="slider">
      <div id="carouselLatestOfferIndicators" class="carousel carousel-dark slide">
            <div class="carousel-indicators">
            @if ($latest_offers->count() > 0)
                @foreach ($latest_offers as $key => $lf)
                    <button type="button" data-bs-target="#carouselLatestOfferIndicators" data-bs-slide-to="{{ $key }}"
                        @if ($key == 0 )
                            class="active"
                            aria-current="true"
                        @endif
                        aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            @endif
            </div> 
            <div class="carousel-inner">
                @foreach ($latest_offers as $key => $lf)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div id="lightbox" class="lightbox offer_image">
                        <div class="lightbox-content">
                            <img src="{{ storage_url($lf->image) }}" class="lightbox_image d-block w-100" alt="{{ $lf->title }}">
                        </div>
                        <div class="close_button fa-beat">X</div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselLatestOfferIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselLatestOfferIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> 
        </div>
    </div>
</div>





