<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Influencer_category extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'influencer_category';

    public function user()
    {
        // return $this->belongsTo(User::class, 'user_id');
        return $this->hasOne(User::class,'id', 'user_id');
    }
}
