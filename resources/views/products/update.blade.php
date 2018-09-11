@extends('layouts.master')

@section('title')
    Update a product
@endsection

@section('content')
    <h1 class="page-heading">Update a product</h1>
    <hr>

    <form action="{{ route('product.update', $product->id) }}" method="post" autocomplete="off">
        {{ csrf_field() }}
        @include('layouts.errors')

        <div class="col-md-8">
            <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ $product->title }}" id="title" class="form-control">
            </div>

            <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="10" class="form-control">{{ $product->description }}</textarea>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="stock">Stock</label>
                <select name="stock" id="stock" class="form-control">
                    <option value="{{ $product->stock }}" SELECTED>{{ $product->stock }}</option>
                    @for ($stock = 1; $stock <= 20; $stock++)
                        <option value="{{ $stock }}">{{ $stock }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price (In cents)</label>
                <input type="text" name="price" id="price" value="{{ $product->price }}" class="form-control">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-default">
            </div>
        </div>
    </form>
@endsection