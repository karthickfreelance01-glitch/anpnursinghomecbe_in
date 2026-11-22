@extends('admin.layout')
@php
    $isSpec = $base === 'admin.specialities';
    $cat = $category ?? null;
    $title = $isSpec ? ($cat ? \App\Models\Speciality::CATEGORIES[$cat] : 'Specialities') : 'Departments';
@endphp
@section('title', $title)
@section('subtitle', $isSpec ? 'Each speciality has its own landing page and appears in the menu, footer and appointment form.' : 'Departments appear in the Departments menu, the home page and have their own landing page.')
@section('actions')
    <a href="{{ route($base . '.create', $cat ? ['category' => $cat] : []) }}" class="b b--primary"><i class="bi bi-plus-lg"></i> Add {{ strtolower($label) }}</a>
@endsection

@section('content')
@if ($isSpec)
    <div class="tabs-row">
        <a href="{{ route($base . '.index') }}" @class(['active' => !$cat])>All</a>
        @foreach (\App\Models\Speciality::CATEGORIES as $k => $v)
            <a href="{{ route($base . '.index', ['category' => $k]) }}" @class(['active' => $cat === $k])>{{ $v }}</a>
        @endforeach
    </div>
@endif

<section class="card">
    <form class="card__head" method="GET">
        @if ($cat)<input type="hidden" name="category" value="{{ $cat }}">@endif
        <h3>{{ $items->count() }} {{ \Illuminate\Support\Str::plural(strtolower($label), $items->count()) }}</h3>
        <div class="f__icon f__icon--sm"><i class="bi bi-search"></i><input type="search" name="q" value="{{ request('q') }}" placeholder="Search…"></div>
    </form>
    <div class="table-wrap">
    <table class="table">
        <thead><tr><th style="width:90px">Image</th><th>Name</th>@if($isSpec)<th>Category</th>@endif<th>SEO</th><th>Order</th><th>Status</th><th class="t-right">Actions</th></tr></thead>
        <tbody>
        @forelse ($items as $item)
            <tr>
                <td>
                    @if ($item->image)<img src="{{ $item->image_url }}" alt="" class="thumb">
                    @else<span class="thumb thumb--icon"><i class="bi {{ $item->icon_class }}"></i></span>@endif
                </td>
                <td>
                    <a href="{{ route($base . '.edit', $item) }}" class="t-strong"><i class="bi {{ $item->icon_class }} t-icon"></i> {{ $item->name }}</a>
                    <small class="t-sub">/{{ $isSpec ? 'speciality' : 'departments' }}/{{ $item->slug }}</small>
                </td>
                @if($isSpec)<td><span class="pill pill--{{ $item->category }}">{{ ucfirst($item->category) }}</span></td>@endif
                <td>
                    @php($score = (int) filled($item->meta_title) + (int) filled($item->meta_description) + (int) filled($item->meta_keywords))
                    <span class="seo-dot seo-dot--{{ $score }}" title="{{ $score }}/3 SEO fields filled">{{ $score }}/3</span>
                </td>
                <td>{{ $item->sort_order }}</td>
                <td>
                    <span class="pill pill--{{ $item->is_active ? 'on' : 'off' }}">{{ $item->is_active ? 'Live' : 'Hidden' }}</span>
                    @if (!$isSpec && $item->show_in_menu)<span class="pill pill--menu" title="Shown in Departments menu">Menu</span>@endif
                </td>
                <td class="t-right t-actions">
                    <a href="{{ $item->url }}" target="_blank" class="icon-btn" title="View page"><i class="bi bi-box-arrow-up-right"></i></a>
                    <a href="{{ route($base . '.edit', $item) }}" class="icon-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route($base . '.destroy', $item) }}" data-confirm="Delete {{ $item->name }}? Its landing page will be removed.">
                        @csrf @method('DELETE')
                        <button class="icon-btn icon-btn--danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="empty"><i class="bi bi-folder2-open"></i> Nothing here yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</section>
@endsection
