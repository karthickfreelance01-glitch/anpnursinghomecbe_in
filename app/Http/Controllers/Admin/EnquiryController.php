<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnquiryController extends Controller
{
    private function filtered(Request $r)
    {
        $q = Enquiry::query()->latest();
        if (array_key_exists($r->get('status'), Enquiry::STATUSES)) $q->where('status', $r->get('status'));
        if ($s = trim((string) $r->get('q'))) {
            $q->where(fn ($w) => $w->where('name', 'like', "%{$s}%")->orWhere('phone', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")->orWhere('department', 'like', "%{$s}%"));
        }
        if ($d = $r->get('from')) $q->whereDate('created_at', '>=', $d);
        if ($d = $r->get('to')) $q->whereDate('created_at', '<=', $d);

        return $q;
    }

    public function index(Request $r)
    {
        return view('admin.enquiries.index', [
            'enquiries' => $this->filtered($r)->paginate(20)->withQueryString(),
            'counts'    => Enquiry::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status'),
        ]);
    }

    public function show(Enquiry $enquiry)
    {
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function update(Request $r, Enquiry $enquiry)
    {
        $v = $r->validate([
            'status'     => ['required', Rule::in(array_keys(Enquiry::STATUSES))],
            'admin_note' => ['nullable', 'string', 'max:3000'],
        ]);
        $enquiry->update($v);

        return back()->with('ok', 'Enquiry updated.');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('ok', 'Enquiry deleted.');
    }

    public function export(Request $r)
    {
        $rows = $this->filtered($r)->get();
        $name = 'anp-enquiries-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($out, ['ID', 'Date', 'Name', 'Phone', 'Email', 'Department', 'Preferred Date', 'Message', 'Status', 'Note', 'Page']);
            foreach ($rows as $e) {
                fputcsv($out, array_map(fn ($v) => is_string($v) && preg_match('/^[=+\-@]/', $v) ? "'" . $v : $v, [
                    $e->id, $e->created_at->format('d-m-Y H:i'), $e->name, $e->phone, $e->email, $e->department,
                    optional($e->preferred_date)->format('d-m-Y'), $e->message, $e->status_label, $e->admin_note, $e->source,
                ]));
            }
            fclose($out);
        }, $name, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
