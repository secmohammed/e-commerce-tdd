<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(App\User::class, function (Faker $faker) {
	static $password;
	return [
		'username' => $faker->unique()->userName,
		'email' => $faker->unique()->safeEmail,
		'password' => $password ?: $password = bcrypt(123456789),
		'location' => 'Egypt',
		'remember_token' => str_random(10),
	];
});
$factory->define(App\Profile::class, function (Faker $faker) {
	return [
		'first_name' => $faker->name,
		'last_name' => $faker->name,
		'location' => $faker->country,
	];
});

$factory->define(App\Post::class, function (Faker $faker) {
	return [
		'title' => $faker->unique()->sentence,
		'body' => $faker->paragraph,
		'approved' => false,
		'approved_at' => $faker->dateTime->format('Y-m-d H:i:s'),
		'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
		'updated_at' => $faker->dateTime->format('Y-m-d H:i:s'),
	];
});

$factory->define(App\Comment::class, function (Faker $faker) {
	$posts_id = \DB::table('posts')->select('id')->get()->toArray();
	$users_id = \DB::table('users')->select('id')->get()->toArray();

	return [
		'post_id' => $faker->randomElement($posts_id)->id,
		'user_id' => $faker->randomElement($users_id)->id,
		'body' => $faker->paragraph,
		'approved' => true,
		'approved_by' => $faker->randomElement($users_id)->id,
		'approved_at' => $faker->dateTime->format('Y-m-d H:i:s'),
		'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
		'updated_at' => $faker->dateTime->format('Y-m-d H:i:s'),
	];
});
$factory->define(App\Reply::class, function (Faker $faker) {
	$comments_id = \DB::table('comments')->select('id')->get()->toArray();
	$posts_id = \DB::table('posts')->select('id')->get()->toArray();
	$users_id = \DB::table('users')->select('id')->get()->toArray();
	return [
		'user_id' => $faker->randomElement($users_id)->id,
		'comment_id' => $faker->randomElement($comments_id)->id,
		'post_id' => $faker->randomElement($posts_id)->id,
		'body' => $faker->paragraph,
		'approved' => true,
		'approved_by' => $faker->randomElement($users_id)->id,
		'approved_at' => $faker->dateTime->format('Y-m-d H:i:s'),
		'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
		'updated_at' => $faker->dateTime->format('Y-m-d H:i:s'),
	];
});
$factory->define(App\Category::class, function (Faker $faker) {
	return [
		'type' => $faker->unique()->word,
	];
});
$factory->define(App\Product::class, function (Faker $faker) {
	return [
		'description' => $faker->paragraph,
		'price' => $faker->numberBetween(10, 100),
		'name' => $faker->unique()->word,
		'photo' => $faker->imageUrl(640, 480, 'fashion'),
		'reviewed' => true,
	];
});
$factory->define(App\Cart::class, function (Faker $faker) {
	$products_id = \DB::table('products')->select('id')->get()->toArray();
	return [
		'product_id' => $faker->randomElement($products_id)->id,
		'quantity' => $faker->numberBetween(1, 10),
	];
});
$factory->define(App\Wishlist::class, function (Faker $faker) {
	$products_id = \DB::table('products')->select('id')->get()->toArray();
	return [
		'product_id' => $faker->randomElement($products_id)->id,
		'quantity' => $faker->numberBetween(1, 10),
	];
});
$factory->define(App\Coupon::class, function (Faker $faker) {
	return [
		'code' => str_random(32),
		'amount' => $faker->numberBetween(10, 100),
		'active' => $faker->boolean,
		'expires_at' => \Carbon\Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
		'percentage' => $faker->numberBetween(10, 100),
	];
});