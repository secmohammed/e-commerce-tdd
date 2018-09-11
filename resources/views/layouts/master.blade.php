<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.header')
<body>
    @include('layouts.partials.navbar')

    <div class="container">
        @yield('content')
    </div>

    @include('layouts.partials.footer')
</body>
</html>