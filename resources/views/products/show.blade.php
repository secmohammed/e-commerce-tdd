@extends('layouts.master')

@section('title')
    {{ $product->title }}
@endsection

@section('content')
    <div class="col-md-4">
        @if(filter_var($product->photo,FILTER_VALIDATE_URL))
            <img src="{{ $product->photo }}" class="img-thumbnail img-responsive" alt="Product Image" style="max-width: 269px; max-height:204px;">
        @else
            <img src="{{ asset('photos/'. $product->photo) }}" class="img-thumbnail img-responsive" alt="Product Image" style="height:204px; max-height: 204px;  max-width:269px;">
        @endif
    </div>

    <div class="col-md-8">
        <h3 class="lead">{{ $product->title }}</h3>
        <p>{{ $product->description }}</p>
        <p>${{ ($product->price) / 100 }}</p>
        <form action="{{ route('product.add', $product->id) }}" method="post">
            {{ csrf_field() }}
            <input type="submit" value="Add to cart" class="btn btn-default">
        </form>
    </div>
@endsection