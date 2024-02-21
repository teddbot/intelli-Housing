@if ($project->facilities->count())
    <div class="property_block_wrap style-2">
        <div class="property_block_wrap_header">
            <a data-bs-toggle="collapse" data-parent="#amen" data-bs-target="#cl5"
               aria-controls="clThree" href="javascript:void(0);" aria-expanded="true">
                <h4 class="property_block_title">{{ __('Distance key between facilities') }}</h4>
            </a>
        </div>

        <div id="cl5" class="panel-collapse collapse show">
            <div class="block-body">
                <ul class="avl-features third color row">
                    @foreach($project->facilities as $facility)
                        <div class="col-sm-4">
                            <p>
                                <i class="@if (!empty($facility->icon)) {{ $facility->icon }} @else fas fa-check @endif text-orange text0i"></i>
                                {{ $facility->name }}- {{ $facility->pivot->distance }} {{ __('km') }}
                            </p>
                        </div>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
