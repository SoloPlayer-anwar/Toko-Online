<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_product_cart',
        'user_id',
        'total_price_cart',
        'status_cart',
        'quantity_cart',
        'variant_cart',
        'size_cart',
        'category_cart',
        'image_cart',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id' , 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('UTC')->setTimezone('Asia/Makassar')->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('UTC')->setTimezone('Asia/Makassar')->format('Y-m-d H:i');
    }

    public function getImageCartAttribute($value)
    {
        return env('ASSET_URL'). "/uploads/".$value;
    }
}
