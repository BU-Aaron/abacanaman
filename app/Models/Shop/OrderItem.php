<?php

namespace App\Models\Shop;

use App\Traits\SellerOwnsOrderItems;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    use SellerOwnsOrderItems;

    /**
     * @var string
     */
    protected $table = 'shop_order_items';

    /**
     * Get the product that this order item belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'shop_product_id');
    }
}
