@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')
    @foreach($results->chunk(3) as $resultChunk)
        <div class="row">
            @foreach ($resultChunk as $result)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        @if(filter_var($result->photo, FILTER_VALIDATE_URL))
                            <img src="{{ $result->photo }}" class="img-thumbnail img-responsive" alt="Product Image" style="max-height: 150px; max-width:300px;">
                        @else
                            <img src="{{ asset('photos/' . $result->photo) }}" class="img-thumbnail img-responsive" alt="Product Image" style="height:150px; max-height: 150px;  max-width:300px;">
                        @endif
                        <div class="caption">
                            <h3>{{ $result->title }}</h3>
                            <p style="color:#7f7f7f; height:150px; max-height: 150px; word-wrap: break-word; ">{{ str_limit($result->description) }} <a href="{{ route('product.view', $result->id) }}">More Information</a></p>
                            <p>
                                <div class="clearfix">
                                    <div class="pull-left lead">$ {{ ($result->price) / 100 }}</div>
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            @if ($result->stock > 5)
                                                <label for="success" class="label label-success">In Stock</label>
                                            @else
                                                <label for="warning" class="label label-warning">Low Stock</label>
                                            @endif
                                            <span class="badge">{{ $result->stock }}</span>
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