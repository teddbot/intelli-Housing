@php
    $img_slider = isset($img_slider) ? $img_slider : true;
    $is_lazyload = false;
@endphp

<div class="property-listing property-2 project {{ $class_extend ?? '' }} rounded-4px"
     data-lat="{{ $project->latitude }}"
     data-long="{{ $project->longitude }}">

    <div class="listing-img-wrapper">

        <div class="list-img-slide">
            <div class="click @if(!$img_slider) not-slider @endif">
                @foreach ($project['images'] as $image)
                    <div>
                        <a href="{{ $project->url }}" title="{{ $project->name }}">
                            @if($is_lazyload)
                                <img src="{{ get_image_loading() }}"
                                    data-src="{{ RvMedia::getImageUrl($image, 'medium', false, RvMedia::getDefaultImage()) }}"
                                    class="img-fluid mx-auto lazy" alt="{{ $project->name }}"/>
                            @else
                                <img
                                    src="{{ RvMedia::getImageUrl($image, 'medium', false, RvMedia::getDefaultImage()) }}"
                                    class="img-fluid mx-auto" alt="{{ $project->name }}"/>
                            @endif
                        </a>
                    </div>
                    @if(!$img_slider)
                        @break
                    @endif
                @endforeach
            </div>
        </div>
        <div class="project-category position-absolute">
            <span class="prt-types">{{ $project->category->name }}</span>
        </div>
        <div class="list-price-wrapper">
            <div class="list-price">
                <h6 class="listing-card-info-price">
                    @if ($project->price_from || $project->price_to)
                        <small>
                            @if ($project->price_from)
                                {{ format_price($project->price_from, $project->currency) }}
                            @endif @if ($project->price_to)
                                - {{ format_price($project->price_to, $project->currency) }}
                            @endif
                        </small>
                    @endif
                </h6>
            </div>

        </div>
    </div>

    <div class="infor">
        <div class="listing-detail-wrapper">
            <div class="listing-short-detail-wrap">
                <div class="listing-short-detail">
                    <h4 class="listing-name">
                        <a href="{{ $project->url }}" class="prt-link-detail text-uppercase"
                        title="{{ $project->name }}">{!! clean($project->name) !!}</a>
                        <div class="object-socials-share-icon" data-toggle="tooltip" data-placement="top"
                            title="{{ __('Share') }}"></div>
                    </h4>

                    <p class="listing-short-description">{{ Str::words(clean($project->description), 18, '') }}</p>
                </div>
            </div>
        </div>

        @if(!empty($project->agents_summary))
            <div class="summary-agents-info-wrapper price-features-wrapper price-features-wrapper-border-top">
                <div class="summary-agents-col">
                    {{ trans(':totalAgents agents in :totalCountries countries in :totalLanguages different languages', [
                        'totalAgents' => $project->agents_summary['totalAgents'],
                        'totalCountries' => $project->agents_summary['totalCountries'],
                        'totalLanguages' => $project->agents_summary['totalLanguages']
                    ]) }}
                </div>
                <div class="summary-agents-col">
                    <div class="short-agents-listing-avatar-wrapper">
                        @foreach($project->agents_summary['agents'] as $agent)
                            <a href="javascript:void(0)">
                                <img src="{{ $agent['image_url'] }}" alt="{{ $agent['name'] }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div class="listing-detail-footer">
            <div class="footer-first">
                <div class="foot-location d-flex">
                    <img src="{{ Theme::asset()->url('img/pin.svg') }}" width="18"
                        alt="{!! clean($project->city_name ) !!}"/>
                    {!! clean($project->city_name ) !!}
                </div>
            </div>
            <div class="footer-flex">
                <div class="listing-card-info-icon mb-2">
                    {{ $project->properties ? $project->properties->count() : 0 }} {{ __('Properties') }}
                </div>
            </div>
        </div>
    </div>
</div>
