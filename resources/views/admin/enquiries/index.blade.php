@extends('admin.layout')
@section('title', 'Enquiries')
@section('subtitle', 'Appointment requests submitted from the website.')
@section('actions')
    <a href="{{ route('admin.enquiries.export', request()->query()) }}" class="b b--ghost"><i class="bi bi-download"></i> Export CSV</a>
@endsection

@section('content')
<div class="tabs-row">
    <a href="{{ route('admin.enquiries.index') }}" @class(['active' => !request('status')])>All <b>{{ $counts->sum() }}</b></a>
    @foreach (\App\Models\Enquiry::STATUSES as $k => $v)
        <a href="{{ route('admin.enquiries.index', ['status' => $k] + request()->except('status', 'page')) }}" @class(['active' => request('status') === $k])>{{ $v }} <b>{{ $counts[$k] ?? 0 }}</b></a>
    @endforeach
</div>

<form class="card filters" method="GET">
    @if (request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
    <label class="f f--grow"><span>Search</span><div class="f__icon"><i class="bi bi-search"></i><input type="search" name="q" value="{{ request('q') }}" placeholder="Name, phone, email or department"></div></label>
    <label class="f"><span>From</span><input type="date" name="from" value="{{ request('from') }}"></label>
    <label class="f"><span>To</span><input type="date" name="to" value="{{ request('to') }}"></label>
    <div class="filters__btns">
        <button class="b b--primary"><i class="bi bi-funnel"></i> Filter</button>
        @if (request()->hasAny(['q', 'from', 'to']))<a href="{{ route('admin.enquiries.index', request()->only('status')) }}" class="b b--ghost">Reset</a>@endif
    </div>
</form>

<section class="card">
    @include('admin.enquiries._table')
    <div class="pager">{{ $enquiries->links() }}</div>
</section>
@endsection
