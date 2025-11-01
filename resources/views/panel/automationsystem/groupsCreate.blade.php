@extends('panel.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/Tabs1.css') }}">
    <title>گروه‌های من</title>
    <link href="{{ asset('assets/plugins/select2@4.1.0/select2min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <div class="body-pishkhan mt-4">
        <span class="dot"></span>
        <span>گروه‌های من</span>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-xl-3 mb-3">
            <a class="btn btn-primary d-block mb-3" href="{{ route('automationSystem.groupsPage') }}">بازگشت به گروه‌ها</a>
            @include('panel.automationsystem.automationsesyem-sidebar')
        </div>
        <div class="col-12 col-xl-9">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex" style="justify-content: space-between;align-items: center;">
                        <div style="min-width: 94px;">
                            گروه‌های من
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('automationSystem.groupStore') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">نام گروه:</label>
                            <input maxlength="50" type="text" id="name" name="name" class="form-control"
                                placeholder="لطفا نام را وارد کنید." value="{{ old('name') }}" required>
                        </div>
                        <button class="btn btn-primary">ثبت گروه</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
