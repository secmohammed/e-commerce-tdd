<?php

namespace App\Repositories;

use App\Profile;

class ProfileRepository extends Repository {
	protected $model;

	public function __construct(Profile $model) {
		$this->model = $model;
	}
}