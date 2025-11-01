<!DOCTYPE html>
<html lang='{{ Illuminate\Support\Facades\App::getLocale() }}'>

<head>
    @include('user.layout.head')
    @yield('head')
</head>

<body class="@yield('bodyStyle')">
    <div class="loading" id="loading">صنعت‌ یار ایران
        <span></span>
    </div>
    @include('user.layout.nav')
    @yield('content')
    @include('user.layout.footer')
</body>
@include('user.layout.script')
@yield('script')
</html>
