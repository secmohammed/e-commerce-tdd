<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = config('artify.models.namespace').config('artify.models.role');
        $role = new $role();
        $admin = $role->create([
            'slug'        => 'admin',
            'name'        => 'Administrator',
            'permissions' => [
                'view-product'       => true,
                'update-product'     => true,
                'delete-product'     => true,
                'create-product'     => true,
                'review-product'    => true,
                'create-category'      => true,
                'update-category'      => true,
                'delete-category'      => true,
                'view-category'        => true,
                'view-comment'    => true,
                'update-comment'  => true,
                'delete-comment'  => true,
                'create-comment'  => true,
                'review-comment' => true,
                'view-reply'      => true,
                'update-reply'    => true,
                'delete-reply'    => true,
                'create-reply'    => true,
                'review-reply'   => true,
                'upgrade-user'    => true,
                'downgrade-user'  => true,
                'rate-product' => false,
                'add-cart' => true,
                'delete-cart' => true,
                'update-cart' => true,
                'delete_from_others-cart' => true,

            ],
        ]);
        $moderator = $role->create([
            'slug'        => 'moderator',
            'name'        => 'Moderator',
            'permissions' => [
                'create-product'     => true,
                'view-product'       => true,
                'delete-product'     => true,
                'update-product'     => true,
                'review-product'    => false,
                'create-category'      => true,
                'update-category'      => true,
                'view-category'        => true,
                'delete-category'      => true,
                'create-comment'  => true,
                'update-comment'  => true,
                'delete-comment'  => true,
                'view-comment'    => true,
                'review-comment' => true,
                'create-reply'    => true,
                'update-reply'    => true,
                'delete-reply'    => true,
                'view-reply'      => true,
                'review-reply'   => true,
                'upgrade-user'    => false,
                'downgrade-user'  => false,
                'rate-product' => true,
                'add-cart' => true,
                'delete-cart' => true,
                'update-cart' => true,
                'delete_from_others-cart' => false,
            ],
        ]);
        $user = $role->create([
            'name'        => 'Normal User',
            'slug'        => 'user',
            'permissions' => [
                'create-product'     => false,
                'view-product'       => true,
                'update-product'     => false,
                'delete-product'     => false,
                'review-product'    => false,
                'create-category'      => false,
                'view-category'        => false,
                'update-category'      => false,
                'delete-category'      => false,
                'create-comment'  => true,
                'update-comment'  => true,
                'view-comment'    => true,
                'delete-comment'  => true,
                'review-comment' => false,
                'create-reply'    => true,
                'update-reply'    => true,
                'view-reply'      => true,
                'delete-reply'    => true,
                'review-reply'   => false,
                'upgrade-user'    => false,
                'downgrade-user'  => false,
                'rate-product' => true,
                'add-cart' => true,
                'delete-cart' => true,
                'update-cart' => true,
                'delete_from_others-cart' => false,

            ],
        ]);
    }
}
