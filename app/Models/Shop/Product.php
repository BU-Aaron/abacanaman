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
     * Get the current price after applying any active discount
     *
     * @return float
     */
    public function getDiscountedPriceAttribute()
    {
        $activeDiscount = $this->activeDiscount;

        if ($activeDiscount) {
            $discountAmount = ($this->price * $activeDiscount->discount_percentage) / 100;
            return $this->price - $discountAmount;
        }

        return $this->price;
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
}
