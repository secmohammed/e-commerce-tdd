<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository extends Repository {
	protected $model;

	public function __construct(Category $model) {
		$this->model = $model;
	}
	public function generate($type) {
		return $this->model->firstOrCreate(compact('type'));
	}
}