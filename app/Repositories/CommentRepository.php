<?php

namespace App\Repositories;
use App\AriticleComment;
use App\AriticleCommentPraise;
use Illuminate\Support\Collection;

class CommentRepository
{
    /**
     * 根据文章获取评论列表
     * @param   int $project_id
     * @return Collection
     */
    public static function getComment($project_id)
    {
        $comments = AriticleComment::whereRaw('ariticle_id = ? and floor_id = ?',[$project_id,0])->take(5)->get();
        foreach ($comments as $k =>$v)
        {
            $comments[$k]->user_name=UserRepository::getUserNameById($v->user_id);
            $comments[$k]->praises=CommentRepository::getCommentPraiseNum($v->id);
            $comments[$k]->user_portrait=UserRepository::getHeadPortraitById($v->user_id);
            $comments[$k]->num=self::getFloorNum($v->id);
        }
        return $comments;
    }

    /**
     * 根据文章获取评论更多列表
     * @param   int $last_id
     * @return Collection
     */
    public static function commentsMore($project_id,$last_id)
    {
        $comments = AriticleComment::whereRaw('ariticle_id = ? and floor_id = ? and id > ?',[$project_id,0,$last_id])->take(5)->get();
        foreach ($comments as $k =>$v)
        {
            $comments[$k]->user_name=UserRepository::getUserNameById($v->user_id);
            $comments[$k]->praises=CommentRepository::getCommentPraiseNum($v->id);
            $comments[$k]->user_portrait=UserRepository::getHeadPortraitById($v->user_id);
            $comments[$k]->num=self::getFloorNum($v->id);
        }
        return $comments;
    }

    /**
     * 获取一级评论下的子列表列表
     * @param   int $floor_id
     * @return Collection
     */
      public static function getFloorDetailComment($floor_id)
      {
          $floors=AriticleComment::whereRaw('floor_id = ? and floor_id != ?',[$floor_id,0])->get();
          foreach ($floors as $key => $value)
          {
              $floors[$key]->user_name=UserRepository::getUserNameById($value->user_id);
              $floors[$key]->user_portrait=UserRepository::getHeadPortraitById($value->user_id);
              if($value->parent_user_id!=0)
              {
                  $floors[$key]->parent_user_name=UserRepository::getUserNameById($value->parent_user_id);
              }
          }
          return $floors;
      }

    /**
      * 获取楼层评论总数
      * @param int $floor_id
      * @return int $num
      */
      public static function getFloorNum($floor_id)
      {
            return AriticleComment::whereRaw('floor_id = ? and floor_id != ?',[$floor_id,0])->count();
      }

    /**
     * 根据文章获取
     * @param int $project_id
     * @return int $num
     */
    public static function getCommentNum($project_id)
    {
        return AriticleComment::whereRaw('ariticle_id = ?',[$project_id])->count();
    }

    /**
     * 添加评论
     * @param array $data
     * @return Collection
     */
    public static function createComment($data)
    {
        return AriticleComment::create($data);
    }

    /**
     * 删除主楼评论
     * @param int $id
     * @return bool
     */
    public static function deleteComment($id)
    {
        $comment = AriticleComment::find($id);
        if($comment->user_id!=UserRepository::getUserId()){
            return false;
        }else{
           if($comment->delete()){
               AriticleComment::where('floor_id','=',$id)->delete();
               return ture;
           }else{
               return false;
           }
        }
    }

    /**
     * 删除回复评论
     * @param int $id
     * @return bool
     */
    public static function deleteFloorComment($id)
    {
        $comment = AriticleComment::find($id);
        if($comment->user_id!=UserRepository::getUserId()){
            return false;
        }else{
            return $comment->delete();
        }
    }

    /**
     * 评论点赞
     * @param $user_id int
     * @param $comment_id int
     * @return string success|error|repetition
     */
    public static function commentPraise($user_id,$comment_id)
    {
        $praise=AriticleCommentPraise::whereRaw('user_id = ? and ariticle_id = ?',[$user_id,$comment_id])->get();
        if(!count($praise)){
            $data['user_id']=$user_id;
            $data['comment_id']=$comment_id;
            $result=AriticleCommentPraise::create($data);
            return empty($result) ? 'error' : 'success';
        }else{
            return 'repetition';
        }
    }

    /**
     * 获取评论点赞数
     * @param $comment_id int
     * @return int $num
     */
    public static function getCommentPraiseNum($comment_id)
    {
        return AriticleCommentPraise::where('comment_id','=',$comment_id)->count();
    }




}