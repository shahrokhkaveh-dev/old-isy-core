@extends('user.layout.master')
@section('head')
    <title>تماس با ما</title>
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
            <h1 style="color: #fff;">تماس با ما </h1>
        </div>
        <div class="productDescription text-light mt-5">
            <h2 style="font-size: 20px;">راه های ارتباطی :</h2>
            <p>
                شماره های تماس : 08632800215
                <br>
                نشانی : اراک ، خ قدوسی ، ساختمان دماوند ، طبقه 7 واحد 2
                <br>
                ایمیل : info@sanatyariran.com
            </p>
        </div>
    </div>
@endsection
@section('script')
@endsection
