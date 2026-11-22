@php($url = \App\Support\Asset::url($value ?? null))
<div class="f img-field">
    <span>{{ $label }}</span>
    <label class="img-drop {{ $url ? 'has-img' : '' }}">
        <img src="{{ $url }}" alt="" data-preview @unless($url) hidden @endunless>
        <span class="img-drop__hint"><i class="bi bi-cloud-arrow-up"></i> Click to {{ $url ? 'replace' : 'upload' }} <small>JPG, PNG or WEBP</small></span>
        <input type="file" name="{{ $name }}" accept="image/jpeg,image/png,image/webp" data-image-input>
    </label>
    @if ($url && ($removable ?? true))
        <label class="check check--sm"><input type="checkbox" name="remove_{{ $name }}" value="1"> Remove this image</label>
    @endif
</div>
