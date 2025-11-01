<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.panel.layout.head')
    @yield('style')
</head>
<body dir="rtl">
    <div class="loading">
        <span class="loader"></span>
    </div>
<div class="">
    @include('admin.panel.layout.sidebar')
    <div class="main-body">
        @include('admin.panel.layout.navbar')
        <div class="content-body">
            @yield('content')
        </div>
    </div>
</div>


@include('admin.panel.layout.script')
@yield('script')
</body>
</html>
