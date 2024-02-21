@php

$properties_for_sale = get_properties_by_project($project->id, 3, 1);
$properties_for_rent = get_properties_by_project($project->id, 3, 2);
@endphp

@if(count($properties_for_sale))
<section class="section-box section-blog pb-0">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="sec-heading">
                <h2>{{ __('Properties For Sale') }}</h2>
                <hr>
            </div>
        </div>
    </div>

    <div class="row related-project-rows">
        @foreach($properties_for_sale as $property)
            <div class="col-lg-4 col-md-6 col-sm-12">
                {!! Theme::partial('real-estate.projects.property', ['property' => $property]) !!}
            </div>
        @endforeach
    </div>
</section>
@endif
@if(count($properties_for_rent))
<section class="section-box section-blog pb-0">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="sec-heading">
                <h2>{{ __('Properties For Rent') }}</h2>
                <hr>
            </div>
        </div>
    </div>

    <div class="row related-project-rows">
        @foreach($properties_for_rent as $property)
            <div class="col-lg-4 col-md-6 col-sm-12">
                {!! Theme::partial('real-estate.projects.property', ['property' => $property]) !!}
            </div>
        @endforeach
    </div>
</section>
@endif
