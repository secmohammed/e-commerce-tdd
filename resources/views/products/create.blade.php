@extends('layouts.master')

@section('title')
    Create a product
@endsection

@section('content')
    <h1 class="page-heading">Create a product</h1>
    <hr>

    <form action="{{ route('product.create') }}" method="post" enctype="multipart/form-data" autocomplete="off">
        {{ csrf_field() }}
        @include('layouts.errors')

        <div class="col-md-8">
            <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control">
            </div>

            <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="10" class="form-control">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="stock">Stock</label>
                <select name="stock" id="stock" class="form-control">
                    @for ($stock = 1; $stock <= 20; $stock++)
                        <option value="{{ $stock }}">{{ $stock }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price (In cents)</label>
                <input type="text" name="price" id="price" value="{{ old('price') }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="photo">Choose a photo (Link or a file)</label>
                <input type="text" name="photo" id="photo" class="form-control">
                <input type="file" name="photo" id="photo" class="form-control">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-default">
            </div>
        </div>
    </form>
@endsection