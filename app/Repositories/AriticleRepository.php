<?php

namespace App\Repositories;

use App\User;
use App\Ariticle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;

class AriticleRepository
{
    use AuthorizesRequests;
    /**
     * 获取指定用户的所有文章
     *
     * @param  $user_id int,$num int
     * @return Collection
     */
    public static function getAriticleByUserId($user_id,$num)
    {
        return Ariticle::where('user_id', $user_id)
            ->orderBy('created_at', 'asc')
            ->paginate($num);
    }

    /**
     * 获取所有文章列表
     *
     * @param  $num int
     * @return Collection
     */
    public static function ariticleList($num)
    {
        return Ariticle::select('id','title')->paginate($num);
    }

    /**
     * 获取最新发表文章
     * @return Collection
     */

    public static function newAriticle()
    {
        $ariticle=Ariticle::orderBy('id','desc')->first();
        if(!empty($ariticle))
        {
            $ariticle->author = self::getAuthorByUserId($ariticle->user_id);
        }
        return $ariticle;
    }

    /**
     * 根据ID获取文章
     * @param $id int
     * @return Collection
     */

    public static function getAriticleById($id)
    {
        $ariticle =  Ariticle::find($id);
        if(!empty($ariticle))
        {
            $ariticle->author = self::getAuthorByUserId($ariticle->user_id);
            $ariticle->head_portrait = self::getHeadPortraitByUserId($ariticle->user_id);
        }
        return $ariticle;
    }

    /**
     *根据user_id 获取文章作者姓名
     * @param $user_id int
     * @return string
     */
    public static function getAuthorByUserId($user_id)
    {
        return UserRepository::getUserNameById($user_id);
    }

    /**
     *根据user_id 获取文章作者头像
     * @param $user_id int
     * @return string
     */
    public static function getHeadPortraitByUserId($user_id)
    {
        return UserRepository::getHeadPortraitById($user_id);
    }

    /**
     * 增加文章点击量
     * @param $id int
     * @return $num int
     */
    public static function addAriticleViews($id)
    {
        return Ariticle::find($id)->increment('views');

    }

    /**
     * 创建文章
     * @param $data array
     * @return bool
     */

    public static function create($data)
    {
        return Ariticle::create($data);
    }

    /**
     * 验证是否非法操作
     * @param $ariticle
     * @return \Illuminate\Auth\Access\Response
     */
    public function isAuthor($ariticle)
    {
        return $this->authorize('isAuthor', $ariticle);
    }

    /**
     * 删除文章
     * @param $id int
     * @return bool
     */
    public function delete($id)
    {
        $ariticle=Ariticle::find($id);
        $this->isAuthor($ariticle);
        return $ariticle->delete();
    }

    /**
     * 删除文章
     * @param $id int
     * @param $data array
     * @return $num
     */
    public function edit($id,$data)
    {
        $ariticle=Ariticle::find($id);
        $this->isAuthor($ariticle);
        return Ariticle::where('id','=',$id)->update($data);
    }


}