<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AriticlePraise extends Model
{
    //容许批量赋值的字段
    protected $fillable = ['user_id','ariticle_id'];
}
