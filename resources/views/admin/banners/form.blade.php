@extends('admin.layout')
@section('title', $banner->exists ? 'Edit banner' : 'Add banner')
@section('subtitle', 'Use a 2:1 image (1600×800). Keep important text away from the edges.')
@section('actions')
    <a href="{{ route('admin.banners.index') }}" class="b b--ghost"><i class="bi bi-arrow-left"></i> Back</a>
@endsection

@section('content')
<form method="POST" action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}" enctype="multipart/form-data" class="form-grid">
    @csrf
    @if ($banner->exists) @method('PUT') @endif
    <div class="form-grid__main">
        <section class="card">
            @include('admin.partials.image-field', ['name' => 'image', 'label' => 'Banner image * (desktop, 1600×800)', 'value' => $banner->image, 'removable' => false])
            @include('admin.partials.image-field', ['name' => 'mobile_image', 'label' => 'Mobile image (optional, e.g. 800×800)', 'value' => $banner->mobile_image])
        </section>
    </div>
    <aside class="form-grid__side">
        <section class="card sticky">
            <label class="f"><span>Title</span><input type="text" name="title" value="{{ old('title', $banner->title) }}" maxlength="200" placeholder="Happy New Year 2026"></label>
            <label class="f"><span>Alt text <em>for SEO &amp; screen readers</em></span><input type="text" name="alt" value="{{ old('alt', $banner->alt) }}" maxlength="200"></label>
            <label class="f"><span>Link <em>optional</em></span><input type="text" name="link" value="{{ old('link', $banner->link) }}" maxlength="255" placeholder="/departments/diabetologist"></label>
            <label class="f"><span>Display order</span><input type="number" min="0" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}"></label>
            <label class="switch"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner->is_active))><span></span> Show in slider</label>
            <button class="b b--primary b--block b--lg"><i class="bi bi-check2-circle"></i> Save banner</button>
        </section>
    </aside>
</form>
@endsection
