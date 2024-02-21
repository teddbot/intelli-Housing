@php
$allowShareViaWhatsapp = theme_option('allow_share_via_whatsapp', 'no');
@endphp
<div class="details-sidebar">

    <!-- Like And Share -->
    <div class="like_share_wrap b-0">
        <ul class="like_share_list justify-content-center">
            <li class="social_share_list">
                <a href="JavaScript:void(0);" class="btn btn-likes" data-bs-toggle="tooltip"
                data-original-title="Share"><i class="fas fa-share"></i>{{ __('Share') }}</a>
                <div class="social_share_panel">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&title={{ $project->description }}"
                    target="_blank" class="cl-facebook"><i class="lni-facebook"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ $project->description }}"
                    target="_blank" class="cl-twitter"><i class="lni-twitter"></i></a>
                    <a href="https://linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&summary={{ rawurldecode($project->description) }}&source=Linkedin"
                    target="_blank" class="cl-linkedin"><i class="lni-linkedin"></i></a>
                    @if($allowShareViaWhatsapp == 'yes')
                        <a href="https://api.whatsapp.com/send?text={{ rawurldecode($project->description) }} {{ urlencode(url()->current()) }}"
                        data-action="share/whatsapp/share" target="_blank" class="cl-linkedin"><i
                                class="lni-whatsapp"></i></a>
                    @endif
                </div>
            </li>
            <li><a href="JavaScript:Void(0);" data-id="{{ $project->id }}"
                class="btn btn-likes add-to-wishlist" data-bs-toggle="tooltip"
                data-original-title="Save"><i
                        class="fas fa-heart"></i>{{ __('Save') }}</a></li>
        </ul>
    </div>

    @if ($author = $project->author)
    <!-- Agent Detail -->
    <div class="sides-widget">
        <div class="sides-widget-header">
            @if ($author->username)
                <div class="agent-photo">
                    <img src="{{ RvMedia::getImageUrl($author->avatar->url, 'thumb') }}"
                         alt="{{ $author->name }}">
                </div>
                <div class="sides-widget-details">
                    <h4>
                        <a href="{{ route('public.agent', $author->username) }}"> {{ $author->name }}</a>
                    </h4>
                    <a href="tel:{{ $author->phone }}"> <span><i class="lni-phone-handset"></i>{{ $author->phone }}</span></a>
                </div>
                <div class="clearfix"></div>
            @endif
        </div>

        <div class="sides-widget-body simple-form">
            {!! Theme::partial('real-estate.elements.form-contact-consult', ['data' => $project]) !!}
        </div>
    </div>
    @endif

    {!! dynamic_sidebar('property_sidebar') !!}
</div>
