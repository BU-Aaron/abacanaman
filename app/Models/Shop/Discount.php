<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_percentage',
        'start_date',
        'end_date',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /**
     * Get the product that owns the discount.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'shop_product_id');
    }
}
