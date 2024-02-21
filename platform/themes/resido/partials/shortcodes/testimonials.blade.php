<section class="bg-orange">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 text-center">
                <div class="sec-heading center">
                    <h2>{!! clean($title) !!}</h2>
                    <p>{!! clean($description) !!}</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="smart-textimonials smart-center">
                    @foreach ($testimonials as $item)
                        <div class="item">
                            <div class="item-box">
                                <div class="smart-tes-author">
                                    <div class="st-author-box">
                                        <div class="st-author-thumb">
                                            <div class="quotes bg-blue"><i class="ti-quote-right"></i></div>
                                            <img src="{{ $item->image }}" class="img-fluid"
                                                alt="{{ $item->name }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="smart-tes-content">
                                    <p>
                                        {!! $item->content !!}
                                    </p>
                                </div>

                                <div class="st-author-info">
                                    <h4 class="st-author-title">{{ $item->name }}</h4>
                                    <span class="st-author-subtitle">{{ $item->company }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
