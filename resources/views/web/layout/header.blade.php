<header>
    <div class="header-searchbar container">
        <div class="header-menu-toggle">
            <div id="menu-wrapper">
                <div id="hamburger-menu"><span></span><span></span><span></span></div>
                <!-- hamburger-menu -->
            </div>
            <!--            <button type="button">-->
            <!--                <img src="../assets/icons/Menu.svg" mobile-menu-toggle alt="">-->
            <!--            </button>-->
        </div>
        <div class="header-top-right">
            <a href="https://sanatyariran.com"><img src="{{asset('web/assets/images/logo.png')}}" alt="" class="header-logo"></a>
            <form class="header-search-input" method="get" id="headerSearchFrom">
                <div class="header-search-input-wrapper">
                    <button type="submit">
                        <img src="{{asset('web/assets/icons/search.svg')}}">
                    </button>
                    <input type="text" placeholder="جستجو..." class="btn-xl" id="headerSearchText">
                    <select class="body-s" id="headerSearchType">
                        <option value="product" selected>محصولات</option>
                        <option value="brand">شرکت‌ها</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="header-top-left">
            <div class="header-change-language">
                <button type="button" class="header-change-language-btn">
                    <img src="{{asset('web/assets/icons/iran-flag.svg')}}" alt="">
                    <span class="subtitle-m">فارسی</span>
                    <img src="{{asset('web/assets/icons/down2.svg')}}" alt="">
                </button>
                <div uk-dropdown="mode:click" class="header-change-language-dropdown">
                    <ul class="header-change-language-list">
{{--                        <li>--}}
{{--                            <a href="#">--}}
{{--                                <img src="{{asset('web/assets/icons/iran-flag.svg')}}" alt="">--}}
{{--                                <span class="subtitle-m">فارسی</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">--}}
{{--                                <img src="{{asset('web/assets/icons/iran-flag.svg')}}" alt="">--}}
{{--                                <span class="subtitle-m">فارسی</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">--}}
{{--                                <img src="{{asset('web/assets/icons/iran-flag.svg')}}" alt="">--}}
{{--                                <span class="subtitle-m">فارسی</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </div>
            @if(auth()->user())
                <a href="{{url('/panel')}}" class="header-profile-link">
                    <img src="{{asset('web/assets/icons/profileSquare.svg')}}" alt="">
                    <span class="btn-xl">داشبورد</span>
                </a>
            @else
                <a href="{{url('/panel')}}" class="header-profile-link">
                    <img src="{{asset('web/assets/icons/profileSquare.svg')}}" alt="">
                    <span class="btn-xl">ورود | ثبت‌نام</span>
                </a>
            @endif
        </div>
    </div>
</header>
<nav class="mobile-navbar-bar">
    <ul class="mobile-navbar-list">
        <li class="mobile-navbar-category-list-toggle subtitle-m">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.66699 4.6665C2.66699 4.04525 2.66699 3.73462 2.76849 3.48959C2.90381 3.16289 3.16338 2.90332 3.49008 2.768C3.73511 2.6665 4.04574 2.6665 4.66699 2.6665C5.28825 2.6665 5.59888 2.6665 5.8439 2.768C6.17061 2.90332 6.43017 3.16289 6.5655 3.48959C6.66699 3.73462 6.66699 4.04525 6.66699 4.6665C6.66699 5.28776 6.66699 5.59839 6.5655 5.84342C6.43017 6.17012 6.17061 6.42968 5.8439 6.56501C5.59888 6.6665 5.28825 6.6665 4.66699 6.6665C4.04574 6.6665 3.73511 6.6665 3.49008 6.56501C3.16338 6.42968 2.90381 6.17012 2.76849 5.84342C2.66699 5.59839 2.66699 5.28776 2.66699 4.6665Z"
                      stroke="#252525" stroke-width="1.5"/>
                <path d="M9.33366 4.6665C9.33366 4.04525 9.33366 3.73462 9.43515 3.48959C9.57048 3.16289 9.83004 2.90332 10.1567 2.768C10.4018 2.6665 10.7124 2.6665 11.3337 2.6665C11.9549 2.6665 12.2655 2.6665 12.5106 2.768C12.8373 2.90332 13.0968 3.16289 13.2322 3.48959C13.3337 3.73462 13.3337 4.04525 13.3337 4.6665C13.3337 5.28776 13.3337 5.59839 13.2322 5.84342C13.0968 6.17012 12.8373 6.42968 12.5106 6.56501C12.2655 6.6665 11.9549 6.6665 11.3337 6.6665C10.7124 6.6665 10.4018 6.6665 10.1567 6.56501C9.83004 6.42968 9.57048 6.17012 9.43515 5.84342C9.33366 5.59839 9.33366 5.28776 9.33366 4.6665Z"
                      stroke="#252525" stroke-width="1.5"/>
                <path d="M2.66699 11.3332C2.66699 10.7119 2.66699 10.4013 2.76849 10.1563C2.90381 9.82956 3.16338 9.56999 3.49008 9.43466C3.73511 9.33317 4.04574 9.33317 4.66699 9.33317C5.28825 9.33317 5.59888 9.33317 5.8439 9.43466C6.17061 9.56999 6.43017 9.82956 6.5655 10.1563C6.66699 10.4013 6.66699 10.7119 6.66699 11.3332C6.66699 11.9544 6.66699 12.2651 6.5655 12.5101C6.43017 12.8368 6.17061 13.0964 5.8439 13.2317C5.59888 13.3332 5.28825 13.3332 4.66699 13.3332C4.04574 13.3332 3.73511 13.3332 3.49008 13.2317C3.16338 13.0964 2.90381 12.8368 2.76849 12.5101C2.66699 12.2651 2.66699 11.9544 2.66699 11.3332Z"
                      stroke="#252525" stroke-width="1.5"/>
                <path d="M9.33366 11.3332C9.33366 10.7119 9.33366 10.4013 9.43515 10.1563C9.57048 9.82956 9.83004 9.56999 10.1567 9.43466C10.4018 9.33317 10.7124 9.33317 11.3337 9.33317C11.9549 9.33317 12.2655 9.33317 12.5106 9.43466C12.8373 9.56999 13.0968 9.82956 13.2322 10.1563C13.3337 10.4013 13.3337 10.7119 13.3337 11.3332C13.3337 11.9544 13.3337 12.2651 13.2322 12.5101C13.0968 12.8368 12.8373 13.0964 12.5106 13.2317C12.2655 13.3332 11.9549 13.3332 11.3337 13.3332C10.7124 13.3332 10.4018 13.3332 10.1567 13.2317C9.83004 13.0964 9.57048 12.8368 9.43515 12.5101C9.33366 12.2651 9.33366 11.9544 9.33366 11.3332Z"
                      stroke="#252525" stroke-width="1.5"/>
            </svg>
            همه دسته‌ بندی ‌ها
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.6103 8.77346C14.8532 8.5283 14.8515 8.13257 14.6063 7.88959C14.3611 7.6466 13.9654 7.64837 13.7224 7.89353L12.2663 9.36267C11.6754 9.95892 11.2687 10.3679 10.9241 10.6447C10.5893 10.9135 10.3743 11.0057 10.1818 11.0303C10.0608 11.0457 9.9385 11.0457 9.81759 11.0303C9.62502 11.0057 9.41001 10.9135 9.07526 10.6447C8.73066 10.3679 8.32396 9.95892 7.73301 9.36267L6.27692 7.89353C6.03393 7.64837 5.63821 7.6466 5.39304 7.88959C5.14788 8.13257 5.14611 8.5283 5.3891 8.77346L6.87142 10.2691C7.42971 10.8324 7.886 11.2928 8.29256 11.6193C8.71533 11.9588 9.14445 12.2046 9.65954 12.2702C9.8854 12.299 10.114 12.299 10.3398 12.2702C10.8549 12.2046 11.284 11.9588 11.7068 11.6193C12.1134 11.2928 12.5696 10.8324 13.1279 10.2691L14.6103 8.77346Z"
                      fill="#252525"/>
            </svg>
        </li>
        <ul class="mobile-navbar-category-list">
        @foreach($categories as $category)
                <li><a href="{{ url('/fa/product') . '?' . http_build_query(['category_id' => $category['id']]) }}">{{$category['name']}}</a></li>
        @endforeach
        </ul>
        <li><a href="{{url('/fa/product')}}">محصولات و خدمات</a></li>
        <li><a href="{{url('/fa/brands')}}"> شرکت ها</a></li>
        <li><a href="{{url('/fa/news')}}">مجله صنعت یار</a></li>
        {{-- <li><a href="{{url('/fa/pages/%D8%AF%D8%B1%D8%A8%D8%A7%D8%B1%D9%87-%D9%85%D8%A7')}}">درباره ما</a></li>
        <li><a href="{{url('/')}}">تماس با ما</a></li> --}}
    </ul>
</nav>

<!--Desktop Navbar-->
<nav class="desktop-navbar container">
    <div class="desktop-nav-list-wrapper">
        <ul class="desktop-navbar-list">
            <li class="desktop-nav-list-categories-item">
                <img src="{{asset('web/assets/icons/category.svg')}}" alt="">
                همه دسته‌بندی‌ها
                <img src="{{asset('web/assets/icons/arrow-down.svg')}}" alt="">
            </li>
            {{-- <li><a href="{{url('/fa/product')}}">محصولات صادراتی</a></li> --}}
            <li><a href="{{url('/fa/product')}}">محصولات و خدمات</a></li>
            <li><a href="{{url('/fa/brands')}}"> شرکت‌ها</a></li>
            <li><a href="{{url('/fa/news')}}">مجله صنعت‌یار</a></li>
            {{-- <li><a href="{{url('/fa/pages/%D8%AF%D8%B1%D8%A8%D8%A7%D8%B1%D9%87-%D9%85%D8%A7')}}">درباره ما</a></li>
            <li><a href="{{url('/')}}">تماس با ما</a></li> --}}
        </ul>
    </div>
    <div>
        <button type="button" class="header-location-btn">
            <img src="{{asset('web/assets/icons/location.svg')}}" alt="">
            <span>انتخاب موقعیت</span>
        </button>
    </div>
</nav>
<!--Desktop Categories-->
<div class="desktop-nav-categories-wrapper container">
    <div class="desktop-nav-categories-tabs">
        <ul class="desktop-nav-categories-tabs-list">
            @foreach($categories as $category)
                <li class="desktop-nav-categories-tab-item" data-tab="{{$category['id']}}">
                    <img src="../assets/icons/arrow-left.svg" class="desktop-nav-categories-tab-item-icon-active" alt="">
                    <img src="../assets/icons/arrow-left-active.svg" class="desktop-nav-categories-tab-item-icon" alt="">
                    {{$category['name']}}
                </li>
            @endforeach
        </ul>
    </div>
    <div class="desktop-nav-categories-pages" style="background-color: #fff;">
        @foreach($categories as $category)
            <div class="desktop-nav-categories-page-wrapper" data-tab="{{$category['id']}}">
                <a href="{{ url('/fa/product') . '?' . http_build_query(['category_id' => $category['id']]) }}" class="desktop-nav-categories-page-all-btn">مشاهده همه <img
                        src="{{asset('/web/assets/icons/arrow-left-active.svg')}}" alt=""></a>
                <div class="desktop-nav-categories-page">
                    @foreach($category['subcategories'] as $subCat)
                        <ul class="desktop-nav-categories-page-list" aria-label="{{$subCat['name']}}">
                            @foreach($subCat['subcategories'] as $childCat)
                                <li class="desktop-nav-categories-page-list-link">{{$childCat['name']}}</li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
