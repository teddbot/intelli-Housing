<div class="property_block_wrap style-2">
    <div class="property_block_wrap_header">
        <a data-bs-toggle="collapse" data-parent="#features" data-bs-target="#clOne" aria-controls="clOne"
           href="javascript:void(0);" aria-expanded="false">
            <h4 class="property_block_title">{{ __('Detail & Features') }}</h4>
        </a>
    </div>
    <div id="clOne" class="panel-collapse collapse show" aria-labelledby="clOne">
        <div class="block-body">
            <ul class="detail_features">
                @if ($project->number_block)
                    <li>
                        <strong>{{ __('Blocks:') }}</strong>
                        {{ number_format($project->number_block) }}
                    </li>
                @endif
                @if ($project->number_floor)
                    <li>
                        <strong>{{ __('Floors:') }}</strong>
                        {{ number_format($project->number_floor) }}
                    </li>
                @endif
                @if ($project->number_flat)
                    <li>
                        <strong>{{ __('Number flats:') }}</strong>{{ $project->number_flat }}
                    </li>
                @endif
                @if (count($project->categories))
                    <li>
                        <strong>{{ __('Project Type:') }}</strong>
                        @foreach ($project->categories as $category)
                            <span>
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </li>
                @endif
            </ul>
        </div>
    </div>

</div>
