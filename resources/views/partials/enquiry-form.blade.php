@php
    $c = config('anp.contact');
    $compact = $compact ?? false;
    $preset = $preset ?? request('dept');
@endphp
<form class="form js-enquiry {{ $compact ? 'form--compact' : '' }}" action="{{ route('enquiry.store') }}" method="POST" data-whatsapp="{{ $c['whatsapp'] }}" novalidate>
    @csrf
    <input type="hidden" name="source" value="{{ url()->current() }}">
    <label class="hp" aria-hidden="true">Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>

    @if (session('enquiry_success'))
        <div class="form__success"><i class="bi bi-check-circle-fill"></i> {{ session('enquiry_success') }}</div>
    @endif

    <div class="form__row">
        <label class="field">
            <span>Full Name *</span>
            <input type="text" name="name" required maxlength="120" placeholder="Your name" autocomplete="name" value="{{ old('name') }}">
        </label>
        <label class="field">
            <span>Phone Number *</span>
            <input type="tel" name="phone" required placeholder="10-digit mobile" inputmode="tel" pattern="[0-9+\s\-]{10,16}" autocomplete="tel" value="{{ old('phone') }}">
        </label>
    </div>
    <div class="form__row">
        <label class="field">
            <span>Department</span>
            <select name="dept">
                <option value="">Select department</option>
                @if ($navDepartments->isNotEmpty())
                    <optgroup label="Departments">
                        @foreach ($navDepartments as $d)<option @selected($preset === $d->name)>{{ $d->name }}</option>@endforeach
                    </optgroup>
                @endif
                <optgroup label="Medical Speciality">
                    @foreach ($medicalList as $d)<option @selected($preset === $d->name)>{{ $d->name }}</option>@endforeach
                </optgroup>
                <optgroup label="Surgical Speciality">
                    @foreach ($surgicalList as $d)<option @selected($preset === $d->name)>{{ $d->name }}</option>@endforeach
                </optgroup>
                <optgroup label="Health Checkup">
                    @foreach (config('anp.packages') as $p)<option @selected($preset === $p['name'])>{{ $p['name'] }}</option>@endforeach
                </optgroup>
            </select>
        </label>
        <label class="field">
            <span>Preferred Date</span>
            <input type="date" name="date" min="{{ now()->toDateString() }}" value="{{ old('date') }}">
        </label>
    </div>
    @unless ($compact)
        <label class="field">
            <span>Email <em>(optional)</em></span>
            <input type="email" name="email" placeholder="you@example.com" autocomplete="email" value="{{ old('email') }}">
        </label>
    @endunless
    <label class="field">
        <span>Message</span>
        <textarea name="message" rows="{{ $compact ? 2 : 3 }}" maxlength="2000" placeholder="Briefly describe your concern (optional)">{{ old('message') }}</textarea>
    </label>
    <p class="form__error" role="alert" @unless($errors->any()) hidden @endunless>{{ $errors->first() ?: 'Please enter your name and a valid phone number.' }}</p>
    <button type="submit" class="btn btn--primary btn--block btn--lg"><i class="bi bi-send"></i> <span>Request Appointment</span></button>
    <p class="form__note"><i class="bi bi-lock"></i> Your details are safe with us and used only to contact you.</p>
</form>
