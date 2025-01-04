<?php

namespace App\Models;

use App\Models\Shop\Brand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    /** @return MorphToMany<User> */
    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'addressable');
    }

    /** @return MorphToMany<Brand> */
    public function brands(): MorphToMany
    {
        return $this->morphedByMany(Brand::class, 'addressable');
    }
}
