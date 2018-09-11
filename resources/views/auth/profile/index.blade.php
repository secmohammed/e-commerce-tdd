@extends('layouts.master')

@section('title')
    Profile
@endsection

@section ('content')
    <div class="col-md-8">
        <div class="well">
            <p class="lead">General Information</p>
            <hr>

            <label for="email">
                <i class="fas fa-user"></i>
                Username
            </label>
            <p>{{ $user->username }}</p>

            <label for="email">
                <i class="fas fa-envelope"></i>
                Email address
            </label>
            <p>{{ $user->email }}</p>

            <label for="name">
                <i class="fas fa-user"></i>
                Name
            </label>
            <p>{{ $user->profile->name }}</p>

            <label for="bio">
                <i class="fas fa-user"></i>
                Bio
            </label>
            <p>{{ $user->profile->bio }}</p>

            <label for="about">About</label>
            <p>{{ $user->profile->about ?? 'Something to go here' }}</p>

            <label for="joined">Joined</label>
            <p>@joined($user)</p>

            <a href="{{ route('profile.update') }}" class="btn btn-default">Update</a>
        </div>
    </div>
@endsection