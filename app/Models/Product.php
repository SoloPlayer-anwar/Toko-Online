<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name_product',
        'description',
        'price_product',
        'price_strike'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class , 'product_id', 'id');
    }

    public function rates()
    {
        return $this->hasMany(Rate::class, 'product_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('UTC')->setTimezone('Asia/Makassar')->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('UTC')->setTimezone('Asia/Makassar')->format('Y-m-d H:i');
    }
}
