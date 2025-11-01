{{--@php--}}
{{--    dd(array_merge(["null"=>'انتخاب کنید'] , \App\Models\Province::pluck('name' , 'id')->all()));--}}
{{--@endphp--}}
@extends('panel.layout.master')
@section('head')
    <title>داشبورد صنعت یار ایران</title>
    <link rel="stylesheet" href="{{ asset('css/Tabs1.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/persian-datepicker/persian-datepicker.css') }}">
    <style>
        .tabs .slider {
            width: 50%;
        }

        .actionBtn {
            display: block;
            text-align: center;
            padding-top: 5px;
            border: none;
            width: 164px;
            height: 40px;
            flex-shrink: 0;
            bottom: none;
            border-radius: 15px;
            background: #0A0E29;
            color: #fff;
            transition: all 0.2s ease-in-out;
            -webkit-transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -ms-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;
        }

        .actionBtn:hover {
            background: #fd7e14;
            color: #000;
        }
    </style>
@endsection
@section('content')

    @if(\Illuminate\Support\Facades\Auth::user()->status == 1)
    <header class="d-flex justify-content-between">
        <h3 class="text-start mt-5">تکمیل مراحل ثبت نام</h3>
    </header>
    <div class="border-piskhan mt-3 text-center pt-5 pb-5">
        <div class="content mt-4">
            <p>به جمع خانواده صنعت یار ایران خوش آمدید.</p>
            <p>برای استفاده از خدمات سایت باید اشتراک خود را پرداخت کنید و پروفایل خود را کامل کنید.</p>
            <a href="{{route('panel.plan.index')}}" class="actionBtn mx-auto">پرداخت اشتراک</a>
        </div>
    </div>
    @elseif(\Illuminate\Support\Facades\Auth::user()->status == 2)
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger mt-1" role="alert">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <header class="d-flex justify-content-between">
            <h3 class="text-start mt-5">تکمیل مراحل ثبت نام</h3>
        </header>
        <div class="border-piskhan mt-3 pt-5 pb-5 px-2">
            {!! Form::open(['route' => 'panel.plan.status' , 'id'=>'receiptForm' , 'method'=>'post' , 'novalidate'=>'novalidate' , 'autocomplete'=>'off' , 'enctype'=>'multipart/form-data']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('company_name', 'نام شرکت' , ['class'=>'form-label']) !!}
                        {!! Form::text('company_name', null , ['class'=>'form-control' , 'id'=>'company_name']) !!}
                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('company_code', 'شناسه ملی' , ['class'=>'form-label']) !!}
                        {!! Form::text('company_code', null , ['class'=>'form-control' , 'id'=>'company_code']) !!}
                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('company_register', 'شماره ثبت' , ['class'=>'form-label']) !!}
                        {!! Form::text('company_register', null , ['class'=>'form-control' , 'id'=>'company_register' , 'maxlength'=>10 ]) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('company_postCode', 'کد پستی' , ['class'=>'form-label']) !!}
                        {!! Form::text('company_postCode', null , ['class'=>'form-control' , 'id'=>'company_postCode']) !!}
                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('company_phone', 'شماره تلفن' , ['class'=>'form-label']) !!}
                        {!! Form::text('company_phone', null , ['class'=>'form-control' , 'id'=>'company_phone']) !!}
                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('company_url', 'آدرس وبسایت' , ['class'=>'form-label']) !!}
                        {!! Form::text('company_url', null , ['class'=>'form-control' , 'id'=>'company_url']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('user_code', 'کد ملی کاربر' , ['class'=>'form-label']) !!}
                        {!! Form::text('user_code', null , ['class'=>'form-control' , 'id'=>'user_code']) !!}
                    </div>
                    <div class="col-12 col-md-8 mt-3">
                        {!! Form::label(null, 'تاریخ تولد کاربر' , ['class'=>'form-label']) !!}
                        <div class="row">
                            <div class="col-12 col-md-3">
                                {!! Form::select('user_Bday', [""=>"روز","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25","26"=>"26","27"=>"27","28"=>"28","29"=>"29","30"=>"30","31"=>"31"] , null , ['class'=>'form-select' , 'id'=>'user_Bday']) !!}
                            </div>
                            <div class="col-12 col-md-6">
                                {!! Form::select('user_Bmonth', [""=>"ماه","01"=>"فروردین - ماه اول", "02"=>"اردیبهشت - ماه دوم", "03"=>"خرداد - ماه سوم","04"=>"تیر - ماه چهارم","05"=>"مرداد - ماه پنجم","06"=>"شهریور - ماه ششم","07"=>"مهر - ماه هفتم","08"=>"آبان - ماه هشتم","09"=>"آذر - ماه نهم","10"=>"دی - ماه دهم","11"=>"بهمن - ماه یازدهم","12"=>"اسفند - ماه دوازدهم"], null , ['class'=>'form-select' , 'id'=>'user_Bmonth']) !!}
                            </div>
                            <div class="col-12 col-md-3 ">
                                {!! Form::text('user_Byear', null , ['class'=>'form-control' , 'placeholder'=>'سال' , 'id'=>'user_Byear']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('province_id', 'استان' , ['class'=>'form-label']) !!}
                        {!! Form::select('province_id', \App\Models\Province::pluck('name' , 'id')->all(), null , ['class'=>'form-select' , 'id'=>'province_id']) !!}
                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('city_id', 'شهر' , ['class'=>'form-label']) !!}
                        {!! Form::select('city_id', array_merge([""=>'انتخاب کنید'] , \App\Models\City::pluck('name' , 'id')->all()), null , ['class'=>'form-select' , 'disabled'=>!$errors->any() , 'id'=>'city_id']) !!}
                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('ipark_id', 'شهرک صنعتی' , ['class'=>'form-label']) !!}
                        {!! Form::select('ipark_id', array_merge([""=>'انتخاب کنید'] , \App\Models\Ipark::pluck('name' , 'id')->all()), null , ['class'=>'form-select' , 'disabled'=>!$errors->any() , 'id'=>'ipark_id']) !!}
                    </div>
                </div>
            </div>
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-md-4 mt-3">
                    {!! Form::label('address', 'آدرس' , ['class'=>'form-label']) !!}
                    {!! Form::text('address', null , ['class'=>'form-control' , 'id'=>'address']) !!}
                </div>
                <div class="col-12 col-md-4 mt-3">
                    {!! Form::label('type', 'نوع شرکت' , ['class'=>'form-label']) !!}
                    {!! Form::select('type', \App\Models\Type::pluck('name' , 'id')->all() , null , ['class'=>'form-select' ,  'id'=>'type']) !!}
                </div>
                <div class="col-12 col-md-4 mt-3">
                    {!! Form::label('category_id', 'حوزه فعالیت' , ['class'=>'form-label']) !!}
                    {!! Form::select('category_id', \App\Models\Category::where('parent_id' , null)->pluck('name' , 'id')->all() , null , ['class'=>'form-select' ,  'id'=>'category_id']) !!}
                </div>
            </div>
        </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('Ncard', 'تصویر کارت ملی مدیرعامل') !!}
                        {!! Form::file('Ncard' , ['class'=>'form-control' , 'id'=>'Ncard']) !!}
                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('Newspaper', 'روزنامه رسمی') !!}
                        {!! Form::file('Newspaper' , ['class'=>'form-control' , 'id'=>'Newspaper']) !!}
                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        {!! Form::label('lastChange', 'آخرین تغییرات') !!}
                        {!! Form::file('lastChange' , ['class'=>'form-control' , 'id'=>'lastChange']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 mt-3">
                        {!! Form::submit('ارسال مشخصات' , ['class'=>'actionBtn']) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        </div>
    @else
    <header class="d-flex justify-content-between">
        <h3 class="text-start mt-5">نتیجه ثبت‌نام</h3>
    </header>
    <div class="border-piskhan mt-3 text-center pt-5 pb-5">
        <div class="content mt-4">
            <p>ثبت نام شما با موفقیت تکمیل شد. مدیران سایت صحت اطلاعات وارد شده شما را بررسی خواهند کرد.</p>
        </div>
    </div>
    @endif
@endsection
@section('script')
    <script>
        $('#province_id').change(function () {
            $.ajax({
                url: "{{url('/province?')}}" + 'id=' + $(this).val(),
                success: function (result) {
                    data = JSON.parse(result);
                    cities = data[0];
                    iparks = data[1];
                    city_html = '<option value="">انتخاب کنید</option>';
                    ipark_html = '<option value="">انتخاب کنید</option>';
                    jQuery.each(cities, function (i, city) {
                        city_html = city_html + '<option value="' + city.id + '">' + city.name + '</option>';
                    })
                    jQuery.each(iparks, function (i, ipark) {
                        ipark_html = ipark_html + '<option value="' + ipark.id + '">' + ipark.name + '</option>';
                    })
                    $('#city_id').html(city_html);
                    $('#ipark_id').html(ipark_html);
                    $('#city_id').prop("disabled", false);
                    $('#ipark_id').prop("disabled", false);
                }
            });
        });
    </script>
    <script src="{{ asset('assets/plugins/jquery-validate@1.15.0/validate.min.js') }}"></script>
    <script>
        $('form').validate({
            invalidHandler:function(event , validator){
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1
                        ? 'You missed 1 field. It has been highlighted'
                        : 'You missed ' + errors + ' fields. They have been highlighted';
                    $("div.error span").html(message);
                    $("div.error").show();
                } else {
                    $("div.error").hide();
                }
            },
            rules: {
                'company_name':{
                    required:true,
                },
                'company_code':{
                    required:true,
                },
                'company_register':{
                    required:true,
                },
                'company_postCode':{
                    required:true,
                },
                'company_phone':{
                    required:true,
                },
                // 'company_url':required,
                'user_code':{
                    required:true,
                },
                'user_Bday':{
                    required:true,
                },
                'user_Bmonth':{
                    required:true,
                },
                'user_Byear':{
                    required:true,
                },
                'province_id':{
                    required:true,
                },
                'city_id':{
                    required:true,
                },
                // 'ipark_id':required,
                'Ncard':{
                    required:true,
                },
                'Newspaper':{
                    required:true,
                },
                'address':{
                    required:true,
                },
                // 'lastChange':required,
            },
            messages: {
                'company_name':'نام شرکت الزامی است.',
                'company_code':'شناسه ملی شرکت الزامی است.',
                'company_register':'شماره ثبت شرکت الزامی است.',
                'company_postCode':'کد پستی شرکت الزامی است.',
                'company_phone':'شماره تلفن شرکت الزامی است.',
                // 'company_url':'آدرس سایت شرکت الزامی است.',
                'user_code':'کد ملی الزامی است.',
                'user_Bday':'روز تاریخ تولد الزامی است.',
                'user_Bmonth':'ماه تاریخ تولد الزامی است.',
                'user_Byear':'سال تاریخ تولد الزامی است.',
                'province_id':'استان الزامی است.',
                'city_id':'شهر الزامی است.',
                // 'ipark_id':'شهرک صنعتی الزامی است.',
                'Ncard':'کارت ملی الزامی است.',
                'Newspaper':'روزنامه رسمی الزامی است.',
                'address':'آدرس الزامی است.',
                // 'lastChange':'آخرین تغییرات الزامی است.',
            },
            highlight: function (element) {
                $(element).removeClass('is-valid').addClass('is-invalid');
            },
            success: function (element) {
                element.siblings('input , select').removeClass('is-invalid').addClass('is-valid');
            },
            errorClass: "invalid-feedback",
            errorElement : "div",
            validClass: "is-valid",
        });
    </script>
    @if(!$errors->any())
        <script>
            $(document).ready(function(){
                $('#province_id').prepend('<option value="" selected>انتخاب کنید</option>');
            })
        </script>
    @endif
@endsection
