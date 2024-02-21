<section class="section-box section-blog">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="sec-heading">
                <h2>{{ __('Related Projects') }}</h2>
                <hr>
            </div>
        </div>
    </div>

    <div class="row" class="related-project-rows">
        @foreach($relatedProjects as $projectItem)
            <div class="col-lg-4 col-md-6 col-sm-12">
                {!! Theme::partial('real-estate.projects.item', ['project' => $projectItem]) !!}
            </div>
        @endforeach
    </div>
</section>
