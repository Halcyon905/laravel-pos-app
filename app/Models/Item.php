<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $attributes = [
        'description' => "lorem ipsum",
        'stock' => 0,
        'price' => 0,
    ];

    public function sales_line_item(): HasMany {
        return $this->hasMany(SalesLineItem::class);
    }
}
