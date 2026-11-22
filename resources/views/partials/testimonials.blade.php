<section class="section section--tint testimonials">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Patients Testimonials</span>
            <h2 class="title">What our <span class="grad">patients say</span></h2>
        </div>
        <div class="reviews">
            @foreach (config('anp.testimonials') as $t)
                <figure class="review reveal">
                    <i class="bi bi-quote review__quote"></i>
                    <div class="review__stars" aria-label="5 out of 5 stars">
                        @for ($i = 0; $i < 5; $i++)<i class="bi bi-star-fill"></i>@endfor
                    </div>
                    <blockquote>{{ $t['text'] }}</blockquote>
                    <figcaption>
                        <span class="review__avatar">{{ mb_substr($t['name'], 0, 1) }}</span>
                        <span><strong>{{ $t['name'] }}</strong><small><img src="{{ asset('assets/img/misc/google.webp') }}" alt="" width="14" height="14"> Google Review</small></span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
