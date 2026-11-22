<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    public const STATUSES = [
        'new'       => 'New',
        'contacted' => 'Contacted',
        'closed'    => 'Closed',
    ];

    protected $guarded = ['id'];

    protected $casts = ['preferred_date' => 'date'];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getWhatsappUrlAttribute(): string
    {
        $digits = preg_replace('/\D+/', '', $this->phone);
        if (strlen($digits) === 10) $digits = '91' . $digits;
        return 'https://wa.me/' . $digits;
    }
}
