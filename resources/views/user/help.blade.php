@extends('user.layout.master')
@section('head')
    <title>راهنمای خرید</title>
    <style>
        .productDescription {
            background: rgba(217, 217, 217, 0.31);
            border-radius: 10px;
            width: 100%;
            min-height: 0;
            padding: 16px;
        }

        .productDescription ul {
            display: unset;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div>
            <h1 style="color: #fff;">راهنمای خرید سرویس </h1>
        </div>
        <div class="productDescription text-light mt-5">
            <h2 style="font-size: 20px;">توضیحات سرویس :</h2>
            <p>مجموعه صنعت یار در قالب خدمات به صاحبین صنایع و فعالین اقتصادی سرویس های متنوعی ارائه کرده است که
                با توجه به نیاز شما عزیزان در میزان دسترسی و امکانات و اطلاعات دریافتی تهیه شده اند.
            </p>

        </div>
        <div class="productDescription text-light mt-2">
            <h2 style="font-size: 20px;">نحوه تهیه سرویس :</h2>
            <p>
                در صورتی که تمایل به فعالسازی یکی از سرویس های صنعت یار را دارید یا میخواهید سرویسی را تمدید و ارتقا دهید
                مراحل زیر را طی کنید :
            </p>
            <ol>
                <li>ابتدا وارد حساب کاربری خود شوید</li>
                <li>از سربرگ خدمات و اشتراک ها پلن مورد نظر را پیدا کنید</li>
                <li>تعرفه پلن انتخاب شده را توسط یکی از روش های موجود پرداخت کنید</li>
                <li>از امکانات صنعت یار لذت ببرید</li>
            </ol>

        </div>
        <div class="productDescription text-light mt-2">
            <h2 style="font-size: 20px;">روش های پرداخت</h2>
            <p>
                پرداخت در سامانه صنعت یار تنها از طریق درگاه بانکی و یکی از کارت های عضو شبکه شتاب امکان پذیر است.
            </p>

        </div>
    </div>
@endsection
@section('script')
@endsection
