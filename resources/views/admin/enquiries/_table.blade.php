<div class="table-wrap">
<table class="table">
    <thead><tr><th>Patient</th><th>Department</th><th>Preferred date</th><th>Received</th><th>Status</th><th class="t-right">Actions</th></tr></thead>
    <tbody>
    @forelse ($enquiries as $e)
        <tr @class(['is-new' => $e->status === 'new'])>
            <td>
                <a href="{{ route('admin.enquiries.show', $e) }}" class="t-strong">{{ $e->name }}</a>
                <small class="t-sub"><a href="tel:{{ $e->phone }}">{{ $e->phone }}</a></small>
            </td>
            <td>{{ $e->department ?: '—' }}</td>
            <td>{{ optional($e->preferred_date)->format('d M Y') ?: '—' }}</td>
            <td><span title="{{ $e->created_at->format('d M Y, h:i A') }}">{{ $e->created_at->diffForHumans() }}</span></td>
            <td><span class="pill pill--{{ $e->status }}">{{ $e->status_label }}</span></td>
            <td class="t-right t-actions">
                <a href="tel:{{ $e->phone }}" class="icon-btn" title="Call"><i class="bi bi-telephone"></i></a>
                <a href="{{ $e->whatsapp_url }}" target="_blank" rel="noopener" class="icon-btn icon-btn--wa" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                <a href="{{ route('admin.enquiries.show', $e) }}" class="icon-btn" title="Open"><i class="bi bi-eye"></i></a>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="empty"><i class="bi bi-inbox"></i> No enquiries yet. Appointment requests from the website will appear here.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
