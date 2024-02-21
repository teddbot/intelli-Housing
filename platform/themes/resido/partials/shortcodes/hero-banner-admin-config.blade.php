<div class="form-group mb-3">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="Find Accessible Homes To Rent">
</div>
<div class="form-group mb-3">
    <label class="control-label">{{ __('Description') }}</label>
    <textarea name="description" data-shortcode-attribute="content" class="form-control" rows="3">{{ $content }}</textarea>
</div>
<div class="form-group mb-3">
    <label class="control-label">{{ __('Background') }}</label>
    {!! Form::mediaImage('bg', Arr::get($attributes, 'bg')) !!}
</div>
<div class="form-group mb-3">
    <label class="control-label">{{ __('Overlay') }}</label>
    <input name="overlay" type="number" value="{{ Arr::get($attributes, 'overlay', '0') }}" class="form-control">
</div>
<div class="form-group mb-3">
    <label class="control-label">{{ __('Style') }}</label>
    <select name="style" class="form-control">
        @foreach([1,2,3,4,5,6,10] as $i)
            <option value="{{ $i }}" @if (Arr::get($attributes, 'style') == $i) selected @endif>{{ $i }}</option>
        @endforeach
    </select>
</div>
