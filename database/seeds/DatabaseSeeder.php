<?php

use Illuminate\Database\Seeder;
use SecTheater\Jarvis\Activation\EloquentActivation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
    }
}