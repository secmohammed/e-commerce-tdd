<?php

namespace App\Policies;

use App\User;
use \App\From;
use Illuminate\Auth\Access\HandlesAuthorization;

class FromPolicy
{
    use HandlesAuthorization;

    public function view(User $user, From $from)
    {
        return $user->hasRole('view-from');
    }

    public function create(User $user)
    {
        return $user->hasRole('create-from');
    }

    public function update(User $user, From $from)
    {
        return $user->hasRole('update-from') || $from->user_id == $user->id;
    }

    public function delete(User $user, From $from)
    {
        return $user->hasRole('delete-from') || $from->user_id == $user->id;
    }
}
