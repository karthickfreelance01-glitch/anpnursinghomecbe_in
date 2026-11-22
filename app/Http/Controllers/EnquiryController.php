<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot – bots fill hidden fields, people don't.
        if (filled($request->input('website'))) {
            return $this->respond($request, true);
        }

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'phone'   => ['required', 'string', 'regex:/^[0-9+\s\-]{10,16}$/'],
            'email'   => ['nullable', 'email', 'max:150'],
            'dept'    => ['nullable', 'string', 'max:150'],
            'date'    => ['nullable', 'date', 'after_or_equal:today'],
            'message' => ['nullable', 'string', 'max:2000'],
            'source'  => ['nullable', 'string', 'max:255'],
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number.',
            'date.after_or_equal' => 'Please choose today or a future date.',
        ]);

        $enquiry = Enquiry::create([
            'name'           => strip_tags($data['name']),
            'phone'          => $data['phone'],
            'email'          => $data['email'] ?? null,
            'department'     => isset($data['dept']) ? strip_tags($data['dept']) : null,
            'preferred_date' => $data['date'] ?? null,
            'message'        => isset($data['message']) ? strip_tags($data['message']) : null,
            'source'         => Str::limit($data['source'] ?? $request->headers->get('referer', ''), 250, ''),
            'ip'             => $request->ip(),
            'user_agent'     => Str::limit((string) $request->userAgent(), 490, ''),
        ]);

        return $this->respond($request, true, $enquiry);
    }

    private function respond(Request $request, bool $ok, ?Enquiry $enquiry = null)
    {
        $msg = 'Your appointment request has been received. Our front desk will call you shortly to confirm the time.';

        return $request->expectsJson()
            ? response()->json([
                'ok'      => $ok,
                'message' => $msg,
                'ref'     => $enquiry ? 'ANP-' . str_pad($enquiry->id, 5, '0', STR_PAD_LEFT) : null,
            ])
            : back()->with('enquiry_success', $msg);
    }
}
