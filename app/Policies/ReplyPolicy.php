<?php

namespace App\Policies;

use App\User;
use \App\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;
	public function review(User $user)
	{
		return $user->hasRole('review-reply');
	}

    public function view(User $user, Reply $reply)
    {
        return $user->hasRole('view-reply');
    }

    public function create(User $user)
    {
        return $user->hasRole('create-reply');
    }

    public function update(User $user, Reply $reply)
    {
        return $user->hasRole('update-reply') || $reply->user_id == $user->id;
    }

    public function delete(User $user, Reply $reply)
    {
        return $user->hasRole('delete-reply') || $reply->user_id == $user->id;
    }
}
