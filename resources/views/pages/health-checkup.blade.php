@extends('layouts.app')


@section('content')
@include('partials.page-hero', ['title' => 'Master Health Checkup', 'subtitle' => 'Detect risks early. Comprehensive screening packages with expert evaluation.'])

<section class="section">
    <div class="container">
        @include('partials.packages')

        <div class="note reveal">
            <i class="bi bi-info-circle"></i>
            <p>Please come fasting (8–10 hours) for blood sugar and lipid tests. Home sample collection is available — call our lab on
                <a href="tel:{{ config('anp.contact.lab_raw') }}">{{ config('anp.contact.lab') }}</a>.</p>
        </div>
    </div>
</section>

@include('partials.appointment')
@endsection
