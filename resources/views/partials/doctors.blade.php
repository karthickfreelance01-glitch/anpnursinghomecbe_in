<div class="doctors">
    @foreach (config('anp.doctors') as $d)
        <article class="doctor reveal">
            <div class="doctor__photo">
                <img src="{{ asset('assets/img/doctors/' . $d['photo']) }}" alt="{{ $d['name'] }}" loading="lazy" width="700" height="700">
            </div>
            <div class="doctor__body">
                <span class="doctor__role">{{ $d['designation'] }}</span>
                <h3>{{ $d['name'] }}</h3>
                <dl>
                    <div><dt><i class="bi bi-hospital"></i> Primary Speciality</dt><dd>{{ $d['speciality'] }}</dd></div>
                    <div><dt><i class="bi bi-stars"></i> Special Interest</dt><dd>{{ $d['interest'] }}</dd></div>
                </dl>
                <a href="{{ route('contact') }}?dept={{ urlencode($d['interest']) }}#appointment" class="btn btn--primary btn--sm">Book Appointment <i class="bi bi-arrow-right"></i></a>
            </div>
        </article>
    @endforeach
</div>
