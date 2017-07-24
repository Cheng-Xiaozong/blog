<?php

namespace App\Repositories;

use App\User;
use App\Ariticle;
use Auth;
use Illuminate\Support\Collection;

class UserRepository
{

    /**
     * 根据ID获取用户
     * @param $id int
     * @return Collection
     */
    public static function getUserById($id)
    {
        return User::find($id);
    }

    /**
     * 根据ID获取用户名
     * @param $id int
     * @return Collection
     */
    public static function getUserNameById($id)
    {
        return User::find($id)->name;
    }

    /**
     * 获取当前用户的id
     * @return $user_id int
     */
    public static function getUserId()
    {
        return Auth::user()->id;
    }

    /**
     * 根据ID获取用户名
     * @param $id int
     * @return Collection
     */
    public static function getHeadPortraitById($id)
    {
        return User::find($id)->head_portrait;
    }

    /**
     * 更换头像
     * @param $filename string
     * @return $bool
     */
    public static function updatePt($filename)
    {
        $user = User::find(self::getUserId());
        $user->head_portrait=$filename;
        return $user->save();
    }

    /**
     * 修改资料
     * @param $data array
     * $return $num
     */
    public static function updateMyInfo($data)
    {
        return User::where('id','=',self::getUserId())->update($data);
    }





}