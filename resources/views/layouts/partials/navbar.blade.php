<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand" href="{{ route('home') }}">Shoppy</a>

      <form method="POST" action="{{ route('search') }}" autocomplete="off" class="navbar-form navbar-left">
        {{ csrf_field() }}
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-search"></i></span>
            <input type="text" name="search" id="search" value="{{ old('search') }}" class="form-control">
          </div>
        </div>
        <button type="submit" class="btn btn-default">Search</button>
      </form>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">

        @auth
          <li>
            <a href="{{ route('cart') }}">
              <i class="fas fa-shopping-cart"></i> Cart <span class="badge">{{ count(auth()->user()->products) }}</span>
            </a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> {{ auth()->user()->getUsernameOrName() }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
              @privillege('admin')
                <li><a href="{{ route('cpanel') }}">Admin Panel</a></li>
              @endprivillege
              <li><a href="{{ route('profile') }}">Profile</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
          </li>
        @else
          <li><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Sign up</a></li>
          <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Sign in</a></li>
        @endauth

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>