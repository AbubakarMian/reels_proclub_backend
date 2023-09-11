<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order';


    public function user()
    {
        // return $this->belongsTo(User::class, 'user_id');
        return $this->hasOne(User::class,'id', 'user_id');
    }
    public function influencer()
    {
        // return $this->belongsTo(User::class, 'user_id');
        return $this->hasOne(Influencer::class,'user_id', 'user_influencer_id');
    }
    public function payment()
    {
        // return $this->belongsTo(User::class, 'user_id');
        return $this->hasOne(Payment::class,'id', 'payment_id');
    }

    // public function user_influencer()
    // {
    //     // return $this->belongsTo(User::class, 'user_id');
    //     return $this->hasOne(User::class,'id', 'user_id');
    // }
}
