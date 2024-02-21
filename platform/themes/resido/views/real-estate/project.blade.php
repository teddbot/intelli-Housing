@php
    Theme::asset()->usePath()->add('leaflet-css', 'plugins/leaflet.css');
    Theme::asset()->usePath()->add('jquery-bar-rating', 'plugins/jquery-bar-rating/themes/fontawesome-stars.css');
    Theme::asset()->container('footer')->usePath()->add('leaflet-js', 'plugins/leaflet.js');
    Theme::asset()->usePath()->add('magnific-css', 'plugins/magnific-popup.css');
    Theme::asset()->container('footer')->usePath()->add('magnific-js', 'plugins/jquery.magnific-popup.min.js');
    Theme::asset()->container('footer')->usePath()->add('bootstrap-popper', 'plugins/bootstrap/popper.min.js');
    Theme::asset()->container('footer')->usePath()->add('property-js', 'js/property.js');
    Theme::asset()->container('footer')->usePath()->add('jquery-bar-rating-js', 'plugins/jquery-bar-rating/jquery.barrating.min.js');

    $video = $project->getMetaData('video', true);
    $videoUrl = $video['url'] ?? '';
@endphp

<div id="project-detail-content">

    {!! Theme::partial('real-estate.elements.project.header-images', compact('project')) !!}

    <!-- ============================ Property Detail Start ================================== -->

    <section class="gray-simple">
        <div data-project-id="{{ $project->id }}"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="property_block_wrap style-2 p-4">
                        <div class="prt-detail-title-desc">
                            <span class="prt-types sale">{{ $project->status->label() }}</span>
                            <h1 class="h3">{{ $project->name }}</h1 class="h3">
                            <span>
                                <i class="lni-map-marker"></i>
                                {{ $project->location }}
                            </span>
                            @if ($project->price_from || $project->price_to)
                                <h3 class="prt-price-fix mt-3">
                                    @if ($project->price_from)
                                        {{ format_price($project->price_from)  }}
                                    @endif
                                    @if ($project->price_to)
                                        - {{ format_price($project->price_to) }}
                                    @endif
                                </h3>
                            @endif
                        </div>
                    </div>

                    <div class="property_block_wrap style-2">
                        <div class="property_block_wrap_header">
                            <a data-bs-toggle="collapse" data-parent="#dsrp" data-bs-target="#clTwo"
                               aria-controls="clTwo"
                               href="javascript:void(0);" aria-expanded="true">
                                <h4 class="property_block_title">{{ __('Description') }}</h4>
                            </a>
                        </div>
                        <div id="clTwo" class="panel-collapse collapse show">
                            <div class="block-body">
                                {!! clean($project->content) !!}
                            </div>
                        </div>
                    </div>

                    {!! Theme::partial('real-estate.elements.video', ['object' => $project]) !!}
                    {!! Theme::partial('real-estate.elements.project.facilities', compact('project')) !!}
                    {!! Theme::partial('real-estate.elements.project.features', compact('project')) !!}
                    {!! Theme::partial('real-estate.elements.project.location', compact('project')) !!}
                    {!! Theme::partial('real-estate.elements.project.investor', compact('project')) !!}
                    {!! Theme::partial('real-estate.elements.gallery', ['property' => $project]) !!}
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        {!! Theme::partial('real-estate.elements.project.properties', compact('project')) !!}
        {!! Theme::partial('real-estate.elements.project.related', compact('relatedProjects')) !!}
    </div>

    @if ($project->latitude && $project->longitude)
        <div
            data-magnific-popup="#trafficMap"
            data-map-id="trafficMap"
            data-popup-id="#traffic-popup-map-template"
            data-map-icon="{{ $project->map_icon }}"
            data-center="{{ json_encode([$project->latitude, $project->longitude]) }}">
        </div>
    @endif

    <script id="traffic-popup-map-template" type="text/x-custom-template">
    {!! Theme::partial('real-estate.elements.project.map', ['project' => $project]) !!}
    </script>
</div>
