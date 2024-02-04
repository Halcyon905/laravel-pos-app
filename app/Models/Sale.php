<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $attributes = [
        'payment_confirm' => 0,
        'total' => 0,
    ];

    public function sales_line_item(): HasMany {
        return $this->hasMany(SalesLineItem::class);
    }
}
