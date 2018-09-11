@extends('layouts.master')

@section('title')
    My Cart
@endsection

@section('content')
    <link rel="stylesheet" href="/css/app.css">
    <div class="row">
        <div class="col-md-8">
            <div class="well well-lg">
                @if (count($products))
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('product.view', $product->id) }}" style="text-decoration: none;">
                                            @if(filter_var($product->photo,FILTER_VALIDATE_URL))
                                                <a href="{{ route('product.view', $product->id) }}">
                                                    <img src="{{ $product->photo }}" class="img-thumbnail img-responsive" alt="Product Image" style="height:70px; max-height: 70px; max-width:70px;">
                                                </a>
                                            @else
                                                <a href="{{ route('product.view', $product->id) }}">
                                                    <img src="{{ asset('photos/'. $product->photo) }}" class="img-thumbnail img-responsive" alt="Product Image" style="height:70px; max-height: 70px;  max-width:70px;">
                                                </a>
                                            @endif
                                            {{ $product->title }}
                                        </a>
                                    </td>
                                    <td>${{ ($product->price) / 100 }}</td>
                                    <td>
                                        <form action="{{ route('product.quantity.update', $product->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <select name="quantity" id="quantity" class="form-control">
                                                <option value="{{ $product->pivot->quantity }}" selected>{{ $product->pivot->quantity }}</option>
                                                @for ($i = 1; $i <= $product->stock; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <input type="submit" value="Update" class="btn btn-default pull-right">
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('product.remove', $product->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="submit" value="Remove" class="btn btn-danger">
                                        </form>
                                    </td>
                                </tr>
                                    @php
                                        $total += (int) $product->price * $product->pivot->quantity / 100;
                                    @endphp
                            @endforeach
                        </tbody>
                    </table>
                @else
                    No items, <a href="{{ route('home') }}">Start Shopping</a>
                @endif

            </div>
        </div>

        <div class="col-md-4">
            @if (count($products))
                <div class="well well-lg">
                    <h4>Cart summary</h4>
                    <hr>
                    <table class="table">
                        <tr>
                            <td>Sub Total</td>
                            <td>$ {{ $total }}</td>
                        </tr>
                        <tr>
                            <td>Shipping</td>
                            <td>$ 5.00</td>
                        </tr>
                        <tr>
                            <td class="success">Total</td>
                            <td class="success">$ {{ ($total + 5) }}</td>
                        </tr>
                    </table>

                    <form action="{{ route('checkout') }}" method="post">
                        {{ csrf_field() }}
                        <div class="clearfix">
                            {{ session()->put('price', $total + 5) }}
                            <button class="btn btn-default pull-right">Checkout</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection