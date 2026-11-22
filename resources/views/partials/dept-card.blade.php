<a href="{{ $url }}" class="dept-card reveal">
    <span class="dept-card__icon"><i class="bi {{ $d->icon_class }}"></i></span>
    <h3>{{ $d->name }}</h3>
    <p>{{ \Illuminate\Support\Str::limit($d->short_description, 115) }}</p>
    <span class="dept-card__more">Explore department <i class="bi bi-arrow-right"></i></span>
</a>
