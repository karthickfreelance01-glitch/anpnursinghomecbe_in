@php($c = config('anp.contact'))
<section class="section appointment" id="appointment">
    <div class="container appointment__grid">
        <div class="appointment__info reveal">
            <span class="eyebrow eyebrow--light">Book Appointment</span>
            <h2>Request an appointment in under a minute</h2>
            <p>Fill in your details and send them to us on WhatsApp — our front desk will confirm your slot. Or simply call any of our appointment lines.</p>
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

        <form class="form reveal" id="appointmentForm" data-whatsapp="{{ $c['whatsapp'] }}" novalidate>
            <div class="form__row">
                <label class="field">
                    <span>Full Name *</span>
                    <input type="text" name="name" required placeholder="Your name" autocomplete="name">
                </label>
                <label class="field">
                    <span>Phone Number *</span>
                    <input type="tel" name="phone" required placeholder="10-digit mobile" pattern="[0-9+\s]{10,15}" autocomplete="tel">
                </label>
            </div>
            <div class="form__row">
                <label class="field">
                    <span>Department</span>
                    <select name="dept" id="deptSelect">
                        <option value="">Select department</option>
                        <optgroup label="Medical Speciality">
                            @foreach (config('anp.medical') as $d)<option>{{ $d['name'] }}</option>@endforeach
                        </optgroup>
                        <optgroup label="Surgical Speciality">
                            @foreach (config('anp.surgical') as $d)<option>{{ $d['name'] }}</option>@endforeach
                        </optgroup>
                        <optgroup label="Health Checkup">
                            @foreach (config('anp.packages') as $p)<option>{{ $p['name'] }}</option>@endforeach
                        </optgroup>
                        <optgroup label="Doctors">
                            <option>Diabetologist</option>
                            <option>Infertility Specialist</option>
                        </optgroup>
                    </select>
                </label>
                <label class="field">
                    <span>Preferred Date</span>
                    <input type="date" name="date">
                </label>
            </div>
            <label class="field">
                <span>Message</span>
                <textarea name="message" rows="3" placeholder="Briefly describe your concern (optional)"></textarea>
            </label>
            <p class="form__error" role="alert" hidden>Please enter your name and a valid phone number.</p>
            <button type="submit" class="btn btn--primary btn--block btn--lg"><i class="bi bi-whatsapp"></i> Send Request on WhatsApp</button>
        </form>
    </div>
</section>
