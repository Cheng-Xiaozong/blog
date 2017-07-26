<?php

namespace App\Repositories;
use App\AriticleComment;
use App\User;
use Illuminate\Support\Collection;

class CommentRepository
{


    /**
     * 获取一级评论列表
     * @param   int $project_id
     * @return Collection
     */
    public static function getFloorComment($project_id)
    {
        $comments = AriticleComment::whereRaw('ariticle_id = ? and floor_id = ?',[$project_id,0])->get();
        foreach ($comments as $k =>$v)
        {
            $comments[$k]->user_name=UserRepository::getUserNameById($v->user_id);
            $comments[$k]->user_portrait=UserRepository::getHeadPortraitById($v->user_id);
            $comments[$k]->floor_detail_comment=self::getFloorDetailComment($v->id);
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








}