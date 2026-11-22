@extends('admin.layout')
@php
    $isSpec = $base === 'admin.specialities';
    $editing = $item->exists;
    $faqs = old('faqs', $item->faqs ?: []);
    if (count($faqs) === 0) $faqs = [['q' => '', 'a' => '']];
    $icons = ['bi-heart-pulse','bi-heart','bi-clipboard2-pulse','bi-activity','bi-droplet','bi-droplet-half','bi-lungs','bi-capsule','bi-scissors','bi-bandaid','bi-gender-female','bi-flower1','bi-emoji-smile','bi-person-walking','bi-person-arms-up','bi-ear','bi-eye','bi-lightning-charge','bi-virus','bi-shield-plus','bi-soundwave','bi-stars','bi-balloon-heart','bi-hospital'];
@endphp
@section('title', $editing ? 'Edit ' . $item->name : 'Add ' . strtolower($label))
@section('subtitle', $editing ? 'Changes go live on the website as soon as you save.' : 'Fill in the details below — a landing page is created automatically.')
@section('actions')
    <a href="{{ route($base . '.index', $isSpec ? ['category' => $item->category] : []) }}" class="b b--ghost"><i class="bi bi-arrow-left"></i> Back</a>
    @if ($editing)<a href="{{ $item->url }}" target="_blank" class="b b--ghost"><i class="bi bi-box-arrow-up-right"></i> View page</a>@endif
@endsection

