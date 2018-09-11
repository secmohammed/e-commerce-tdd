@extends('layouts.master')

@section('title')
    Register
@endsection

@section('content')
    <div class="row">
        <form action="{{ route('register') }}" method="POST" autocomplete="off">
            {{ csrf_field() }}
            @include('layouts.errors')

            <div class="form-group">
                <label for="email" class="label label-default">Email Address</label>
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-envelope"></i></span>
                  <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Johndoe@example.com" aria-describedby="sizing-addon2" autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="username" class="label label-default">Username</label>
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-user"></i></span>
                  <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Johndoe" aria-describedby="sizing-addon2">
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="label label-default">Password</label>
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-key"></i></span>
                  <input type="password" name="password" class="form-control" aria-describedby="sizing-addon2">
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="label label-default">Password Confirmation</label>
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-key"></i></span>
                  <input type="password" name="password_confirmation" class="form-control" aria-describedby="sizing-addon2">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group pull-right">
                    <button type="submit" class="btn btn-default">Sign up</button>
                </div>
            </div>
        </form>
    </div>
@endsection