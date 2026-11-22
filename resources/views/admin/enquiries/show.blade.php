@extends('admin.layout')
@section('title', 'Enquiry #' . $enquiry->id)
@section('subtitle', 'Received ' . $enquiry->created_at->format('d M Y, h:i A') . ' (' . $enquiry->created_at->diffForHumans() . ')')
@section('actions')
    <a href="{{ route('admin.enquiries.index') }}" class="b b--ghost"><i class="bi bi-arrow-left"></i> All enquiries</a>
@endsection

@section('content')
<div class="grid-2 grid-2--wide">
    <section class="card">
        <div class="person">
            <span class="person__avatar">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($enquiry->name, 0, 1)) }}</span>
            <div>
                <h2>{{ $enquiry->name }}</h2>
                <span class="pill pill--{{ $enquiry->status }}">{{ $enquiry->status_label }}</span>
            </div>
        </div>
        <dl class="details">
            <dt><i class="bi bi-telephone"></i> Phone</dt><dd><a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a></dd>
            <dt><i class="bi bi-envelope"></i> Email</dt><dd>{!! $enquiry->email ? '<a href="mailto:' . e($enquiry->email) . '">' . e($enquiry->email) . '</a>' : '—' !!}</dd>
            <dt><i class="bi bi-hospital"></i> Department</dt><dd>{{ $enquiry->department ?: '—' }}</dd>
            <dt><i class="bi bi-calendar-event"></i> Preferred date</dt><dd>{{ optional($enquiry->preferred_date)->format('l, d M Y') ?: '—' }}</dd>
            <dt><i class="bi bi-chat-left-text"></i> Message</dt><dd class="pre">{{ $enquiry->message ?: '—' }}</dd>
            <dt><i class="bi bi-link-45deg"></i> Sent from</dt><dd>@if($enquiry->source)<a href="{{ $enquiry->source }}" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::after($enquiry->source, '://') }}</a>@else — @endif</dd>
            <dt><i class="bi bi-pc-display"></i> IP</dt><dd class="muted">{{ $enquiry->ip ?: '—' }}</dd>
        </dl>
        <div class="btn-row">
            <a href="tel:{{ $enquiry->phone }}" class="b b--primary"><i class="bi bi-telephone"></i> Call patient</a>
            <a href="{{ $enquiry->whatsapp_url }}?text={{ rawurlencode('Hello ' . $enquiry->name . ', this is ANP Nursing Home regarding your appointment request' . ($enquiry->department ? ' for ' . $enquiry->department : '') . '.') }}" target="_blank" rel="noopener" class="b b--wa"><i class="bi bi-whatsapp"></i> WhatsApp</a>
        </div>
    </section>

    <section class="card">
        <div class="card__head"><h3><i class="bi bi-pencil-square"></i> Follow-up</h3></div>
        <form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}" class="stack">
            @csrf @method('PUT')
            <div class="seg">
                @foreach (\App\Models\Enquiry::STATUSES as $k => $v)
                    <label><input type="radio" name="status" value="{{ $k }}" @checked($enquiry->status === $k)><span>{{ $v }}</span></label>
                @endforeach
            </div>
            <label class="f"><span>Internal note</span><textarea name="admin_note" rows="5" placeholder="e.g. Called, appointment fixed for Monday 10 AM">{{ old('admin_note', $enquiry->admin_note) }}</textarea></label>
            <button class="b b--primary"><i class="bi bi-check2"></i> Save</button>
        </form>
        <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" class="danger-zone" data-confirm="Delete this enquiry permanently?">
            @csrf @method('DELETE')
            <button class="b b--danger-ghost b--sm"><i class="bi bi-trash"></i> Delete enquiry</button>
        </form>
    </section>
</div>
@endsection
