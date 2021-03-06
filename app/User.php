<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const SEX_GRIL = 0; // 女
    const SEX_BOY = 1;    //男
    const SEX_UN = 2;    //未知
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获取该用户的所有文章
     */
    public function ariticles()
    {
        return $this->hasMany(Ariticle::class);
    }

    /**
     * 处理性别的函数
     */
    public function sex($ind)
    {
        $arr = [
            self::SEX_BOY => '男',
            self::SEX_GRIL => '女',
            self::SEX_UN => '未知',
        ];
        return array_key_exists($ind, $arr) ? $arr[$ind] : $arr[self::SEX_UN];
    }

    /**
     * 处理头像信息
     */
    public function portrait($portrait)
    {
        return empty($portrait) ? 'home/img/pageHome/usericon02.png' : $portrait;
    }


}
