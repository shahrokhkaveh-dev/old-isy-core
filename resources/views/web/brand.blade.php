@extends('web.layout.layout')
@section('title')
    <title>شرکت : {{ $brand->name }}</title>
@endsection
@section('content')
    <main class="companies">
        <div class="container">
            <div class="single-product-page-wrapper">
                <div class="single-product-page-main">
                    <div class="single-product-title brand-title">
                        <h1 class="h1">{{ $brand->name }}</h1>
                    </div>
                    <div class="single-product-feature brand-feature">
                        <p>مشخصات شرکت</p>
                        <table>
                            <tbody>
                                <tr>
                                    <td>نوع صنعت</td>
                                    <td>{{ $brand->category ? $brand->category->name : '' }}</td>
                                </tr>
                                <tr>
                                    <td>نام مدیرعامل</td>
                                    <td>{{ $brand->managment_name }}</td>
                                </tr>

                                <tr>
                                    <td>شماره تماس</td>
                                    <td>{{ $brand->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td>وبسایت</td>
                                    <td><a href="">{{ $brand->url }}</a></td>
                                </tr>
                                <tr>
                                    <td>ایمیل</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>آدرس</td>
                                    <td>{{ $brand->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($images)
                    <div class="fotorama" style="margin-top: 20px;" data-allowfullscreen="true" data-nav="thumbs">
                        @foreach ($images as $image)
                        <a href="{{ asset($image->image_path) }}"><img src="{{ asset($image->image_path) }}" alt=""></a>
                        @endforeach
                    </div>
                    @endif


                    @if ($brand->description)
                    <div class="single-product-text">
                        {!! $brand->description !!}
                    </div>
                    @endif
                    <section class="container main-section home-new-brands single-brand-products">
                        <div class="products-search-wrapper">
                            @foreach ($brand->products as $p)
                            <div class="product-card">
                                <div class="product-card-image">
                                    <a href="{{ route('user.product.show', $p->slug) }}">
                                        <img src="{{ asset($p->image) }}" alt="">
                                    </a>
                                    @if ($p->isExportable)
                                    <span class="product-card-ribbon">صادراتی</span>
                                    @endif
                                </div>
                                <p class="product-card-title"><a href="{{ route('user.product.show', $p->slug) }}">{{$p->name}}</a></p>
                                <div class="product-card-footer">
                                    <div class="product-card-location">
                                        <svg width="8" height="11" viewBox="0 0 8 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.3904 9.35024C6.54527 7.87755 8 5.73796 8 4.30435C8 1.92712 6.20914 0 4 0C1.79086 0 0 1.92712 0 4.30435C0 5.73796 1.45473 7.87755 2.6096 9.35024C3.21212 10.1186 3.51338 10.5027 4 10.5027C4.48662 10.5027 4.78788 10.1186 5.3904 9.35024ZM4 6C3.17157 6 2.5 5.32843 2.5 4.5C2.5 3.67157 3.17157 3 4 3C4.82843 3 5.5 3.67157 5.5 4.5C5.5 5.32843 4.82843 6 4 6Z"
                                                fill="#71787F" />
                                        </svg>
                                        {{ $brand->city?$brand->city->name:'' }}
                                    </div>
                                    <div class="product-card-location">
                                        <svg width="8" height="11" viewBox="0 0 8 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.3904 9.35024C6.54527 7.87755 8 5.73796 8 4.30435C8 1.92712 6.20914 0 4 0C1.79086 0 0 1.92712 0 4.30435C0 5.73796 1.45473 7.87755 2.6096 9.35024C3.21212 10.1186 3.51338 10.5027 4 10.5027C4.48662 10.5027 4.78788 10.1186 5.3904 9.35024ZM4 6C3.17157 6 2.5 5.32843 2.5 4.5C2.5 3.67157 3.17157 3 4 3C4.82843 3 5.5 3.67157 5.5 4.5C5.5 5.32843 4.82843 6 4 6Z"
                                                fill="#71787F" />
                                        </svg>
                                        <a href="">{{$brand->name}}</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>
                </div>
                <div class="single-product-page-aside">
                    <div class="single-product-info">
                        <div style="text-align: center;margin-bottom: 20px;">
                            @if ($brand->logo_path)
                                <img src="{{ asset($brand->logo_path) }}"
                                    style="max-width: 250px; max-height: 250px;width: 100%;height: auto; border-radius: 16px;"
                                    alt="">
                            @endif
                        </div>
                        <div class="single-product-info-footer" style="text-align: center;">
                            <a href="{{ $brand->url }}" target="_blank">
                                <button type="button" class="buy-btn">مشاهده سایت</button>
                            </a>
                        </div>
                    </div>
                    <div class="single-product-ads">
                        <div><img src="https://fakeimg.pl/420x330" alt=""></div>
                        <div><img src="https://fakeimg.pl/420x330" alt=""></div>
                        <div><img src="https://fakeimg.pl/420x330" alt=""></div>
                        <div><img src="https://fakeimg.pl/420x330" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
