<?php

namespace App\Policies;

use App\User;
use \App\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Tag $tag)
    {
        return $user->hasRole('view-tag');
    }

    public function create(User $user)
    {
        return $user->hasRole('create-tag');
    }

    public function update(User $user, Tag $tag)
    {
        return $user->hasRole('update-tag') || $tag->user_id == $user->id;
    }

    public function delete(User $user, Tag $tag)
    {
        return $user->hasRole('delete-tag') || $tag->user_id == $user->id;
    }
}
