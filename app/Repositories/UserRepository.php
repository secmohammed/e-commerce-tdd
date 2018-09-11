<?php

namespace App\Repositories;

use App\User;

class UserRepository extends Repository {
	protected $model;

	public function __construct(User $model) {
		$this->model = $model;
	}
}
