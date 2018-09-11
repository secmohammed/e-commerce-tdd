@inject('countries', 'App\Location')
@extends('layouts.master')

@section('title')
    Profile
@endsection

@section('content')
    <h1 class="page-heading">Account Overview</h1>
    <hr>
    <div class="col-md-12">
        <form action="{{ route('profile') }}" method="post" autocomplete="off">
            {{ csrf_field() }}
            @include('layouts.errors')

            <div class="col-md-6">
                <p class="lead">General</p>
                <hr>
                <div class="form-group">
                    <label>Name</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="far fa-user"></i></span>
                      <input type="text" class="form-control" name="name" value="{{ $user->profile->name ?? old('name') }}" autofocus placeholder="John Doe">
                    </div>
                </div>

                <div class="form-group">
                    <label>Bio</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="far fa-user"></i></span>
                      <input type="text" class="form-control" name="bio" value="{{ $user->profile->bio ?? old('bio') }}" placeholder="A rule you follow, maybe?">
                    </div>
                </div>

                <div class="form-group">
                    <label>Country</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="far fa-user"></i></span>
                        <select name="country" id="country" class="form-control">
                            @if (is_null($user->location->country))
                                <option disabled selected>Select your country</option>
                            @else
                                <option value="{{ $user->location->country }}">{{ $user->location->country ?? old('country') }}</option>
                            @endif

                            @foreach($countries::countries() as $code => $country)
                                <option value="{{ $code }} - {{ $country }}">{{ $code }} - {{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>About</label>
                    <textarea name="about" id="about" class="form-control" placeholder="Tell us some information about you">{{ $user->profile->about ?? old('about') }}</textarea>
                </div>
            </div>

            <div class="col-md-6">
                <p class="lead">Contact</p>
                <hr>

                <div class="form-group">
                    <label>Phone</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-phone"></i></span>
                      <input type="text" class="form-control" name="phone" value="{{ $user->phone->phone ?? old('phone') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Street</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-address-card"></i></span>
                      <input type="text" class="form-control" name="street" value="{{ $user->address->street ?? old('street') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>City</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-address-card"></i></span>
                      <input type="text" class="form-control" name="city" value="{{ $user->address->city ?? old('city') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-12" align="center">
                <input type="submit" value="Update" class="btn btn-default">
            </div>
        </form>
    </div>
@endsection