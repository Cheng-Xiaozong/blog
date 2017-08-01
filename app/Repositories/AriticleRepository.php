<?php

namespace App\Repositories;

use App\AriticleComment;
use App\AriticlePraise;
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
        $ariticles=Ariticle::where('user_id', $user_id)
            ->orderBy('created_at', 'asc')
            ->paginate($num);
        foreach ($ariticles as $key => $value)
        {
            $ariticles[$key]->comment_mum = CommentRepository::getCommentNum(AriticleComment::class,$value->id);
            $ariticles[$key]->praise_num =  self::getAriticlePraiseNum($value->id);
        }
        return $ariticles;
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
     * 根据ID获取文章,没有id显示最新文章
     * @param $id int
     * @return Collection
     */

    public static function getAriticleById($id=null)
    {
        $ariticle = empty($id) ? Ariticle::orderBy('id','desc')->first() : Ariticle::find($id);
        if(!empty($ariticle))
        {
            $ariticle->author = self::getAuthorByUserId($ariticle->user_id);
            $ariticle->comment_mum = CommentRepository::getCommentNum(AriticleComment::class,$ariticle->id);
            $ariticle->praise_num = self::getAriticlePraiseNum($ariticle->id);
        }
        return $ariticle;
    }

    /**
     * 获取文章ID
     */
    public static function getAriticleId($id=null)
    {
        $ariticle = empty($id) ? Ariticle::orderBy('id','desc')->first() : Ariticle::find($id);
        return $ariticle->id;
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

    /**
     * 博客点赞
     * @param $user_id int
     * @param $ariticle_id int
     * @return string success|error|repetition
     */
    public static function ariticlePraise($user_id,$ariticle_id)
    {
        $praise=AriticlePraise::whereRaw('user_id = ? and ariticle_id = ?',[$user_id,$ariticle_id])->get();
        if(!count($praise)){
            $data['user_id']=$user_id;
            $data['ariticle_id']=$ariticle_id;
            $result=AriticlePraise::create($data);
            return empty($result) ? 'error' : 'success';
        }else{
            return 'repetition';
        }
    }

    /**
     * 获取文章的点赞数
     */
    public static function getAriticlePraiseNum($ariticle_id)
    {
        return AriticlePraise::where('ariticle_id','=',$ariticle_id)->count();
    }


}