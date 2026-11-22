<section class="section why">
    <div class="container why__grid">
        <div class="why__intro reveal">
            <span class="eyebrow">Why Choose ANP?</span>
            <h2 class="title">Family-like care, <span class="grad">advanced medicine</span></h2>
            <p>Our reputation for outstanding care and family-like atmosphere, together with advanced medical technology and facilities, ensures we attract leading consultants and specialists from the industry to work with us.</p>
            <div class="why__badges">
                <img src="{{ asset('assets/img/misc/nabh.webp') }}" alt="NABH Pre-Accredited" loading="lazy">
                <img src="{{ asset('assets/img/misc/24-7.webp') }}" alt="Open 24/7" loading="lazy">
            </div>
        </div>
        <div class="accordion reveal">
            @foreach (config('anp.why') as $i => $w)
                <details class="accordion__item" @if($i === 0) open @endif>
                    <summary>
                        <span class="accordion__icon"><i class="bi {{ $w['icon'] }}"></i></span>
                        {{ $w['title'] }}
                        <i class="bi bi-plus-lg accordion__toggle"></i>
                    </summary>
                    <p>{{ $w['text'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
