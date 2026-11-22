@php($c = config('anp.contact'))
<section class="section appointment" id="appointment">
    <div class="container appointment__grid">
        <div class="appointment__info reveal">
            <span class="eyebrow eyebrow--light">Book Appointment</span>
            <h2>Request an appointment in under a minute</h2>
            <p>Fill in your details and our front desk will call you back to confirm your slot. Or simply call any of our appointment lines.</p>
            <ul class="appointment__lines">
                @foreach ($c['appointment'] as $num)
                    <li><a href="tel:{{ preg_replace('/\s+/', '', $num) }}"><i class="bi bi-telephone"></i> {{ $num }}</a></li>
                @endforeach
            </ul>
            <div class="appointment__hours">
                <i class="bi bi-clock-history"></i>
                <span><strong>Emergency, ICU &amp; Pharmacy</strong> open 24 hours, 7 days a week</span>
            </div>
        </div>

        <div class="reveal">
            @include('partials.enquiry-form')
        </div>
    </div>
</section>
