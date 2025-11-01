@extends('panel.layout.master')
@section('head')
    <title>داشبورد صنعت یار ایران</title>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="body-pishkhan mt-4">
            <span class="dot"></span>
            <span>در یک نگاه</span>
        </div>
        <div class="border-piskhan mt-3">
            <div class="row text-center pb-4 mx-auto">
                <div class="col-6 col-lg-3 col-md-4 mt-4">
                    <div class="card-pishkhan card-one">
                        <img class="mt-4" src="dashbord/img/we1.svg" alt="">
                        <h6 class="mt-3">{{$created_at_ago}}</h6>
                        <p class="mt-2">همراه ما هستید</p>
                    </div>

                </div>
                <div class="col-6 col-lg-3 col-md-4 mt-4">
                    <div class="card-pishkhan card-one">
                        <img class="mt-4" src="dashbord/img/we2.svg" alt="">
                        <h6 class="mt-3">{{$code}}</h6>
                        <p class="mt-2">کد معرف شما</p>
                    </div>

                </div>
                <div class="col-6 col-lg-3 col-md-4 mt-4">
                    <div class="card-pishkhan card-one">
                        <img class="mt-4" src="dashbord/img/we3.svg" alt="">
                        <h6 class="mt-3">{{$wallet}}</h6>
                        <p class="mt-2">موجودی کیف پول</p>
                    </div>

                </div>
                <div class="col-6 col-lg-3 col-md-4 mt-4">
                    <div class="card-pishkhan card-one">
                        <img class="mt-4" src="dashbord/img/we4.svg" alt="">
                        <h6 class="mt-3">{{$expired}}</h6>
                        <p class="mt-2">تاریخ پایان اشتراک</p>
                    </div>

                </div>
                <div class="col-6 col-lg-3 col-md-4 mt-4 ">
                    <div class="card-pishkhan card-one">
                        <img class="mt-4" src="dashbord/img/we5.svg" alt="">
                        <h6 class="mt-3">{{$user_invited}}</h6>
                        <p class="mt-2">تعداد افراد معرفی شده</p>
                    </div>

                </div>
                <div class="col-6 col-lg-3 col-md-4 mt-4 ">
                    <div class="card-pishkhan card-one">
                        <img class="mt-4" src="dashbord/img/we6.svg" alt="">
                        <h6 class="mt-3">{{$product_inquiries}}</h6>
                        <p class="mt-2">تعداد استعلام های جدید</p>
                    </div>

                </div>
                <div class="col-6 col-lg-3 col-md-4 mt-4 ">
                    <div class="card-pishkhan card-one">
                        <img class="mt-4" src="dashbord/img/we7.svg" alt="">
                        <h6 class="mt-3">{{$products}}</h6>
                        <p class="mt-2">تعداد محصولات شما</p>
                    </div>

                </div>
                <div class="col-6 col-lg-3 col-md-4 mt-4 ">
                    <div class="card-pishkhan card-one">
                        <img class="mt-4" src="dashbord/img/we8.svg" alt="">
                        <h6 class="mt-3">{{$activation}}</h6>
                        <p class="mt-2">وضعیت حساب</p>
                    </div>

                </div>


            </div>
        </div>
        <div class="row mt-5">
            <div class=" col-md-6">
                <div class="body-pishkhan">
                    <span class="dot"></span>
                    <span>آخرین فعالیت ها</span>
                </div>
                <div class="border-piskhan mt-3 ms-3">
                    <ul>
                        @foreach($activation_list as $text)
                            <li>{{$text}}</li>
                        @endforeach
                    </ul>

                </div>
            </div>
            <div class=" col-md-6">
                <div class="body-pishkhan">
                    <span class="dot"></span>
                    <span>دسترسی آسان</span>
                </div>
                <div class="border-piskhan mt-3 ms-3">
                    <ul>
                        <li>اضافه کردن محصول جدید</li>
                        <li>ویرایش اطلاعات کاربری</li>
                        <li>صورتحساب ها</li>

                    </ul>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')

@endsection
