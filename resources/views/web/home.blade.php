@extends('web.layout.layout')
@section('title')
    <title>صنعت یار ایران - خانه</title>
@endsection
@section('content')
    <main class="home">
        <section class="home-search-section">
            <div>
                <h1 class="h1">صنعت یار ایران</h1>
                <p class="caption-m">شتاب دهنده تقویت و تسهیل زنجیره تامین صنعت کشور</p>
                <form action="{{url('/fa/product')}}" method="get" class="main-search-form-wrapper">
                    <div>
                        <label>
                            <input type="text" name="search" placeholder="جستجو"/>
                        </label>
                        <button type="submit">
                            <img src="{{url('web/assets/icons/main-search.svg')}}">
                        </button>
                    </div>
                </form>
            </div>
            <img src="{{url('web/assets/icons/main-gear1.svg')}}" class="gear1" alt="">
            <img src="{{url('web/assets/icons/main-gear2.svg')}}" class="gear2" alt="">
            <img src="{{url('web/assets/icons/main-gear3.svg')}}" class="gear3" alt="">
        </section>

        <section class="home-search-section2 container">
            <div class="card">
                <img src="{{url('web/assets/icons/automation-system-card-main-search.svg')}}" alt="">
                <p class="h6 uk-text-bold">استعلام محصولات</p>
                <p class="caption-s">در سریع ترین زمان ممکن محصولات مد نظر خود را از کارخانه سازنده استعلام بگیرید.</p>
            </div>
            <div class="card">
                <img src="{{url('web/assets/icons/arrows-main-search.svg')}}" alt="">
                <p class="h6 uk-text-bold">بدون واسطه</p>
                <p class="caption-s">ارتباط مستقیم با تامین کنندگان و شرکت ها داشته باشید.</p>
            </div>
            <div class="card">
                <img src="{{url('web/assets/icons/companies-info-card-main-search.svg')}}" alt="">
                <p class="h6 uk-text-bold">اطلاعات شرکت ها</p>
                <p class="caption-s">اطلاعات بیش از 10 هزار شرکت و کارخانه را به راحتی در اختیار داشته باشید.</p>
            </div>
            <div class="card">
                <img src="{{url('web/assets/icons/automation-system-card-main-search.svg')}}" alt="">
                <p class="h6 uk-text-bold">اتوماسیون اداری</p>
                <p class="caption-s">صدور و دریافت انواع نامه های الکترونیکی، بخشنامه و هزاران امکانات دیگر در صنعت
                    نامه.</p>
            </div>
        </section>

        <section class="home-categories container main-section">
            <h3 class="h3">دسته‌بندی‌ها</h3>
            <div dir="rtl" class="swiper categorySwiper">
                <div class="swiper-wrapper">
                    @foreach($categories->chunk(2) as $chunk)
                        <div class="swiper-slide">
                            <div>
                                @foreach($chunk as $category)
                                <a href="{{ url('/fa/product') . '?' . http_build_query(['category_id' => $category['id']]) }}">
                                    <img src="{{asset($category->image)}}" alt="" style="width: 120px;height: 120px;border-radius: 50%;">
                                    <p>{{$category->name}}</p>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="next">
                    <img src="{{url('web/assets/icons/arrow-section.svg')}}" alt="">
                </div>
                <div class="prev">
                    <img src="{{url('web/assets/icons/arrow-section.svg')}}" style="transform: rotate(180deg)" alt="">
                </div>
            </div>
        </section>

        <section class="home-categories container main-section">
            <h3 class="h3">محصولات برتر</h3>
            <div dir="rtl" class="swiper productListSwiper">
                <div class="swiper-wrapper">
                    @foreach($BestSellerProducts as $product)
                        <div class="swiper-slide">
                            <div class="product-card">
                                <div class="product-card-image">
                                    <a href="{{route('user.product.show' , ['slug'=>$product->slug])}}">
                                        <img src="{{asset($product->image)}}" alt="">
                                    </a>
                                    @if($product->isExportable) <span class="product-card-ribbon">صادراتی</span> @endif
                                </div>
                                <p class="product-card-title"><a>{{$product->name}}</a></p>
                                <div class="product-card-footer">
                                    <div class="product-card-location">
                                        <svg width="8" height="11" viewBox="0 0 8 11" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M5.3904 9.35024C6.54527 7.87755 8 5.73796 8 4.30435C8 1.92712 6.20914 0 4 0C1.79086 0 0 1.92712 0 4.30435C0 5.73796 1.45473 7.87755 2.6096 9.35024C3.21212 10.1186 3.51338 10.5027 4 10.5027C4.48662 10.5027 4.78788 10.1186 5.3904 9.35024ZM4 6C3.17157 6 2.5 5.32843 2.5 4.5C2.5 3.67157 3.17157 3 4 3C4.82843 3 5.5 3.67157 5.5 4.5C5.5 5.32843 4.82843 6 4 6Z"
                                                  fill="#71787F"/>
                                        </svg>
                                        {{$product->province ? $product->province->name : ''}}، {{$product->city ? $product->city->name : ''}}
                                    </div>
                                    <div class="product-card-location">
                                        <svg width="8" height="11" viewBox="0 0 8 11" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M5.3904 9.35024C6.54527 7.87755 8 5.73796 8 4.30435C8 1.92712 6.20914 0 4 0C1.79086 0 0 1.92712 0 4.30435C0 5.73796 1.45473 7.87755 2.6096 9.35024C3.21212 10.1186 3.51338 10.5027 4 10.5027C4.48662 10.5027 4.78788 10.1186 5.3904 9.35024ZM4 6C3.17157 6 2.5 5.32843 2.5 4.5C2.5 3.67157 3.17157 3 4 3C4.82843 3 5.5 3.67157 5.5 4.5C5.5 5.32843 4.82843 6 4 6Z"
                                                  fill="#71787F"/>
                                        </svg>
                                        <a href="{{$product->brand ? route('user.brands.show' , ['slug'=>$product->brand->slug]) : 'javascript:void(0);'}}">{{$product->brand ? $product->brand->name : ''}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="next">
                    <img src="{{asset('web/assets/icons/arrow-section.svg')}}" alt="">
                </div>
                <div class="prev">
                    <img src="{{asset('web/assets/icons/arrow-section.svg')}}" style="transform: rotate(180deg)" alt="">
                </div>
            </div>
        </section>

        <section class="home-ads-banner container">
            <div dir="rtl" class="swiper homeAdsBanner1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div>
                            <img src="{{asset('web/assets/images/image-1.png')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="next">
                    <img src="{{asset('web/assets/icons/arrow-section.svg')}}" alt="">
                </div>
                <div class="prev">
                    <img src="{{asset('web/assets/icons/arrow-section.svg')}}" style="transform: rotate(180deg)" alt="">
                </div>
            </div>
        </section>

        <section class="container main-section home-best-seller">
            <h3 class="h3">شرکت‌های برتر</h3>
            <div class="home-best-seller-wrapper">
                @foreach ($bestBrands as $brand)
                    <a href="{{route('user.brands.show' , ['slug'=>$brand->slug])}}"><img src="{{asset($brand->logo_path)}}" alt=""></a>
                @endforeach
            </div>
        </section>

        @foreach ($suggestCategories as $sCat)
        <section class="container main-section home-best-category-products">
            <div class="home-best-category-products-header">
                <h3 class="h3">{{$sCat['name']}}</h3>
                <a href="{{ url('/fa/product') . '?' . http_build_query(['category_id' => $sCat['id']]) }}" class="subtitle-l">
                    مشاهده همه
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 12.75C20.4142 12.75 20.75 12.4142 20.75 12C20.75 11.5858 20.4142 11.25 20 11.25V12.75ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75V11.25ZM7.47204 17.5327C7.76624 17.8243 8.24111 17.8222 8.53269 17.528C8.82427 17.2338 8.82216 16.7589 8.52796 16.4673L7.47204 17.5327ZM6.23703 15.2527L6.76499 14.72H6.76499L6.23703 15.2527ZM6.23703 8.74731L5.70907 8.21462H5.70907L6.23703 8.74731ZM8.52796 7.53269C8.82216 7.24111 8.82428 6.76624 8.53269 6.47204C8.24111 6.17784 7.76624 6.17573 7.47204 6.46731L8.52796 7.53269ZM4.01989 12.3133L3.27591 12.4082L3.27591 12.4082L4.01989 12.3133ZM4.01989 11.6867L3.27591 11.5918L3.27591 11.5918L4.01989 11.6867ZM20 11.25H4V12.75H20V11.25ZM8.52796 16.4673L6.76499 14.72L5.70907 15.7854L7.47204 17.5327L8.52796 16.4673ZM6.76499 9.28L8.52796 7.53269L7.47204 6.46731L5.70907 8.21462L6.76499 9.28ZM6.76499 14.72C6.0495 14.0109 5.55869 13.5228 5.22659 13.1093C4.904 12.7076 4.79332 12.4496 4.76387 12.2185L3.27591 12.4082C3.35469 13.0263 3.64963 13.5412 4.05706 14.0485C4.45498 14.544 5.01863 15.1011 5.70907 15.7854L6.76499 14.72ZM5.70907 8.21462C5.01863 8.89892 4.45498 9.45597 4.05706 9.95146C3.64963 10.4588 3.3547 10.9737 3.27591 11.5918L4.76387 11.7815C4.79332 11.5504 4.904 11.2924 5.22659 10.8907C5.55869 10.4772 6.0495 9.98914 6.76499 9.28L5.70907 8.21462ZM4.76387 12.2185C4.74538 12.0734 4.74538 11.9266 4.76387 11.7815L3.27591 11.5918C3.24136 11.8629 3.24136 12.1371 3.27591 12.4082L4.76387 12.2185Z"
                              fill="#19BAC7"/>
                    </svg>
                </a>
            </div>
            <div class="home-best-category-products-wrapper">
                <div class="home-best-category-products-wrapper-grids">
                    @foreach ($suggestCategoriesProducts[$sCat['id']] as $SPC)
                    <div class="home-best-category-products-wrapper-grid">
                        @foreach ($SPC as $p)
                        <div>
                            <a href="{{route('user.product.show' , ['slug'=>$p->slug])}}">
                                <img src="{{asset($p->image)}}" alt="">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
            <div style="text-align: center; padding-top: 15px;">
                <a href="{{ url('/fa/product') . '?' . http_build_query(['category_id' => $sCat['id']]) }}" class="subtitle-l show-all">
                    مشاهده همه
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 12.75C20.4142 12.75 20.75 12.4142 20.75 12C20.75 11.5858 20.4142 11.25 20 11.25V12.75ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75V11.25ZM7.47204 17.5327C7.76624 17.8243 8.24111 17.8222 8.53269 17.528C8.82427 17.2338 8.82216 16.7589 8.52796 16.4673L7.47204 17.5327ZM6.23703 15.2527L6.76499 14.72H6.76499L6.23703 15.2527ZM6.23703 8.74731L5.70907 8.21462H5.70907L6.23703 8.74731ZM8.52796 7.53269C8.82216 7.24111 8.82428 6.76624 8.53269 6.47204C8.24111 6.17784 7.76624 6.17573 7.47204 6.46731L8.52796 7.53269ZM4.01989 12.3133L3.27591 12.4082L3.27591 12.4082L4.01989 12.3133ZM4.01989 11.6867L3.27591 11.5918L3.27591 11.5918L4.01989 11.6867ZM20 11.25H4V12.75H20V11.25ZM8.52796 16.4673L6.76499 14.72L5.70907 15.7854L7.47204 17.5327L8.52796 16.4673ZM6.76499 9.28L8.52796 7.53269L7.47204 6.46731L5.70907 8.21462L6.76499 9.28ZM6.76499 14.72C6.0495 14.0109 5.55869 13.5228 5.22659 13.1093C4.904 12.7076 4.79332 12.4496 4.76387 12.2185L3.27591 12.4082C3.35469 13.0263 3.64963 13.5412 4.05706 14.0485C4.45498 14.544 5.01863 15.1011 5.70907 15.7854L6.76499 14.72ZM5.70907 8.21462C5.01863 8.89892 4.45498 9.45597 4.05706 9.95146C3.64963 10.4588 3.3547 10.9737 3.27591 11.5918L4.76387 11.7815C4.79332 11.5504 4.904 11.2924 5.22659 10.8907C5.55869 10.4772 6.0495 9.98914 6.76499 9.28L5.70907 8.21462ZM4.76387 12.2185C4.74538 12.0734 4.74538 11.9266 4.76387 11.7815L3.27591 11.5918C3.24136 11.8629 3.24136 12.1371 3.27591 12.4082L4.76387 12.2185Z"
                              fill="#19BAC7"/>
                    </svg>
                </a>
            </div>
        </section>
        @endforeach

        <section class="container homeAdsBanner2-wrapper">
            <div class="homeAdsBanner2">
                <div><img src="{{asset('web/assets/images/ads.png')}}" alt=""></div>
                <div><img src="{{asset('web/assets/images/ads.png')}}" alt=""></div>
                <div><img src="{{asset('web/assets/images/ads.png')}}" alt=""></div>
                <div><img src="{{asset('web/assets/images/ads.png')}}" alt=""></div>
            </div>
        </section>

        <section class="container main-section home-new-brands">
            <h3 class="h3">جدیدترین شرکت</h3>
            <div class="home-new-brands-wrapper">
                @foreach ($newBrands as $b)
                <div class="company-card">
                    <div class="company-card-img"><img
                            src="{{asset($b->logo_path)}}"
                            alt=""></div>
                    <div class="company-card-info">
                        <div class="company-card-title">{{$b->name}}</div>
                        <div class="company-card-category">{{$b->category ? $b->category->name : ''}}</div>
                        <div class="company-card-location">
                            <svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M5.3904 9.35024C6.54527 7.87755 8 5.73796 8 4.30435C8 1.92712 6.20914 0 4 0C1.79086 0 0 1.92712 0 4.30435C0 5.73796 1.45473 7.87755 2.6096 9.35024C3.21212 10.1186 3.51338 10.5027 4 10.5027C4.48662 10.5027 4.78788 10.1186 5.3904 9.35024ZM4 6C3.17157 6 2.5 5.32843 2.5 4.5C2.5 3.67157 3.17157 3 4 3C4.82843 3 5.5 3.67157 5.5 4.5C5.5 5.32843 4.82843 6 4 6Z"
                                      fill="#71787F"/>
                            </svg>
                            {{$b->province ? $b->province->name.',' : ''}}
                            {{$b->city ? $b->city->name : ''}}
                        </div>
                        <a href="{{route('user.brands.show', ['slug'=>$b->slug])}}" class="show-company">مشاهده</a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <section class="container main-section main-ads3">
            <div class="main-ads3-wrapper">
                <div>
                    <img src="{{asset('web/assets/images/ads3-1.png')}}" alt="">
                </div>
                <div>
                    <img src="{{asset('web/assets/images/ads3-2.png')}}" alt="">
                </div>
            </div>
        </section>

        <section class="container main-section home-news">
            <h3 class="h3">مجله خبری</h3>
            <div class="home-news-wrapper">
                @foreach ($newNews as $post)
                <div class="home-news-card">
                    <div class="home-news-card-img"><img src="{{asset($post['box_image_path'])}}" alt=""></div>
                    <div class="home-news-card-info">
                        <div class="home-news-card-title">{{$post['title']}}</div>
                        <div class="home-news-card-text">{{$post['summary']}}</div>
                    </div>
                    <div class="home-news-card-footer">
                        <a href="{{route('user.news.show' , ['id'=>$post['id']])}}" class="show-news">
                            مشاهده
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.8337 9.25008C14.2479 9.25008 14.5837 8.91429 14.5837 8.50008C14.5837 8.08587 14.2479 7.75008 13.8337 7.75008V9.25008ZM3.16699 7.75008C2.75278 7.75008 2.41699 8.08587 2.41699 8.50008C2.41699 8.91429 2.75278 9.25008 3.16699 9.25008V7.75008ZM5.3057 12.3661C5.5999 12.6577 6.07477 12.6556 6.36635 12.3614C6.65793 12.0672 6.65581 11.5923 6.36162 11.3007L5.3057 12.3661ZM4.65835 10.6685L5.18631 10.1359L4.65835 10.6685ZM4.65835 6.33162L4.13039 5.79893L4.13039 5.79893L4.65835 6.33162ZM6.36162 5.69944C6.65582 5.40786 6.65793 4.93299 6.36635 4.63879C6.07477 4.34459 5.5999 4.34247 5.3057 4.63406L6.36162 5.69944ZM3.18025 8.70897L2.43627 8.8038L2.43627 8.8038L3.18025 8.70897ZM3.18025 8.29119L2.43627 8.19636L2.43627 8.19636L3.18025 8.29119ZM13.8337 7.75008H3.16699V9.25008H13.8337V7.75008ZM6.36162 11.3007L5.18631 10.1359L4.13039 11.2012L5.3057 12.3661L6.36162 11.3007ZM5.1863 6.86431L6.36162 5.69944L5.3057 4.63406L4.13039 5.79893L5.1863 6.86431ZM5.18631 10.1359C4.70513 9.65895 4.39007 9.34509 4.17964 9.08307C3.97872 8.83288 3.93565 8.70369 3.92423 8.61414L2.43627 8.8038C2.49702 9.28038 2.72435 9.66649 3.01011 10.0223C3.28636 10.3663 3.67427 10.7492 4.13039 11.2012L5.18631 10.1359ZM4.13039 5.79893C3.67427 6.251 3.28636 6.63386 3.01011 6.97785C2.72435 7.33367 2.49702 7.71978 2.43627 8.19636L3.92423 8.38602C3.93565 8.29647 3.97872 8.16728 4.17964 7.91709C4.39007 7.65507 4.70513 7.34121 5.1863 6.86431L4.13039 5.79893ZM3.92423 8.61414C3.91458 8.5384 3.91458 8.46176 3.92423 8.38602L2.43627 8.19636C2.41057 8.39804 2.41057 8.60213 2.43627 8.8038L3.92423 8.61414Z"
                                      fill="#19BAC7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>
    <div id="overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

    <div id="customAlert" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); border-radius: 10px; text-align: center; z-index: 1000;">
        <p style="margin: 0 0 15px; font-size: 16px;">صنعت یار با ظاهر جدید در دسترس است</p>
        <button onclick="redirect()" style="margin: 5px; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px; background: #007bff; color: white;">رفتن به ظاهر جدید</button>
        <button onclick="closeAlert()" style="margin: 5px; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px; background: #6c757d; color: white;">ادامه</button>
    </div>
    <script>
        function redirect() {
            window.location.href = "https://sanatyariran.com/new";
        }

        function closeAlert() {
            document.getElementById('customAlert').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
@endsection
