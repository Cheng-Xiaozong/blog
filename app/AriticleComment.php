<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AriticleComment extends Model
{
    //容许批量赋值的字段
    protected $fillable = ['user_id','project_id','content','floor_id','parent_id','praises'];
}