@section('content')
<form method="POST" action="{{ $editing ? route($base . '.update', $item) : route($base . '.store') }}" enctype="multipart/form-data" class="form-grid" id="landingForm">
    @csrf
    @if ($editing) @method('PUT') @endif

    <div class="form-grid__main">
        <section class="card">
            <div class="card__head"><h3><i class="bi bi-info-circle"></i> Basic details</h3></div>
            <div class="row-2">
                <label class="f"><span>Name *</span><input type="text" name="name" value="{{ old('name', $item->name) }}" required maxlength="150" data-slug-source></label>
                <label class="f"><span>URL slug</span>
                    <div class="f__prefix"><em>/{{ $isSpec ? 'speciality' : 'departments' }}/</em><input type="text" name="slug" value="{{ old('slug', $item->slug) }}" maxlength="160" data-slug-target placeholder="auto from name"></div>
                </label>
            </div>
            <label class="f"><span>Tagline <em>shown under the title</em></span><input type="text" name="tagline" value="{{ old('tagline', $item->tagline) }}" maxlength="200" placeholder="e.g. Better sugar control. Fewer complications."></label>
            <label class="f"><span>Short description <em>cards, hero &amp; menus</em></span><textarea name="short_description" rows="3" maxlength="600" data-count>{{ old('short_description', $item->short_description) }}</textarea></label>

            <div class="f">
                <span>Full description <em>landing page overview</em></span>
                <div class="editor" data-editor="description"></div>
                <textarea name="description" class="editor-source" rows="10">{{ old('description', $item->description) }}</textarea>
            </div>
        </section>

        <section class="card">
            <div class="card__head"><h3><i class="bi bi-ui-checks-grid"></i> Treatments &amp; services</h3></div>
            <label class="f"><span>One service per line</span><textarea name="services" rows="7" placeholder="ECG, Echo &amp; TMT&#10;Chest pain care&#10;…">{{ old('services', implode("\n", $item->services ?? [])) }}</textarea></label>
        </section>

        <section class="card">
            <div class="card__head">
                <h3><i class="bi bi-question-circle"></i> FAQs <em class="muted">— also added to Google as FAQ rich results</em></h3>
                <button type="button" class="b b--ghost b--sm" data-faq-add><i class="bi bi-plus-lg"></i> Add FAQ</button>
            </div>
            <div class="faqs" data-faqs>
                @foreach ($faqs as $i => $f)
                    <div class="faq">
                        <div class="faq__fields">
                            <input type="text" name="faqs[{{ $i }}][q]" value="{{ $f['q'] ?? '' }}" placeholder="Question">
                            <textarea name="faqs[{{ $i }}][a]" rows="2" placeholder="Answer">{{ $f['a'] ?? '' }}</textarea>
                        </div>
                        <button type="button" class="icon-btn icon-btn--danger" data-faq-remove title="Remove"><i class="bi bi-x-lg"></i></button>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="card">
            <div class="card__head"><h3><i class="bi bi-google"></i> SEO</h3><span class="muted">Leave blank to auto-generate from the name &amp; short description.</span></div>
            <div class="serp" data-serp>
                <span class="serp__url">{{ preg_replace('#^https?://#', '', url('/')) }} › {{ $isSpec ? 'speciality' : 'departments' }} › <b data-serp-slug>{{ $item->slug ?: 'page' }}</b></span>
                <span class="serp__title" data-serp-title></span>
                <span class="serp__desc" data-serp-desc></span>
            </div>
            <label class="f"><span>Meta title <em data-counter-for="meta_title"></em></span><input type="text" name="meta_title" value="{{ old('meta_title', $item->meta_title) }}" maxlength="255" data-max="60" placeholder="{{ $item->name ?: 'Cardiology' }} in Coimbatore | ANP Nursing Home"></label>
            <label class="f"><span>Meta description <em data-counter-for="meta_description"></em></span><textarea name="meta_description" rows="3" maxlength="500" data-max="160">{{ old('meta_description', $item->meta_description) }}</textarea></label>
            <label class="f"><span>Meta keywords <em>comma separated</em></span><input type="text" name="meta_keywords" value="{{ old('meta_keywords', $item->meta_keywords) }}" maxlength="500"></label>
            @include('admin.partials.image-field', ['name' => 'og_image', 'label' => 'Social share image (Open Graph) – 1200×630', 'value' => $item->og_image])
        </section>
    </div>

    <aside class="form-grid__side">
        <section class="card sticky">
            <div class="card__head"><h3><i class="bi bi-toggles"></i> Publish</h3></div>
            <label class="switch"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active))><span></span> Live on website</label>
            @unless ($isSpec)
                <label class="switch"><input type="checkbox" name="show_in_menu" value="1" @checked(old('show_in_menu', $item->show_in_menu))><span></span> Show in Departments menu</label>
            @endunless
            @if ($isSpec)
                <label class="f"><span>Category *</span>
                    <select name="category" required>
                        @foreach (\App\Models\Speciality::CATEGORIES as $k => $v)<option value="{{ $k }}" @selected(old('category', $item->category) === $k)>{{ $v }}</option>@endforeach
                    </select>
                </label>
            @endif
            <label class="f"><span>Display order</span><input type="number" name="sort_order" min="0" value="{{ old('sort_order', $item->sort_order) }}"></label>
            <button class="b b--primary b--block b--lg"><i class="bi bi-check2-circle"></i> {{ $editing ? 'Save changes' : 'Create ' . strtolower($label) }}</button>
        </section>

        <section class="card">
            <div class="card__head"><h3><i class="bi bi-emoji-smile"></i> Icon</h3></div>
            <label class="f"><div class="f__icon"><i class="bi {{ $item->icon_class }}" data-icon-preview></i><input type="text" name="icon" value="{{ old('icon', $item->icon) }}" placeholder="bi-heart-pulse" data-icon-input></div></label>
            <div class="icon-pick">
                @foreach ($icons as $ic)<button type="button" data-icon="{{ $ic }}" title="{{ $ic }}"><i class="bi {{ $ic }}"></i></button>@endforeach
            </div>
            <a class="muted small" href="https://icons.getbootstrap.com/" target="_blank" rel="noopener">Browse all Bootstrap Icons ↗</a>
        </section>

        <section class="card">
            <div class="card__head"><h3><i class="bi bi-image"></i> Images</h3></div>
            @include('admin.partials.image-field', ['name' => 'image', 'label' => 'Card image (cards & listings) – 640×438', 'value' => $item->image])
            @include('admin.partials.image-field', ['name' => 'banner_image', 'label' => 'Landing page hero image – 1200×820', 'value' => $item->banner_image])
        </section>
    </aside>
</form>
@endsection

@push('head')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
@endpush
