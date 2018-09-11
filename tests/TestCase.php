<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,RefreshDatabase;
    public function setUp()
    {
        parent::setUp();
        $this->seed('RolesSeeder');
        $this->user = factory(User::class)->create();
        $this->user->roles()->attach(\RoleRepository::first());
        $this->actingAs($this->user);
    }

}
