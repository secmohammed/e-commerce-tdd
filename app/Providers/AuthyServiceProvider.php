<?php

namespace App\Providers;
use \App\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Product::class => \App\Policies\ProductPolicy::class,
		\App\Category::class => \App\Policies\CategoryPolicy::class,
		\App\Comment::class => \App\Policies\CommentPolicy::class,
		\App\Reply::class => \App\Policies\ReplyPolicy::class,
		\App\User::class => \App\Policies\UserPolicy::class,
		\App\Cart::class => \App\Policies\CartPolicy::class,
		
    ];
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('view-product','\App\Policies\ProductPolicy@view');
		Gate::define('update-product','\App\Policies\ProductPolicy@update');
		Gate::define('delete-product','\App\Policies\ProductPolicy@delete');
		Gate::define('create-product','\App\Policies\ProductPolicy@create');
		Gate::define('review-product','\App\Policies\ProductPolicy@review');
		Gate::define('rate-product','\App\Policies\ProductPolicy@rate');
		Gate::define('create-category','\App\Policies\CategoryPolicy@create');
		Gate::define('update-category','\App\Policies\CategoryPolicy@update');
		Gate::define('delete-category','\App\Policies\CategoryPolicy@delete');
		Gate::define('view-category','\App\Policies\CategoryPolicy@view');
		Gate::define('view-comment','\App\Policies\CommentPolicy@view');
		Gate::define('update-comment','\App\Policies\CommentPolicy@update');
		Gate::define('delete-comment','\App\Policies\CommentPolicy@delete');
		Gate::define('create-comment','\App\Policies\CommentPolicy@create');
		Gate::define('review-comment','\App\Policies\CommentPolicy@review');
		Gate::define('view-reply','\App\Policies\ReplyPolicy@view');
		Gate::define('update-reply','\App\Policies\ReplyPolicy@update');
		Gate::define('delete-reply','\App\Policies\ReplyPolicy@delete');
		Gate::define('create-reply','\App\Policies\ReplyPolicy@create');
		Gate::define('review-reply','\App\Policies\ReplyPolicy@review');
		Gate::define('upgrade-user','\App\Policies\UserPolicy@upgrade');
		Gate::define('downgrade-user','\App\Policies\UserPolicy@downgrade');
		Gate::define('add-cart','\App\Policies\CartPolicy@add');
		Gate::define('delete-cart','\App\Policies\CartPolicy@delete');
		Gate::define('update-cart','\App\Policies\CartPolicy@update');
		Gate::define('delete_from_others-cart','\App\Policies\CartPolicy@delete_from_others');
		
    }
}
