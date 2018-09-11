<?php

namespace App\Observers;

use App\Product;

class ProductObserver {
	public function creating(Product $product) {
		$product->user_id = auth()->id();
		if ($product->shouldBeReviewed() && auth()->user()->can('review-product')) {
			$product->reviewed_by = auth()->id();
			$product->reviewed_at = date('Y-m-d H:i:s');
			$product->reviewed = true;
		}

		// if (request()->hasFile('photo')) {
		//     $file  = request()->photo;
		//     $fileName = sha1($file->getClientOriginalName() . time() . uniqid(true)) . '.' .$file->extension();
		//     $file->move(public_path('photos'),$fileName);
		//     $product->photo = $fileName;
		// } else {
		//     $product->photo = request()->photo;
		// }
	}
	public function updating(Product $product) {
		$product->updated_at = date('Y-m-d H:i:s');
		if ($product->shouldBeReviewed() && auth()->user()->can('review-product')) {
			$product->reviewed_by = auth()->id();
			$product->reviewed_at = date('Y-m-d H:i:s');
			$product->reviewed = true;
		}
	}

}