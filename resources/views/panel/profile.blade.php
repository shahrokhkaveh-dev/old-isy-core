@extends('panel.layout.master')
@section('head')
    <title>داشبورد صنعت یار ایران</title>
    <link rel="stylesheet" href="{{ asset('assets/css/Tabs1.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/persian-datepicker/persian-datepicker.css') }}">
    <style>
        .tabs .slider{
            width: 50%;
        }
        .actionBtn{
            float: left;
        }
    </style>
@endsection
@section('content')
    <div class="body-pishkhan mt-4">
        <span class="dot"></span>
        <span>اطلاعات حساب کاربری </span>
    </div>
    <div class="border-piskhan mt-3">
        <div class="row text-center pb-4 pe-4 mx-auto">
            <div class="row p-0">
                <div class="d-flex justify-content-between">
                    <h3 class="text-end mt-5">مشخصات حساب</h3>
                    <form action="{{route('profile.setimage')}}" method="post" id="changeImage" enctype="multipart/form-data">
                        @csrf
                        <label class="text-start">
                            <img class="mt-5 img-profile" src="{{\Illuminate\Support\Facades\Auth::user()->avatar ? asset(\Illuminate\Support\Facades\Auth::user()->avatar) : ''}}" alt="">
                            <input type="file" class="d-none" name="image" onchange="changeImage.submit()" accept="image/*">
                            <span class="pen">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 17.5L4.16665 12.5L13.3333 3.33333C14.1667 2.5 15.8333 2.5 16.6667 3.33333C17.5 4.16667 17.5 5.83333 16.6667 6.66667L7.49998 15.8333L2.5 17.5Z"
                                      stroke="#252525" stroke-width="1.66667" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path d="M12.5 4.16666L15.8333 7.5" stroke="#252525" stroke-width="1.66667"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path d="M5 12.5L7.5 15" stroke="#252525" stroke-width="0.833333" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path d="M14.1667 3.33333H16.6667V5.83333L7.5 15L5 12.5L14.1667 3.33333Z" fill="#252525"
                                      fill-opacity="0.3"/>
                            </svg>
                        </span>
                        </label>
                    </form>

                </div>
                <div class="col-12 col-md-3 mt-5">
                    <label class="form-label float-end">نام</label>
                    <input type="text" disabled class="form-control disabled" value="{{\Illuminate\Support\Facades\Auth::user()->first_name}}">
                </div>
                <div class="col-12 col-md-3 mt-5">
                    <label class="form-label float-end">نام خانوادگی</label>
                    <input type="text" disabled class="form-control disabled" value="{{\Illuminate\Support\Facades\Auth::user()->last_name}}">
                </div>
                <div class="col-12 col-md-3 mt-5">
                    <label class="form-label float-end"> کد ملی </label>
                    <input type="text" disabled class="form-control disabled" value="{{\Illuminate\Support\Facades\Auth::user()->nationaliy_code}}">
                </div>
                <div class="col-12 col-md-3 mt-5">
                    <label class="form-label float-end">شماره موبایل</label>
                    <input type="text" disabled class="form-control disabled" value="{{\Illuminate\Support\Facades\Auth::user()->phone}}">
                </div>
                <div class="col-12 col-md-3 mt-5">
                    <label class="form-label float-end">آدرس ایمیل </label>
                    <input type="text" disabled class="form-control disabled" value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                </div>
                <form action="{{route('profile.setpassword')}}" method="post">
                    @csrf
                    <h3 class="text-end mt-5"> تغییر رمز عبور</h3>
                    <div class="row">
                        <div class="col-12 col-md-3 mt-3">
                            <label class="form-label float-end">رمز عبور جدید</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-12 col-md-3 mt-3">
                            <label class="form-label float-end">تکرار رمز </label>
                            <input type="password" name="confirmed_password" class="form-control">
                        </div>
                        <div class="col-12 col-md-3 offset-3 mt-5">
                            <button class="btn btn-submit float-end">ذخیره تغییرات</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
