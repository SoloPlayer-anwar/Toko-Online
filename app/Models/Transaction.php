<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_transaction',
        'courier',
        'service',
        'description',
        'cost',
        'estimated',
        'status_transaction',
        'payment_type',
        'order_id',
        'token_payment'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'transaction_carts');
    }

    public function profiles()
    {
        return $this->users->profiles;
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
