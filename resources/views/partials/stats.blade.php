<section class="stats">
    <div class="container stats__grid">
        @foreach (config('anp.stats') as $s)
            <div class="stat reveal">
                <span class="stat__icon"><i class="bi {{ $s['icon'] }}"></i></span>
                <strong><span class="counter" data-to="{{ $s['value'] }}">0</span>{{ $s['suffix'] }}</strong>
                <span>{{ $s['label'] }}</span>
            </div>
        @endforeach
    </div>
</section>
