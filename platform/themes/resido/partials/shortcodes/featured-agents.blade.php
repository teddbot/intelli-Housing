<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 text-center">
                <div class="sec-heading center">
                    <h2>{!! clean($title) !!}</h2>
                    <p>{!! clean($description) !!}</p>
                </div>
            </div>
        </div>
        <div class="row rowm10 list-agency">
            <div class="half-circle-spinner" v-if="isLoading">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
            </div>
            @foreach ($accounts as $account)
                <div class="col-lg-3 col-md-3 col-sm-6">
                    {!! Theme::partial('real-estate.agents.item', ['account' => $account]) !!}
                </div>
            @endforeach
        </div>
    </div>
</section>
