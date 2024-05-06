<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'cart_id',
    ];

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function carts()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
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
