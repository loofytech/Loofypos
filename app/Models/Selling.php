<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    use HasFactory;

    public function store() {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function ProductSale() {
        return $this->belongsToMany(Product::class, 'product_sale', 'selling_id', 'product_id')
            ->withPivot('quantity', 'sub_total')
            ->withTimestamps();
    }
}
