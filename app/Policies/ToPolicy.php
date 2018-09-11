<?php

namespace App\Policies;

use App\User;
use \App\To;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToPolicy
{
    use HandlesAuthorization;

    public function view(User $user, To $to)
    {
        return $user->hasRole('view-to');
    }

    public function create(User $user)
    {
        return $user->hasRole('create-to');
    }

    public function update(User $user, To $to)
    {
        return $user->hasRole('update-to') || $to->user_id == $user->id;
    }

    public function delete(User $user, To $to)
    {
        return $user->hasRole('delete-to') || $to->user_id == $user->id;
    }
}
