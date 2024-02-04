<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesLineItem extends Model
{
    use HasFactory;

    protected $attributes = [
        'total' => 0,
    ];

    public function sale(): BelongsTo {
        return $this->belongsTo(Sale::class);
    }

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class);
    }
}
