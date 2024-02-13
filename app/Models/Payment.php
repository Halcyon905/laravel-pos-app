<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $attributes = [
        'payment_type' => 'unfinished',
    ];

    public function member(): BelongsTo {
        return $this->belongsTo(Member::class);
    }
}
