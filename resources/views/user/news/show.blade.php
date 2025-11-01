@extends('user.layout.master')
@section('head')
    <title>صنعت یار ایران - {{ $news->title }}</title>
    <style>
        .productDescription {
            background: rgba(217, 217, 217, 0.31);
            border-radius: 10px;
            width: 100%;
            min-height: 248px;
            padding: 16px;
        }
        .productDescription ul{
            display: unset;
        }
        h1{
            font-size: 22px;
        }
        .author p{
            font-size: 14px;
            text-align: left;
            line-height: 20px;
        }
        .pageImage{
            text-align: center;
        }
        .pageImage img{
            width: unset;
            max-width: 100%;
            max-height: 450px;
        }
        @media screen and (max-width:767px){
            .author p{
                text-align: unset;
            }
            .pageHeader{
                padding: 10px;
                padding-bottom: 0;
            }
            .pageContent{
                padding: 10px;
            }
        }
    </style>
@endsection
@section('content')
                    {{-- @foreach ($otherProducts as $product) --}}
    <main class="customPage mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <section class="pageWrapper">
                        <div class="pageHeader">
                            <div class="row p-0 m-0">
                                <div class="col-12 col-md-6">
                                    <h1>
                                        {{ $news->title }}
                                    </h1>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="author">
                                        <p>نویسنده : {{ $news->author->name }}</p>
                                        <p>تاریخ انتشار : {{ jdate($news->created_at) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pageImage">
                            <img data-src="{{ asset($news->box_image_path) }}" alt="" >
                        </div>
                        <div class="pageContent">
                            {!! $news->content !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
@endsection
