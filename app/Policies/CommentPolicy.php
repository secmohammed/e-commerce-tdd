<?php

namespace App\Policies;

use App\User;
use \App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;
	public function review(User $user)
	{
		return $user->hasRole('review-comment');
	}

    public function view(User $user, Comment $comment)
    {
        return $user->hasRole('view-comment');
    }

    public function create(User $user)
    {
        return $user->hasRole('create-comment');
    }

    public function update(User $user, Comment $comment)
    {
        return $user->hasRole('update-comment') || $comment->user_id == $user->id;
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->hasRole('delete-comment') || $comment->user_id == $user->id;
    }
}
