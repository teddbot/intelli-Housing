<div class="featured_slick_gallery">
    <div class="featured_slick_gallery-slide">
        @foreach ($project->images as $index => $image)
            @if($loop->index > 3)
                @break;
            @endif
            <div class="featured_slick_padd">
                @if(!isset($showViewPhotos) || !empty($showViewPhotos))
                    <a href="{{ RvMedia::getImageUrl($image, null, false, RvMedia::getDefaultImage()) }}"
                       class="mfp-gallery">
                        <img
                            src="{{ RvMedia::getImageUrl($image, 'medium_xlarge', false, RvMedia::getDefaultImage()) }}"
                            class="img-fluid mx-auto" alt="{{ $project->name }}-{{ $index }}"/>
                    </a>
                @else
                    <img src="{{ RvMedia::getImageUrl($image, 'medium_xlarge', false, RvMedia::getDefaultImage()) }}"
                         class="img-fluid mx-auto" alt="{{ $project->name }}-{{ $index }}"/>
                @endif
            </div>
        @endforeach
    </div>
    @if(!isset($showViewPhotos) || !empty($showViewPhotos))
        <a href="JavaScript:void(0)" class="btn-view-pic top">{{ __('View photos') }}</a>
    @endif
</div>
