<div class="packages">
    @foreach (config('anp.packages') as $p)
        <article @class(['package', 'reveal', 'package--popular' => $p['popular'] ?? false])>
            @if ($p['popular'] ?? false)<span class="package__ribbon">Popular</span>@endif
            <span class="package__icon"><i class="bi {{ $p['icon'] }}"></i></span>
            <h3>{{ $p['name'] }}</h3>
            <p class="package__price"><sup>₹</sup>{{ $p['price'] }}</p>
            <ul>
                @foreach ($p['items'] as $item)
                    <li><i class="bi bi-check-circle-fill"></i> {{ $item }}</li>
                @endforeach
            </ul>
            <a href="{{ route('contact') }}?dept={{ urlencode($p['name']) }}#appointment" class="btn {{ ($p['popular'] ?? false) ? 'btn--light' : 'btn--primary' }} btn--block">Book Now</a>
        </article>
    @endforeach
</div>
