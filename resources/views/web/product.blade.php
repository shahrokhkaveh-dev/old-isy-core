@extends('web.layout.layout')
@section('title')
    <title>صنعت یار ایران - {{ $product->name }}</title>
@endsection
@php
    $brand = $product->brand;
@endphp
@section('content')
    <main class="companies">
        <div class="container">
            <div class="single-product-page-wrapper">
                <div class="single-product-page-main">
                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
                        @if ($product->image)
                            <a href="{{ asset($product->image) }}"><img src="{{ asset($product->image) }}" alt=""></a>
                        @endif
                    </div>
                    <div class="single-product-title">
                        <h1 class="h1">{{ $product->name }}</h1>
                    </div>
                    @if ($product->excerpt)
                        <div class="single-product-expert">
                            {!! $product->excerpt !!}
                        </div>
                    @endif
                    <div class="single-product-feature">
                        <p>ویژگی های محصول</p>
                        <table>
                            <thead>
                                <tr>
                                    <td>ویژگی</td>
                                    <td>توضیحات</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->attributes as $attr)
                                    <tr>
                                        <td>{{ $attr->name }}</td>
                                        <td>{{ $attr->value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="single-product-video">
                        <p>ویدئو محصول</p>
                        <video src="#" controls></video>
                    </div> --}}
                    @if ($product->description)
                        <div class="single-product-text">
                            {!! $product->description !!}
                        </div>
                    @endif

                </div>
                <div class="single-product-page-aside">
                    <div class="single-product-info">
                        <table>
                            <tr>
                                <td>نام شرکت</td>
                                <td>{{ $brand->name }}</td>
                            </tr>
                            <tr>
                                <td>مکان</td>
                                <td>{{ $brand->province ? $brand->province->name . ',' : '' }}
                                    {{ $brand->city ? $brand->city->name : '' }}</td>
                            </tr>
                            <tr>
                                <td>عملکرد شرکت</td>
                                <td class="company-rate">5 <i class="fas fa-star"></i></td>
                            </tr>
                        </table>
                        <div class="single-product-info-footer">
                            <button type="button" class="buy-btn" id="inqBtn">استعلام این محصول</button>
                            <button type="button" class="share-btn"><i class="far fa-share-nodes"></i></button>
                            <button type="button" class="bookmark-btn"><i class="far fa-bookmark"></i></button>
                        </div>
                    </div>
                    <div class="single-product-ads">
                        <div><img src="{{ asset('web/assets/images/ads.png') }}" alt=""></div>
                        <div><img src="{{ asset('web/assets/images/ads.png') }}" alt=""></div>
                        <div><img src="{{ asset('web/assets/images/ads.png') }}" alt=""></div>
                        <div><img src="{{ asset('web/assets/images/ads.png') }}" alt=""></div>
                    </div>
                </div>
            </div>
        </div>

        <section class="home-categories container main-section">
            <h3 class="h3">محصولات مرتبط</h3>
            <div dir="rtl" class="swiper productListSwiper">
                <div class="swiper-wrapper">
                    @foreach ($otherProducts as $p)
                        <div class="swiper-slide">
                            <div class="product-card">
                                <div class="product-card-image">
                                    <a href="{{ route('user.product.show', ['slug' => $p->slug]) }}">
                                        <img src="{{ $p->image ? asset($p->image) : asset('image/productISYBox.png') }}"
                                            alt="">
                                    </a>
                                    @if ($p->isExportable)
                                        <span class="product-card-ribbon">صادراتی</span>
                                    @endif
                                </div>
                                <p class="product-card-title"><a
                                        href="{{ route('user.product.show', ['slug' => $p->slug]) }}">{{ $p->name }}</a>
                                </p>
                                <div class="product-card-footer">
                                    <div class="product-card-location">
                                        <svg width="8" height="11" viewBox="0 0 8 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.3904 9.35024C6.54527 7.87755 8 5.73796 8 4.30435C8 1.92712 6.20914 0 4 0C1.79086 0 0 1.92712 0 4.30435C0 5.73796 1.45473 7.87755 2.6096 9.35024C3.21212 10.1186 3.51338 10.5027 4 10.5027C4.48662 10.5027 4.78788 10.1186 5.3904 9.35024ZM4 6C3.17157 6 2.5 5.32843 2.5 4.5C2.5 3.67157 3.17157 3 4 3C4.82843 3 5.5 3.67157 5.5 4.5C5.5 5.32843 4.82843 6 4 6Z"
                                                fill="#71787F" />
                                        </svg>
                                        {{ $brand->province ? $brand->province->name . ',' : '' }}
                                        {{ $brand->city ? $brand->city->name : '' }}
                                    </div>
                                    <div class="product-card-location">
                                        <svg width="8" height="11" viewBox="0 0 8 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.3904 9.35024C6.54527 7.87755 8 5.73796 8 4.30435C8 1.92712 6.20914 0 4 0C1.79086 0 0 1.92712 0 4.30435C0 5.73796 1.45473 7.87755 2.6096 9.35024C3.21212 10.1186 3.51338 10.5027 4 10.5027C4.48662 10.5027 4.78788 10.1186 5.3904 9.35024ZM4 6C3.17157 6 2.5 5.32843 2.5 4.5C2.5 3.67157 3.17157 3 4 3C4.82843 3 5.5 3.67157 5.5 4.5C5.5 5.32843 4.82843 6 4 6Z"
                                                fill="#71787F" />
                                        </svg>
                                        <a
                                            href="{{ route('user.brands.show', ['slug' => $brand->slug]) }}">{{ $brand->name }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="next">
                    <img src="{{ asset('web/assets/icons/arrow-section.svg') }}" alt="">
                </div>
                <div class="prev">
                    <img src="{{ asset('web/assets/icons/arrow-section.svg') }}" style="transform: rotate(180deg)"
                        alt="">
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')
    @if (auth()->check())
        <script>
            $(document).ready(function() {
                $('#inqBtn').click(function() {
                    var number = 1;
                    Swal.fire({
                        title: 'چه تعداد از این محصول را نیاز دارید؟',
                        input: 'number',
                        inputAttributes: {
                            autocapitalize: 'off',
                            min: 0,
                            value: 1,
                            style: 'text-align:center;'
                        },
                        showCancelButton: false,
                        confirmButtonText: 'استعلام',
                        showLoaderOnConfirm: true,
                        showLoaderOnConfirm: true,
                        preConfirm: (value) => {
                            number = value;
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "post",
                                url: "{{ route('user.inquiry.store') }}",
                                data: {
                                    'product_id': {{ $product->id }},
                                    'number': number,
                                    '_token': '<?php echo csrf_token(); ?>',
                                },
                                success: function(response) {
                                    if (response.status) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'تبریک',
                                            text: response.text,
                                            confirmButtonText: 'متوجه شدم',
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'خطا',
                                            text: response.text,
                                            confirmButtonText: 'متوجه شدم',
                                        })
                                    }
                                }
                            });
                        }
                    })
                });
            });
        </script>
    @else
        <script>
            $(document).ready(function() {
                $('#inqBtn').click(function() {
                    Swal.fire({
                        icon: "error",
                        title: "",
                        text: "برای استفاده از امکانات سایت وارد شوید.",
                        footer: '<a href="https://sanatyariran.com/panel">ورود</a>',
                        showConfirmButton: false,
                    })
                });
            });
        </script>
    @endif
@endsection
