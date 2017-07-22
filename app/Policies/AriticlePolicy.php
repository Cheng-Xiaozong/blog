<?php

namespace App\Policies;

use App\Ariticle;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AriticlePolicy
{
    use HandlesAuthorization;

    /**
     * 判断指定用户是否可以删除指定的文章
     *
     * @param  User  $user
     * @param  Ariticle  $ariticle
     * @return bool
     */
    public function isAuthor(User $user, Ariticle $ariticle)
    {
        return $user->id === $ariticle->user_id;
    }


}
