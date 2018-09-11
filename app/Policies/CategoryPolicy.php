<?php

namespace App\Policies;

use App\User;
use \App\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Category $category)
    {
        return $user->hasRole('view-category');
    }

    public function create(User $user)
    {
        return $user->hasRole('create-category');
    }

    public function update(User $user, Category $category)
    {
        return $user->hasRole('update-category') || $category->user_id == $user->id;
    }

    public function delete(User $user, Category $category)
    {
        return $user->hasRole('delete-category') || $category->user_id == $user->id;
    }
}
