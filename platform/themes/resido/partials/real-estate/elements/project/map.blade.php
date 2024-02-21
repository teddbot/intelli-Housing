<div class="d-flex">
    <div class="blii">
        <img class="lazy" src="{{ get_image_loading() }}" data-src="{{ $project->image_thumb }}" height="100" width="100" alt="{{ $project->name }}">
    </div>
    <div class="infomarker">
        <h4><a href="{{ $project->url }}" target="_blank">{{ $project->name }}</a></h4>
        <div class="mb-1"><span>{{ $project->city_name }}</span></div>
        <div class="lists_property_price">
            <div class="lists_property_price_value">
                <h5>{{ $project->price_html }}</h5>
            </div>
        </div>

    </div>
</div>
