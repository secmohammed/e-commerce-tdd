<?php

Route::get('/', [
	'uses' => 'HomeController@index',
	'as' => 'home',
]);

/* Authentication */
Route::group(['namespace' => 'Auth'], function () {
	Route::group(['middleware' => 'guest'], function () {
		Route::get('register', [
			'uses' => 'RegisterController@show',
			'as' => 'register',
		]);
		Route::post('register', [
			'uses' => 'RegisterController@store',
			'as' => 'register',
		]);
		Route::get('login', [
			'uses' => 'LoginController@show',
			'as' => 'login',
		]);
		Route::post('login', [
			'uses' => 'LoginController@login',
			'as' => 'login',
		]);
	});
	Route::group(['middleware' => 'auth'], function () {
		Route::resource('/profile', 'ProfileController')->except('index');
		Route::post('logout', [
			'uses' => 'LoginController@destroy',
			'as' => 'logout',
		]);
	});
});

/* Product Searching */
Route::post('search', [
	'uses' => 'SearchController@search',
	'as' => 'search',
]);
Route::group(['middleware' => 'auth'], function () {
	/* Cart */
	Route::get('cart', [
		'uses' => 'CartController@index',
		'as' => 'cart.index',
	]);
	Route::post('cart/{id}', [
		'uses' => 'CartController@store',
		'as' => 'cart.store',
	]);
	Route::put('cart/{id}', [
		'uses' => 'CartController@update',
		'as' => 'cart.update',
	]);
	Route::delete('cart/{id}', [
		'uses' => 'CartController@destroy',
		'as' => 'cart.destroy',
	]);

	/* Admin panel */

	/* Product Area */
	Route::resource('/product', 'ProductController');

	/* Checking out */
	Route::post('checkout', [
		'uses' => 'PurchaseController@create',
		'as' => 'checkout',
	]);
});

Route::get('/something', function () {
	// Bad
	if (auth()->user()->posts()->whereId($post->id)->exists()) {
		auth()->user()->posts()->whereId($post->id)->first()->update([
			'title' => 'somed-random-title',
		]);
	}
	// Good
	optional(auth()->user()->posts()->whereId($post->id)->first())->update([
		'title' => 'some-missing-title',
	]);

	// Also Good
	optional(auth()->user()->posts()->whereId($post->id)->first(), function ($post) {
		// You can do further complicated queries here now.
		$post->update(['title' => 'some-new-title']);
	});
});
