<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'shop_payments';

    protected $guarded = [];

    protected $fillable = [
        'order_id',
        'reference',
        'provider',
        'method',
        'amount',
        'currency',
        'receipt_image',
    ];

    /** @return BelongsTo<Order, self> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
