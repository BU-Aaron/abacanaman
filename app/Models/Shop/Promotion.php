<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_percentage',
        'description',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * The products that belong to the promotion.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_promotion');
    }
}