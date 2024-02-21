<div class="rating_wrap" data-star="{{ $property->average_rating }}">
    <div class="rating">
        <div class="product_rate" style="width: {{ $property->average_rating/0.05 }}%;"></div>
    </div>
    <span class="reviews_text">( {{ $property->reviews_count }} {{ __('Reviews') }})</span>
</div>