<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'address',
        'city_id',
        'province',
        'type',
        'city_name',
        'postal_code'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
