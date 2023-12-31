<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class User_Reels extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'user_reels';

    

    public function reels()
    {
        return $this->hasOne(Reels::class,'id', 'reels_id');
    }
}
