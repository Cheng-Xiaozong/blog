<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AriticleCommentPraise extends Model
{
    //容许批量赋值的字段
    protected $fillable = ['user_id','comment_id'];
}
