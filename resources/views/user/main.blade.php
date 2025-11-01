@extends('user.layout.master')
@section('head')
    <title>محصولات و خدمات</title>
    <style>
        .mainHeader::before {
            background: url('{{ asset('image/products.jpg') }}');
        }
    </style>
@endsection
@section('bodyStyle')
    home
@endsection
@section('content')
    <main class="productsMain pb-4">
        <div class="mainHeader">
            <h1 class="mainHeaderHeader">
                محصولات و خدمات ثبت شده
            </h1>
            <form action="{{ route('user.search.index') }}" method="get" class="searchForm" id="searchForm">
                <div>
                    <button class="searchBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21"
                            fill="none">
                            <g clip-path="url(#clip0_69_357)">
                                <path
                                    d="M12.918 15.5713L17.8672 20.5166C18.3555 21.0049 19.1484 21.0049 19.6367 20.5166C20.125 20.0283 20.125 19.2353 19.6367 18.747L14.6875 13.8017C14.1914 14.4775 13.5937 15.0752 12.918 15.5713Z"
                                    fill="#0A0E29" />
                                <path opacity="0.4"
                                    d="M8.125 3.38376C8.86369 3.38376 9.59514 3.52925 10.2776 3.81194C10.9601 4.09462 11.5801 4.50895 12.1025 5.03128C12.6248 5.55361 13.0391 6.17371 13.3218 6.85616C13.6045 7.53862 13.75 8.27007 13.75 9.00876C13.75 9.74744 13.6045 10.4789 13.3218 11.1614C13.0391 11.8438 12.6248 12.4639 12.1025 12.9862C11.5801 13.5086 10.9601 13.9229 10.2776 14.2056C9.59514 14.4883 8.86369 14.6338 8.125 14.6338C7.38631 14.6338 6.65486 14.4883 5.97241 14.2056C5.28995 13.9229 4.66985 13.5086 4.14752 12.9862C3.62519 12.4639 3.21086 11.8438 2.92818 11.1614C2.64549 10.4789 2.5 9.74744 2.5 9.00876C2.5 8.27007 2.64549 7.53862 2.92818 6.85616C3.21086 6.17371 3.62519 5.55361 4.14752 5.03128C4.66985 4.50895 5.28995 4.09462 5.97241 3.81194C6.65486 3.52925 7.38631 3.38376 8.125 3.38376ZM8.125 17.1338C10.2799 17.1338 12.3465 16.2777 13.8702 14.754C15.394 13.2303 16.25 11.1636 16.25 9.00876C16.25 6.85387 15.394 4.78725 13.8702 3.26352C12.3465 1.73978 10.2799 0.883759 8.125 0.883759C5.97012 0.883759 3.90349 1.73978 2.37976 3.26352C0.856024 4.78725 0 6.85387 0 9.00876C0 11.1636 0.856024 13.2303 2.37976 14.754C3.90349 16.2777 5.97012 17.1338 8.125 17.1338Z"
                                    fill="#0A0E29" />
                            </g>
                            <defs>
                                <clipPath id="clip0_69_357">
                                    <rect width="20" height="20" fill="white" transform="translate(0 0.883759)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <input type="text" class="searchInput" id="search" name="search"
                        @if (isset($_GET['search'])) value="{{ $_GET['search'] }}" @endif
                        placeholder="جستجو در میان هزاران محصول صنعتی، مواد اولیه، تجهیزات و خدمات">
                </div>
                <div class="filters">
                    <span class="filtersIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="38" viewBox="0 0 40 38"
                            fill="none">
                            <g clip-path="url(#clip0_69_384)">
                                <path
                                    d="M32.5 4.60468H37.5C38.8828 4.60468 40 5.64392 40 6.93026C40 8.21659 38.8828 9.25584 37.5 9.25584H32.5C31.1172 9.25584 30 8.21659 30 6.93026C30 5.64392 31.1172 4.60468 32.5 4.60468ZM25 18.5582C25 17.2718 26.1172 16.2326 27.5 16.2326H37.5C38.8828 16.2326 40 17.2718 40 18.5582C40 19.8445 38.8828 20.8837 37.5 20.8837H27.5C26.1172 20.8837 25 19.8445 25 18.5582ZM25 30.1861C25 28.8997 26.1172 27.8605 27.5 27.8605H37.5C38.8828 27.8605 40 28.8997 40 30.1861C40 31.4724 38.8828 32.5117 37.5 32.5117H27.5C26.1172 32.5117 25 31.4724 25 30.1861Z"
                                    fill="#0A0E29" />
                                <path opacity="0.8"
                                    d="M1.17435 6.80766L1.1758 6.80464C1.49702 6.13231 2.24556 5.65115 3.12506 5.65115H24.3751C25.2546 5.65115 26.0031 6.13231 26.3243 6.80464C26.641 7.46741 26.5192 8.24617 25.979 8.80082L25.9764 8.80352L18.0311 17.023L17.7501 17.3137V17.718V30.2325C17.7501 30.6962 17.4695 31.1628 16.9487 31.4028C16.4096 31.6513 15.7807 31.5938 15.3236 31.2738L15.3222 31.2729L10.3222 27.7845L10.3222 27.7845L10.3175 27.7812C9.94514 27.5247 9.75006 27.1369 9.75006 26.7442V17.718V17.3134L9.46875 17.0227L1.52409 8.81115C1.524 8.81106 1.52392 8.81097 1.52383 8.81089C0.976038 8.24342 0.854945 7.47047 1.17435 6.80766Z"
                                    fill="white" stroke="#0A0E29" stroke-width="2" />
                            </g>
                            <defs>
                                <clipPath id="clip0_69_384">
                                    <rect width="40" height="37.2093" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </span>
                    <select class="form-select filterSelect" name="category_id" id="category_id">
                        <option value="">دسته بندی</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (isset($_GET['category_id']) && $_GET['category_id'] == $category->id) selected @endif>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select filterSelect" name="province_id" id="province_id">
                        <option value="">استان</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" @if (isset($_GET['province_id']) && $_GET['province_id'] == $province->id) selected @endif>
                                {{ $province->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select filterSelect" name="city_id" id="city_id">
                        <option value="">شهر</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select filterSelect" name="ipark_id" id="ipark_id">
                        <option value="">شهرک صنعتی</option>
                        @foreach ($iparks as $ipark)
                            <option value="{{ $ipark->id }}" data-province="{{ $ipark->province_id }}"
                                @if (isset($_GET['iparks']) && $_GET['iparks'] == $ipark->id) selected @endif>
                                {{ $ipark->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="container" id="categoryContainer">
            <div class="sectionTitle">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path
                        d="M8.75 3.125C8.75 2.08984 7.91016 1.25 6.875 1.25H3.125C2.08984 1.25 1.25 2.08984 1.25 3.125V6.875C1.25 7.91016 2.08984 8.75 3.125 8.75H6.875C7.91016 8.75 8.75 7.91016 8.75 6.875V3.125ZM18.75 13.125C18.75 12.0898 17.9102 11.25 16.875 11.25H13.125C12.0898 11.25 11.25 12.0898 11.25 13.125V16.875C11.25 17.9102 12.0898 18.75 13.125 18.75H16.875C17.9102 18.75 18.75 17.9102 18.75 16.875V13.125Z"
                        fill="#0A0E29" />
                    <path opacity="0.4"
                        d="M18.75 2.8125C18.75 1.94922 18.0508 1.25 17.1875 1.25H12.8125C11.9492 1.25 11.25 1.94922 11.25 2.8125V7.1875C11.25 8.05078 11.9492 8.75 12.8125 8.75H17.1875C18.0508 8.75 18.75 8.05078 18.75 7.1875V2.8125ZM8.75 12.8125C8.75 11.9492 8.05078 11.25 7.1875 11.25H2.8125C1.94922 11.25 1.25 11.9492 1.25 12.8125V17.1875C1.25 18.0508 1.94922 18.75 2.8125 18.75H7.1875C8.05078 18.75 8.75 18.0508 8.75 17.1875V12.8125Z"
                        fill="#FD7E14" />
                </svg>
                <span class="sectionTitleHeader">
                    دسته‌بندی‌ها
                </span>
            </div>
            <div class="row categoryWrapper mt-4 w-100">
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/powerCategory.png') }}" alt="" class="categoryImage lazy">
                    <span class="categoryTitle" data-category-id="6">برق و الکترونیک</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/bildingCategory.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="170">تجهیزات ساختمانی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/EnergyCategory.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="265">آب و انرژی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/machinCategory.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="4">ماشین آلات</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/oilCategory.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="5">صنایع پتروشیمی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/metalCategory.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="1">صنایع فلزی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/boxing.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="3">بسته بندی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/service.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="195">خدمات صنعتی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/food.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="197">فرآورده های غذایی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/nakh.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="199">منسوجات و پوشاک</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/kesht.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="207">کشاورزی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/chimy.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="222">شیمیایی و دارویی</span>
                </div>

                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/mobl.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="269">مبلمان و لوازم خانگی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/behdasht.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="247">بهداشتی و آرایشی</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/madan.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="292">معادن</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/car.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="319">صنعت خودرو</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/choob.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="320">صنایع چوب و کاغذ</span>
                </div>
                <div class="col-3 col-xxl-2 item mt-3">
                    <img data-src="{{ asset('image/other.png') }}" alt="" class="categoryImage">
                    <span class="categoryTitle" data-category-id="318">سایر</span>
                </div>
            </div>
            <div class="text-center mt-5">
                <div class="ad1350x200box d-inline-block">
                    <a href="" class="adLink">
                        <img data-src="{{ asset('image/tabligh1.png') }}" class="adImage" alt="">
                    </a>
                </div>
            </div>
            <div class="sectionTitle mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18"
                    fill="none">
                    <g clip-path="url(#clip0_143_356)">
                        <path
                            d="M4.44461 1.11111C4.44461 0.496528 4.94113 0 5.55572 0H10.0002C10.6147 0 11.1113 0.496528 11.1113 1.11111V5.55556C11.1113 6.17014 10.6147 6.66667 10.0002 6.66667C9.38558 6.66667 8.88905 6.17014 8.88905 5.55556V3.79514L1.896 10.7847C1.46197 11.2188 0.757107 11.2188 0.323079 10.7847C-0.110948 10.3507 -0.110948 9.64583 0.323079 9.2118L7.31613 2.22222H5.55572C4.94113 2.22222 4.44461 1.72569 4.44461 1.11111Z"
                            fill="#0A0E29" />
                        <path opacity="0.4"
                            d="M18.3335 4.44445C18.7755 4.44445 19.1994 4.26885 19.512 3.95629C19.8246 3.64373 20.0002 3.21981 20.0002 2.77778C20.0002 2.33575 19.8246 1.91183 19.512 1.59927C19.1994 1.28671 18.7755 1.11111 18.3335 1.11111C17.8915 1.11111 17.4675 1.28671 17.155 1.59927C16.8424 1.91183 16.6668 2.33575 16.6668 2.77778C16.6668 3.21981 16.8424 3.64373 17.155 3.95629C17.4675 4.26885 17.8915 4.44445 18.3335 4.44445ZM13.8891 8.88889C14.3311 8.88889 14.755 8.7133 15.0676 8.40074C15.3801 8.08818 15.5557 7.66425 15.5557 7.22223C15.5557 6.7802 15.3801 6.35627 15.0676 6.04371C14.755 5.73115 14.3311 5.55556 13.8891 5.55556C13.447 5.55556 13.0231 5.73115 12.7105 6.04371C12.398 6.35627 12.2224 6.7802 12.2224 7.22223C12.2224 7.66425 12.398 8.08818 12.7105 8.40074C13.0231 8.7133 13.447 8.88889 13.8891 8.88889ZM15.5557 11.6667C15.5557 11.4478 15.5126 11.2311 15.4289 11.0289C15.3451 10.8267 15.2223 10.6429 15.0676 10.4882C14.9128 10.3334 14.7291 10.2106 14.5269 10.1269C14.3246 10.0431 14.1079 10 13.8891 10C13.6702 10 13.4535 10.0431 13.2512 10.1269C13.049 10.2106 12.8653 10.3334 12.7105 10.4882C12.5558 10.6429 12.433 10.8267 12.3493 11.0289C12.2655 11.2311 12.2224 11.4478 12.2224 11.6667C12.2224 11.8855 12.2655 12.1023 12.3493 12.3045C12.433 12.5067 12.5558 12.6904 12.7105 12.8452C12.8653 12.9999 13.049 13.1227 13.2512 13.2065C13.4535 13.2902 13.6702 13.3333 13.8891 13.3333C14.1079 13.3333 14.3246 13.2902 14.5269 13.2065C14.7291 13.1227 14.9128 12.9999 15.0676 12.8452C15.2223 12.6904 15.3451 12.5067 15.4289 12.3045C15.5126 12.1023 15.5557 11.8855 15.5557 11.6667ZM13.8891 17.7778C14.3311 17.7778 14.755 17.6022 15.0676 17.2896C15.3801 16.9771 15.5557 16.5531 15.5557 16.1111C15.5557 15.6691 15.3801 15.2452 15.0676 14.9326C14.755 14.62 14.3311 14.4444 13.8891 14.4444C13.447 14.4444 13.0231 14.62 12.7105 14.9326C12.398 15.2452 12.2224 15.6691 12.2224 16.1111C12.2224 16.5531 12.398 16.9771 12.7105 17.2896C13.0231 17.6022 13.447 17.7778 13.8891 17.7778ZM18.3335 17.7778C18.7755 17.7778 19.1994 17.6022 19.512 17.2896C19.8246 16.9771 20.0002 16.5531 20.0002 16.1111C20.0002 15.6691 19.8246 15.2452 19.512 14.9326C19.1994 14.62 18.7755 14.4444 18.3335 14.4444C17.8915 14.4444 17.4675 14.62 17.155 14.9326C16.8424 15.2452 16.6668 15.6691 16.6668 16.1111C16.6668 16.5531 16.8424 16.9771 17.155 17.2896C17.4675 17.6022 17.8915 17.7778 18.3335 17.7778ZM11.1113 11.6667C11.1113 11.2246 10.9357 10.8007 10.6231 10.4882C10.3106 10.1756 9.88663 10 9.44461 10C9.00258 10 8.57866 10.1756 8.2661 10.4882C7.95353 10.8007 7.77794 11.2246 7.77794 11.6667C7.77794 12.1087 7.95353 12.5326 8.2661 12.8452C8.57866 13.1577 9.00258 13.3333 9.44461 13.3333C9.88663 13.3333 10.3106 13.1577 10.6231 12.8452C10.9357 12.5326 11.1113 12.1087 11.1113 11.6667ZM9.44461 17.7778C9.88663 17.7778 10.3106 17.6022 10.6231 17.2896C10.9357 16.9771 11.1113 16.5531 11.1113 16.1111C11.1113 15.6691 10.9357 15.2452 10.6231 14.9326C10.3106 14.62 9.88663 14.4444 9.44461 14.4444C9.00258 14.4444 8.57866 14.62 8.2661 14.9326C7.95353 15.2452 7.77794 15.6691 7.77794 16.1111C7.77794 16.5531 7.95353 16.9771 8.2661 17.2896C8.57866 17.6022 9.00258 17.7778 9.44461 17.7778ZM6.66683 16.1111C6.66683 15.6691 6.49123 15.2452 6.17867 14.9326C5.86611 14.62 5.44219 14.4444 5.00016 14.4444C4.55814 14.4444 4.13421 14.62 3.82165 14.9326C3.50909 15.2452 3.3335 15.6691 3.3335 16.1111C3.3335 16.5531 3.50909 16.9771 3.82165 17.2896C4.13421 17.6022 4.55814 17.7778 5.00016 17.7778C5.44219 17.7778 5.86611 17.6022 6.17867 17.2896C6.49123 16.9771 6.66683 16.5531 6.66683 16.1111ZM18.3335 13.3333C18.7755 13.3333 19.1994 13.1577 19.512 12.8452C19.8246 12.5326 20.0002 12.1087 20.0002 11.6667C20.0002 11.2246 19.8246 10.8007 19.512 10.4882C19.1994 10.1756 18.7755 10 18.3335 10C17.8915 10 17.4675 10.1756 17.155 10.4882C16.8424 10.8007 16.6668 11.2246 16.6668 11.6667C16.6668 12.1087 16.8424 12.5326 17.155 12.8452C17.4675 13.1577 17.8915 13.3333 18.3335 13.3333ZM20.0002 7.22223C20.0002 6.7802 19.8246 6.35627 19.512 6.04371C19.1994 5.73115 18.7755 5.55556 18.3335 5.55556C17.8915 5.55556 17.4675 5.73115 17.155 6.04371C16.8424 6.35627 16.6668 6.7802 16.6668 7.22223C16.6668 7.66425 16.8424 8.08818 17.155 8.40074C17.4675 8.7133 17.8915 8.88889 18.3335 8.88889C18.7755 8.88889 19.1994 8.7133 19.512 8.40074C19.8246 8.08818 20.0002 7.66425 20.0002 7.22223Z"
                            fill="#FD7E14" />
                    </g>
                    <defs>
                        <clipPath id="clip0_143_356">
                            <rect width="20" height="17.7778" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <span class="sectionTitleHeader">
                    پربازدید‌ها
                </span>
            </div>
            <div class="row mt-5 w-100 m-0 p-0">
                @foreach ($mostPopulars as $p)
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3 col-xxl-2 p-0">
                        <a href="{{ route('user.product.show', $p->slug) }}">
                            <div class="productBox @if ($p->isExportable) isExportableBox @endif">
                                @if ($p->isExportable)
                                    <span class="isExportable">
                                        <span class="isExportableAbsolute">
                                            <span class="isExportableRelative">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                                    viewBox="0 0 80 80" fill="none">
                                                    <g filter="url(#filter0_d_172_6)">
                                                        <path
                                                            d="M40 18L43.7082 26.5873L51.7557 21.8197L49.7082 30.9466L59.0211 31.8197L52 38L59.0211 44.1803L49.7082 45.0534L51.7557 54.1803L43.7082 49.4127L40 58L36.2918 49.4127L28.2443 54.1803L30.2918 45.0534L20.9789 44.1803L28 38L20.9789 31.8197L30.2918 30.9466L28.2443 21.8197L36.2918 26.5873L40 18Z"
                                                            fill="url(#paint0_radial_172_6)"
                                                            shape-rendering="crispEdges" />
                                                        <path
                                                            d="M43.2492 26.7855L43.9631 27.0175L51.0144 22.84L49.2203 30.8371L49.6615 31.4444L57.8216 32.2094L51.6696 37.6247V38.3753L57.8216 43.7906L49.6615 44.5556L49.2203 45.1629L51.0144 53.16L43.9631 48.9825L43.2492 49.2145L40 56.7388L36.7508 49.2145L36.0369 48.9825L28.9856 53.16L30.7797 45.1629L30.3385 44.5556L22.1784 43.7906L28.3304 38.3753V37.6247L22.1784 32.2094L30.3385 31.4444L30.7797 30.8371L28.9856 22.84L36.0369 27.0175L36.7508 26.7855L40 19.2612L43.2492 26.7855Z"
                                                            stroke="url(#paint1_linear_172_6)" stroke-linejoin="bevel"
                                                            shape-rendering="crispEdges" />
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_d_172_6" x="0.979004" y="0"
                                                            width="78.042" height="80" filterUnits="userSpaceOnUse"
                                                            color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                result="hardAlpha" />
                                                            <feOffset dy="2" />
                                                            <feGaussianBlur stdDeviation="10" />
                                                            <feComposite in2="hardAlpha" operator="out" />
                                                            <feColorMatrix type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
                                                            <feBlend mode="normal" in2="BackgroundImageFix"
                                                                result="effect1_dropShadow_172_6" />
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                in2="effect1_dropShadow_172_6" result="shape" />
                                                        </filter>
                                                        <radialGradient id="paint0_radial_172_6" cx="0"
                                                            cy="0" r="1" gradientUnits="userSpaceOnUse"
                                                            gradientTransform="translate(40 38) rotate(90) scale(20)">
                                                            <stop stop-color="#FAFF00" stop-opacity="0.76" />
                                                            <stop offset="1" stop-color="#FF7502" />
                                                        </radialGradient>
                                                        <linearGradient id="paint1_linear_172_6" x1="40"
                                                            y1="19.1429" x2="40" y2="37.4286"
                                                            gradientUnits="userSpaceOnUse">
                                                            <stop offset="0.204757" stop-color="#FAFF00"
                                                                stop-opacity="0.64" />
                                                            <stop offset="1" stop-color="#FF7502"
                                                                stop-opacity="0.37" />
                                                        </linearGradient>
                                                    </defs>
                                                </svg>
                                                <span class="isExportableText">صادراتی</span>
                                            </span>
                                        </span>
                                    </span>
                                @endif
                                <div class="productBoxLocation">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23"
                                        viewBox="0 0 26 23" fill="none">
                                        <g clip-path="url(#clip0_56_31)">
                                            <path
                                                d="M13.8645 13.5417C15.2557 11.8012 18.4237 7.57812 18.4237 5.20833C18.4237 2.33073 16.0965 0 13.2231 0C10.3497 0 8.02246 2.33073 8.02246 5.20833C8.02246 7.57812 11.1905 11.8012 12.5817 13.5417C12.9154 13.9583 13.5351 13.9583 13.8645 13.5417ZM13.2231 3.125C13.6829 3.125 14.1238 3.30791 14.4489 3.6335C14.774 3.95908 14.9566 4.40067 14.9566 4.86111C14.9566 5.32156 14.774 5.76314 14.4489 6.08873C14.1238 6.41431 13.6829 6.59722 13.2231 6.59722C12.7633 6.59722 12.3224 6.41431 11.9973 6.08873C11.6722 5.76314 11.4896 5.32156 11.4896 4.86111C11.4896 4.40067 11.6722 3.95908 11.9973 3.6335C12.3224 3.30791 12.7633 3.125 13.2231 3.125Z"
                                                fill="#FD7E14" />
                                            <path opacity="0.4"
                                                d="M18.7706 21.8316V8.69792C18.9223 8.39844 19.061 8.09896 19.1866 7.80382C19.2083 7.75174 19.23 7.69531 19.2516 7.64323L24.2789 5.62934C24.9637 5.3559 25.7048 5.85938 25.7048 6.59722V18.3507C25.7048 18.776 25.4447 19.158 25.0504 19.3186L18.7706 21.8316ZM1.39611 8.12934L6.70943 6.0026C6.81345 6.61458 7.02147 7.2309 7.26417 7.80382C7.38985 8.09896 7.52853 8.39844 7.68022 8.69792V19.6094L2.16754 21.8186C1.48279 22.092 0.741699 21.5885 0.741699 20.8507V9.09722C0.741699 8.67188 1.00173 8.28993 1.39611 8.12934ZM17.3837 11.0677V21.888L9.06272 19.5052V11.0677C9.95117 12.4262 10.8959 13.6545 11.4984 14.4097C12.3868 15.5208 14.0597 15.5208 14.9481 14.4097C15.5505 13.6545 16.4953 12.4262 17.3837 11.0677Z"
                                                fill="#FD7E14" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_56_31">
                                                <rect width="24.9631" height="22.2222" fill="white"
                                                    transform="translate(0.741699)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span class="productBoxLocationCuty">{{ $p->city ? $p->city->name : null }}</span>
                                </div>
                                <div class="productBoxBody">
                                    @if ($p->image)
                                        <img data-src="{{ asset($p->image) }}" alt="">
                                    @else
                                        <img data-src="{{ asset('image/productISYBox.png') }}" alt="">
                                    @endif
                                </div>
                                <div class="productBoxFooter">
                                    <p class="productName overflow-hidden" style="height: 20px">{{ $p->name }}
                                    </p>
                                    @if ($p->category)
                                        <span class="productCategory overflow-hidden">{{ $p->category->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row w-100 p-0 m-0">
                <div class="col-12 col-md-6 p-0 mt-2">
                    <div>
                        <img data-src="{{ asset('image/Rectangle 49.png') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-12 col-md-6 p-0 mt-2">
                    <div>
                        <img data-src="{{ asset('image/Rectangle 492.png') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
            <div class="sectionTitle mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                    fill="none">
                    <g clip-path="url(#clip0_143_359)">
                        <path
                            d="M8.01172 2.86328C7.91016 2.64063 7.6875 2.5 7.44531 2.5C7.20313 2.5 6.98047 2.64063 6.87891 2.86328L4.82031 7.32031L0.363281 9.375C0.140625 9.47656 0 9.69922 0 9.94531C0 10.1914 0.140625 10.4102 0.363281 10.5117L4.82031 12.5703L6.875 17.0234C6.97656 17.2461 7.19922 17.3867 7.44141 17.3867C7.68359 17.3867 7.90625 17.2461 8.00781 17.0234L10.0664 12.5664L14.5234 10.5078C14.7461 10.4063 14.8867 10.1836 14.8867 9.94141C14.8867 9.69922 14.7461 9.47656 14.5234 9.375L10.0703 7.32031L8.01172 2.86328Z"
                            fill="#0A0E29" />
                        <path opacity="0.4"
                            d="M12.793 3.32812L15 2.5L15.8281 0.292969C15.8945 0.117188 16.0625 0 16.25 0C16.4375 0 16.6055 0.117188 16.6719 0.292969L17.5 2.5L19.707 3.32812C19.8828 3.39453 20 3.5625 20 3.75C20 3.9375 19.8828 4.10547 19.707 4.17188L17.5 5L16.6719 7.20703C16.6055 7.38281 16.4375 7.5 16.25 7.5C16.0625 7.5 15.8945 7.38281 15.8281 7.20703L15 5L12.793 4.17188C12.6172 4.10547 12.5 3.9375 12.5 3.75C12.5 3.5625 12.6172 3.39453 12.793 3.32812ZM12.793 15.8281L15 15L15.8281 12.793C15.8945 12.6172 16.0625 12.5 16.25 12.5C16.4375 12.5 16.6055 12.6172 16.6719 12.793L17.5 15L19.707 15.8281C19.8828 15.8945 20 16.0625 20 16.25C20 16.4375 19.8828 16.6055 19.707 16.6719L17.5 17.5L16.6719 19.707C16.6055 19.8828 16.4375 20 16.25 20C16.0625 20 15.8945 19.8828 15.8281 19.707L15 17.5L12.793 16.6719C12.6172 16.6055 12.5 16.4375 12.5 16.25C12.5 16.0625 12.6172 15.8945 12.793 15.8281Z"
                            fill="#FD7E14" />
                    </g>
                    <defs>
                        <clipPath id="clip0_143_359">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <span class="sectionTitleHeader">
                    تازه‌ها
                </span>
            </div>
            <div class="row mt-5 w-100 m-0 p-0">
                @foreach ($newProducts as $p)
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3 col-xxl-2 p-0">
                        <a href="{{ route('user.product.show', $p->slug) }}">
                            <div class="productBox @if ($p->isExportable) isExportableBox @endif">
                                @if ($p->isExportable)
                                    <span class="isExportable">
                                        <span class="isExportableAbsolute">
                                            <span class="isExportableRelative">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                                    viewBox="0 0 80 80" fill="none">
                                                    <g filter="url(#filter0_d_172_6)">
                                                        <path
                                                            d="M40 18L43.7082 26.5873L51.7557 21.8197L49.7082 30.9466L59.0211 31.8197L52 38L59.0211 44.1803L49.7082 45.0534L51.7557 54.1803L43.7082 49.4127L40 58L36.2918 49.4127L28.2443 54.1803L30.2918 45.0534L20.9789 44.1803L28 38L20.9789 31.8197L30.2918 30.9466L28.2443 21.8197L36.2918 26.5873L40 18Z"
                                                            fill="url(#paint0_radial_172_6)"
                                                            shape-rendering="crispEdges" />
                                                        <path
                                                            d="M43.2492 26.7855L43.9631 27.0175L51.0144 22.84L49.2203 30.8371L49.6615 31.4444L57.8216 32.2094L51.6696 37.6247V38.3753L57.8216 43.7906L49.6615 44.5556L49.2203 45.1629L51.0144 53.16L43.9631 48.9825L43.2492 49.2145L40 56.7388L36.7508 49.2145L36.0369 48.9825L28.9856 53.16L30.7797 45.1629L30.3385 44.5556L22.1784 43.7906L28.3304 38.3753V37.6247L22.1784 32.2094L30.3385 31.4444L30.7797 30.8371L28.9856 22.84L36.0369 27.0175L36.7508 26.7855L40 19.2612L43.2492 26.7855Z"
                                                            stroke="url(#paint1_linear_172_6)" stroke-linejoin="bevel"
                                                            shape-rendering="crispEdges" />
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_d_172_6" x="0.979004" y="0"
                                                            width="78.042" height="80" filterUnits="userSpaceOnUse"
                                                            color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                result="hardAlpha" />
                                                            <feOffset dy="2" />
                                                            <feGaussianBlur stdDeviation="10" />
                                                            <feComposite in2="hardAlpha" operator="out" />
                                                            <feColorMatrix type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
                                                            <feBlend mode="normal" in2="BackgroundImageFix"
                                                                result="effect1_dropShadow_172_6" />
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                in2="effect1_dropShadow_172_6" result="shape" />
                                                        </filter>
                                                        <radialGradient id="paint0_radial_172_6" cx="0"
                                                            cy="0" r="1" gradientUnits="userSpaceOnUse"
                                                            gradientTransform="translate(40 38) rotate(90) scale(20)">
                                                            <stop stop-color="#FAFF00" stop-opacity="0.76" />
                                                            <stop offset="1" stop-color="#FF7502" />
                                                        </radialGradient>
                                                        <linearGradient id="paint1_linear_172_6" x1="40"
                                                            y1="19.1429" x2="40" y2="37.4286"
                                                            gradientUnits="userSpaceOnUse">
                                                            <stop offset="0.204757" stop-color="#FAFF00"
                                                                stop-opacity="0.64" />
                                                            <stop offset="1" stop-color="#FF7502"
                                                                stop-opacity="0.37" />
                                                        </linearGradient>
                                                    </defs>
                                                </svg>
                                                <span class="isExportableText">صادراتی</span>
                                            </span>
                                        </span>
                                    </span>
                                @endif
                                <div class="productBoxLocation">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23"
                                        viewBox="0 0 26 23" fill="none">
                                        <g clip-path="url(#clip0_56_31)">
                                            <path
                                                d="M13.8645 13.5417C15.2557 11.8012 18.4237 7.57812 18.4237 5.20833C18.4237 2.33073 16.0965 0 13.2231 0C10.3497 0 8.02246 2.33073 8.02246 5.20833C8.02246 7.57812 11.1905 11.8012 12.5817 13.5417C12.9154 13.9583 13.5351 13.9583 13.8645 13.5417ZM13.2231 3.125C13.6829 3.125 14.1238 3.30791 14.4489 3.6335C14.774 3.95908 14.9566 4.40067 14.9566 4.86111C14.9566 5.32156 14.774 5.76314 14.4489 6.08873C14.1238 6.41431 13.6829 6.59722 13.2231 6.59722C12.7633 6.59722 12.3224 6.41431 11.9973 6.08873C11.6722 5.76314 11.4896 5.32156 11.4896 4.86111C11.4896 4.40067 11.6722 3.95908 11.9973 3.6335C12.3224 3.30791 12.7633 3.125 13.2231 3.125Z"
                                                fill="#FD7E14" />
                                            <path opacity="0.4"
                                                d="M18.7706 21.8316V8.69792C18.9223 8.39844 19.061 8.09896 19.1866 7.80382C19.2083 7.75174 19.23 7.69531 19.2516 7.64323L24.2789 5.62934C24.9637 5.3559 25.7048 5.85938 25.7048 6.59722V18.3507C25.7048 18.776 25.4447 19.158 25.0504 19.3186L18.7706 21.8316ZM1.39611 8.12934L6.70943 6.0026C6.81345 6.61458 7.02147 7.2309 7.26417 7.80382C7.38985 8.09896 7.52853 8.39844 7.68022 8.69792V19.6094L2.16754 21.8186C1.48279 22.092 0.741699 21.5885 0.741699 20.8507V9.09722C0.741699 8.67188 1.00173 8.28993 1.39611 8.12934ZM17.3837 11.0677V21.888L9.06272 19.5052V11.0677C9.95117 12.4262 10.8959 13.6545 11.4984 14.4097C12.3868 15.5208 14.0597 15.5208 14.9481 14.4097C15.5505 13.6545 16.4953 12.4262 17.3837 11.0677Z"
                                                fill="#FD7E14" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_56_31">
                                                <rect width="24.9631" height="22.2222" fill="white"
                                                    transform="translate(0.741699)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span class="productBoxLocationCuty">{{ $p->city ? $p->city->name : null }}</span>
                                </div>
                                <div class="productBoxBody">
                                    @if ($p->image)
                                        <img data-src="{{ asset($p->image) }}" alt="">
                                    @else
                                        <img data-src="{{ asset('image/productISYBox.png') }}" alt="">
                                    @endif
                                </div>
                                <div class="productBoxFooter">
                                    <p class="productName overflow-hidden" style="height: 20px">{{ $p->name }}
                                    </p>
                                    @if ($p->category)
                                        <span class="productCategory overflow-hidden">{{ $p->category->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </main>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var iparkOptions = $('#ipark_id option[data-province]');
            $('#province_id').change(function() {
                iparkOptions.addClass('d-none');
                province = $('#province_id').val();
                $('#ipark_id option[data-province=' + province + ']').removeClass('d-none');
            });
        });
    </script>
    @if (isset($_GET['province_id']) && $_GET['province_id'])
        <script>
            $(document).ready(function() {
                province = $('#province_id').val();
                $('#ipark_id option[data-province]:not([data-province=' + province + '])').addClass('d-none');
            });
        </script>
    @endif
    <script>
        w = screen.width;
        if (w <= 1270) {
            $('.categoryWrapper ').addClass('owl-carousel');
            $('.categoryWrapper ').addClass('owl-theme');
            $('.owl-carousel').owlCarousel({
                rtl: true,
                loop: true,
                margin: 0,
                nav: true,
                center: true,
                items: 3,
                animateOut: true,
                margin: 10,
            })
            $('.categoryWrapper div').removeClass('col-2');
            $('.categoryWrapper').removeClass('row');
            $('.productsMain .container-fluid').addClass('p-0');
            $('span[aria-label = Next]').html(
                '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">' +
                '<path d="M0.229492 11.9482C-0.0732422 12.251 -0.0732422 12.749 0.229492 13.0518L7.26074 20.083C7.56348 20.3857 8.06152 20.3857 8.36426 20.083C8.66699 19.7803 8.66699 19.2822 8.36426 18.9795L2.66602 13.2812H24.2188C24.6484 13.2812 25 12.9297 25 12.5C25 12.0703 24.6484 11.7188 24.2188 11.7188H2.66602L8.36426 6.02051C8.66699 5.71777 8.66699 5.21973 8.36426 4.91699C8.06152 4.61426 7.56348 4.61426 7.26074 4.91699L0.229492 11.9482Z" fill="#0A0E29" fill-opacity="0.7"/>' +
                '</svg>');
            $('span[aria-label = Previous]').html(
                '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">' +
                '<g clip-path="url(#clip0_387_214)">' +
                '<path d="M24.7705 13.0518C25.0732 12.749 25.0732 12.251 24.7705 11.9482L17.7393 4.91699C17.4365 4.61426 16.9385 4.61426 16.6357 4.91699C16.333 5.21973 16.333 5.71777 16.6357 6.02051L22.334 11.7187L0.781251 11.7187C0.351563 11.7187 7.20341e-07 12.0703 6.82777e-07 12.5C6.45213e-07 12.9297 0.351563 13.2812 0.781251 13.2812L22.334 13.2812L16.6357 18.9795C16.333 19.2822 16.333 19.7803 16.6357 20.083C16.9385 20.3857 17.4365 20.3857 17.7393 20.083L24.7705 13.0518Z" fill="#0A0E29" fill-opacity="0.7"/>' +
                '</g>' +
                '<defs>' +
                '<clipPath id="clip0_387_214">' +
                '<rect width="25" height="25" fill="white" transform="translate(25 25) rotate(-180)"/>' +
                '</clipPath>' +
                '</defs>' +
                '</svg>');
        }
    </script>
@endsection
