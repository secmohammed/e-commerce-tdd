@extends('layouts.master')

@section('title')
    Checkout
@endsection

@section('content')
    <h1 class="page-heading">Checkout</h1>
    <hr>

    <form action="" method="post" autocomplete="off">
        {{ csrf_field() }}
        <div class="col-md-6">
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" name="email" value="{{ auth()->user()->email }}" id="email" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>First Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="first_name" value="{{ auth()->user()->profile->first_name }}" id="first_name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="last_name" value="{{ auth()->user()->profile->last_name }}" id="last_name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>City</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                    <input type="text" name="city" value="{{ auth()->user()->address->city }}" id="city" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Street</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                    <input type="text" name="street" value="{{ auth()->user()->address->street }}" id="street" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-md-6">
        </div>

        <div class="col-md-12">
            <input type="submit" class="btn btn-default center-block" value="Checkout">
        </div>
    </form>
@endsection