<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Stock extends Model
{
    use HasFactory;
    

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
