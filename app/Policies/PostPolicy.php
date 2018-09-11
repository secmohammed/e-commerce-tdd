<?php

namespace App\Policies;

use App\User;
use \App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;
	public function approve(User $user,Post $post)
	{
		return $user->hasRole('approve-post') || $user->id == $post->user_id;
	}

    public function view(User $user, Post $post)
    {
        return $user->hasRole('view-post');
    }

    public function create(User $user)
    {
        return $user->hasRole('create-post');
    }

    public function update(User $user, Post $post)
    {
        return $user->hasRole('update-post') || $post->user_id == $user->id;
    }

    public function delete(User $user, Post $post)
    {
        return $user->hasRole('delete-post') || $post->user_id == $user->id;
    }
}
