<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>سامانه صنعت یار ایران</title>
    <link rel="shortcut icon" href="{{asset('assets/favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/css/auth.css')}}">
    @livewireStyles
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="center-box">
                <div class="center-content">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@livewireScripts
<style>
    .swal2-popup.swal2-toast.swal2-show {
        direction: rtl !important;
    }
</style>
<script src="{{ asset('assets/plugins/sweet-alert2@11.10.6/sweet-alert.min.js') }}"></script>
<x-livewire-alert::scripts/>
<script src="{{ asset('assets/plugins/bootstrap@5.2.3/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery@3.7.1/jquery.min.js') }}"></script>
 <script src="{{asset('assets/js/auth.js')}}"></script>
</html>
