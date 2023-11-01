<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function capacityUnit()
    {
        return $this->belongsTo(CapacityUnit::class, 'capacity_unit');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }
}
