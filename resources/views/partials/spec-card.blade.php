<a href="{{ route('specialities.show', $d->slug) }}" class="spec-tile">
    <span class="spec-tile__media">
        @if ($d->image)
            <img src="{{ $d->image_url }}" alt="{{ $d->name }} at ANP Nursing Home" loading="lazy" width="640" height="438">
        @else
            <span class="spec-tile__placeholder"><i class="bi {{ $d->icon_class }}"></i></span>
        @endif
        <span class="spec-tile__icon"><i class="bi {{ $d->icon_class }}"></i></span>
    </span>
    <span class="spec-tile__body">
        <strong>{{ $d->name }}</strong>
        <small>{{ \Illuminate\Support\Str::limit($d->short_description, 80) }}</small>
        <span class="spec-tile__more">Learn more <i class="bi bi-arrow-right"></i></span>
    </span>
</a>
