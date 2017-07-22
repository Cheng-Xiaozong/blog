<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ariticle extends Model
{


    const SEX_BOY = 1; // 男
    const SEX_GRIL = 0;    //女
    const ARITICLE_STATUS_ENABLE = 0;    //文章状态(可用)
    const ARITICLE_STATUS_DISABLE = 1;    //文章状态(禁用)


    //容许批量赋值的字段
    protected $fillable = ['title','content','user_id','status'];

    /**
     * 获取该文章的作者
     */
   /* public function user()
    {
        return $this->belongsTo(User::class);
    }*/

}
