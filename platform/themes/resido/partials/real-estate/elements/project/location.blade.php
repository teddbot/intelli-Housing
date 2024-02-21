<div class="property_block_wrap style-2">
    <div class="property_block_wrap_header">
        <a data-bs-toggle="collapse" data-parent="#loca" data-bs-target="#clSix" aria-controls="clSix"
           href="javascript:void(0);" aria-expanded="true">
            <h4 class="property_block_title">{{ __('Location') }}</h4>
        </a>
    </div>

    <div id="clSix" class="panel-collapse collapse show">
        <div class="block-body">
            @if ($project->latitude && $project->longitude)
                {!! Theme::partial('real-estate.elements.traffic-map-modal', ['location' => $project->location . ', ' . $project->city_name]) !!}
            @else
                {!! Theme::partial('real-estate.elements.gmap-canvas', ['location' => $project->location]) !!}
            @endif
        </div>
    </div>

</div>
