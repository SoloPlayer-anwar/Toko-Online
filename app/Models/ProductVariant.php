<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'variant_name',
        'image_product',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('UTC')->setTimezone('Asia/Makassar')->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('UTC')->setTimezone('Asia/Makassar')->format('Y-m-d H:i');
    }

    public function getImageProductAttribute($value)
    {
        return env('ASSET_URL'). "/uploads/".$value;
    }
}
