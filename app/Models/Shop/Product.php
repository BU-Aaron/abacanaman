<?php

namespace App\Models\Shop;

use App\Models\Comment;
use App\Models\User;
use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Shop\Promotion;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Multitenantable;

    /**
     * @var string
     */
    protected $table = 'shop_products';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'featured' => 'boolean',
        'is_visible' => 'boolean',
        'backorder' => 'boolean',
        'requires_shipping' => 'boolean',
        'published_at' => 'date',
    ];

    /** @return BelongsTo<Brand,self> */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'shop_brand_id');
    }

    /** @return BelongsToMany<Category> */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'shop_category_product', 'shop_product_id', 'shop_category_id')->withTimestamps();
    }

    /** @return MorphMany<Comment> */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /** @return BelongsTo<User> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo<Seller, self>
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    /**
     * Get the discounts for the product.
     */
    public function discounts()
    {
        return $this->hasMany(Discount::class, 'shop_product_id');
    }

    /**
     * Get the active discount based on current date.
     */
    public function activeDiscount()
    {
        return $this->hasOne(Discount::class, 'shop_product_id')
            ->where('is_verified', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->latest();
    }

    /**
     * Get the active promotions based on the current date.
     */
    public function activePromotions()
    {
        return $this->promotions()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Calculate the total discount percentage by combining discount and promotions.
     *
     * @return float
     */
    public function getTotalDiscountPercentageAttribute()
    {
        $discount = $this->activeDiscount?->discount_percentage ?? 0;
        $promotionDiscount = $this->activePromotions()->sum('discount_percentage');

        // Ensure the total discount does not exceed 100%
        return min($discount + $promotionDiscount, 100);
    }

    /**
     * Get the current price after applying any active discount
     *
     * @return float
     */
    public function getDiscountedPriceAttribute()
    {
        $totalDiscount = $this->total_discount_percentage;
        return $this->price - ($this->price * ($totalDiscount / 100));
    }

    /**
     * Check if the product has an active discount
     *
     * @return bool
     */
    public function getHasActiveDiscountAttribute()
    {
        return $this->activeDiscount()->exists();
    }

    /**
     * Get the active discount percentage
     *
     * @return float|null
     */
    public function getActiveDiscountPercentageAttribute()
    {
        return $this->activeDiscount?->discount_percentage;
    }

    /**
     * The promotions that the product is part of.
     */
    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'product_promotion');
    }

    /**
     * Check if the product has any active discounts or promotions.
     *
     * @return bool
     */
    public function getHasTotalActiveDiscountAttribute()
    {
        return $this->total_discount_percentage > 0;
    }
}
