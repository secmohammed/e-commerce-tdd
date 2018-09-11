@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')
    @foreach($products->chunk(3) as $productChunk)
        <div class="row">
            @foreach ($productChunk as $product)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        @if(filter_var($product->photo,FILTER_VALIDATE_URL))
                            <a href="{{ route('product.view', $product->id) }}">
                                <img src="{{ $product->photo }}" class="img-thumbnail img-responsive" alt="Product Image" style="max-height: 150px; max-width:300px;">
                            </a>
                        @else
                            <a href="{{ route('product.view', $product->id) }}">
                                <img src="{{ asset('photos/'. $product->photo) }}" class="img-thumbnail img-responsive" alt="Product Image" style="height:150px; max-height: 150px;  max-width:300px;">
                            </a>
                        @endif
                        <div class="caption">
                            <h3>{{ $product->title }}</h3>
                            <p style="color:#7f7f7f; height:150px; max-height: 150px; word-wrap: break-word; ">{{ str_limit($product->description) }} <a href="{{ route('product.view', $product->id) }}">More Information</a></p>
                            <p>
                                <div class="clearfix">
                                    <div class="pull-left lead">$ {{ ($product->price) / 100 }}</div>
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            @if ($product->stock > 5)
                                                <label for="success" class="label label-success">In Stock</label>
                                            @else
                                                <label for="warning" class="label label-warning">Low Stock</label>
                                            @endif
                                            <span class="badge">{{ $product->stock }}</span>
                                        </div>
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
@endsection