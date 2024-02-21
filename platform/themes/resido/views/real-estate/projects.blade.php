<div class="projects-page-wrapper">
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title">{{ __('All projects') }}</h2>
                    <span class="ipn-subtitle">{{ __('Discover our projects') }}</span>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-light">
        <div class="container d-md-block">
            <div class="filter_search_opt">
                <a href="javascript:void(0);" class="open_search_menu">{{ __('Search Project') }}<i
                        class="ml-2 ti-menu"></i></a>
            </div>
            <div class="simple-sidebar sm-sidebar filter_search_project" id="filter_search" style="left: -310px;">
                <div class="section-search-wrapper">
                    <div class="eclip-search italian-search hero-search-radius">
                        {!! Theme::partial('real-estate.filters.projects') !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            @if ($projects->count())
                <div class="row">
                    <div class="item-sorting clearfix mb-2">
                        <div class="left-column">
                            <h4 class="mb-0">
                                @if($projects->total() == 0)
                                    {{ __('0 results') }}
                                @else
                                    {{ __('Found :from - :to Of :total Results', [
                                        'from' => $projects->firstItem(),
                                        'to' => $projects->lastItem(),
                                        'total' => $projects->total(),
                                    ]) }}
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach($projects as $project)
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            {!! Theme::partial('real-estate.projects.item', ['project' => $project, 'img_slider' => true]) !!}
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <nav class="d-flex justify-content-center pt-3">
                            {!! $projects->withQueryString()->links() !!}
                        </nav>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <p class="item">{{ __('0 results') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

</div>
