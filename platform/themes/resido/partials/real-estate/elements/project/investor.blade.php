<div class="property_block_wrap style-2">
    <div class="property_block_wrap_header">
        <a data-bs-toggle="collapse" data-parent="#loca" data-bs-target="#clSix" aria-controls="clSix"
           href="javascript:void(0);" aria-expanded="true">
            <h4 class="property_block_title">{{ __('Investor') }}</h4>
        </a>
    </div>

    <div class="block-body">
        <div class="agency-list">
            <div class="agency-avatar">
                <img src="{{ $project->investor->avatar_url }}" class="img-fluid mx-auto" alt="{{ $project->investor->name}}">
            </div>
            <div class="agency-content">
                <div class="agency-name">
                    <h4>{{ $project->investor->name }}</h4>
                </div>
                <div class="agency-desc">{{ $project->investor->description }}</div>
            </div>
        </div>
    </div>

</div>
