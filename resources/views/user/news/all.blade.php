@extends('user.layout.master')
@section('head')
    <title>اخبار</title>
    <style>
        .mainHeader::before {
            background: url('{{ asset('image/newsSearchBg.jpg') }}');
        }

        .productsMain .mainHeader .searchForm .filters .filterSelect {
            display: inline-block;
            width: unset;
            width: 123px;
            height: 30px;
            font-size: 12px;
            border: 1px solid #0A0E29;
        }
        .newsBox{
            position: relative;
            height: 250px;
            border-radius: 11px;
            cursor: pointer;
        }
        .newsBox img{
            height: 250px;
            width: 100%;
            border-radius: 11px;
        }
        .newsTitleWrapper{
            position: absolute;
            background: rgba(0, 0, 0, 0.45);
            height: 100px;
            top: 150;
            right: 0;
            left: 0;
            bottom: 0;
            border-radius: 11px;
            font-size: 12px;
            padding: 15px;
            text-align: center;
            color: #fff;
            line-height: 15px;
        }
        @media screen and (max-width:575px) {
            .productsMain .mainHeader .searchForm .filters .filterSelect {
                width: 23%;
                height: 20px;
                font-size: 10px;
                border-radius: 12.5px;
                background: #EBEBEB;
                box-shadow: -2px 4px 20px 0px rgba(10, 14, 41, 0.25);
                border: none;
            }
        }
    </style>
@endsection
@section('bodyStyle')
    home
@endsection
@section('content')
    <main class="productsMain mb-5">
        <div class="mainHeader">
            <h1 class="mainHeaderHeader">
                اخبار
            </h1>
            <form action="#" method="get" class="searchForm" id="searchForm">
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
                        @if (isset($_GET['search'])) value="{{ $_GET['search'] }}" @endif placeholder="جستجوی اخبار">
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
                            <option value="{{ $city->id }}" @if (isset($_GET['city_id']) && $_GET['city_id'] == $city->id) selected @endif>
                                {{ $city->name }}</option>
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

        <div class="container-fluid">
            <div class="sectionTitle mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                    fill="none">
                    <path
                        d="M0 6.25V16.875C0 17.9102 0.839844 18.75 1.875 18.75C2.91016 18.75 3.75 17.9102 3.75 16.875V3.75H2.5C1.12109 3.75 0 4.87109 0 6.25ZM15 3.75C14.6562 3.75 14.375 4.03125 14.375 4.375C14.375 4.71875 14.6562 5 15 5H16.875C17.2188 5 17.5 4.71875 17.5 4.375C17.5 4.03125 17.2188 3.75 16.875 3.75H15ZM15 7.5C14.6562 7.5 14.375 7.78125 14.375 8.125C14.375 8.46875 14.6562 8.75 15 8.75H16.875C17.2188 8.75 17.5 8.46875 17.5 8.125C17.5 7.78125 17.2188 7.5 16.875 7.5H15ZM6.875 11.25C6.53125 11.25 6.25 11.5312 6.25 11.875C6.25 12.2188 6.53125 12.5 6.875 12.5H16.875C17.2188 12.5 17.5 12.2188 17.5 11.875C17.5 11.5312 17.2188 11.25 16.875 11.25H6.875ZM6.875 15C6.53125 15 6.25 15.2812 6.25 15.625C6.25 15.9688 6.53125 16.25 6.875 16.25H16.875C17.2188 16.25 17.5 15.9688 17.5 15.625C17.5 15.2812 17.2188 15 16.875 15H6.875Z"
                        fill="#FD7E14" />
                    <path opacity="0.4"
                        d="M3.75 3.75C3.75 2.37109 4.87109 1.25 6.25 1.25H17.5C18.8789 1.25 20 2.37109 20 3.75V16.25C20 17.6289 18.8789 18.75 17.5 18.75H3.75H1.875C2.91016 18.75 3.75 17.9102 3.75 16.875V3.75ZM6.25 4.6875V7.8125C6.25 8.33203 6.66797 8.75 7.1875 8.75H11.5625C12.082 8.75 12.5 8.33203 12.5 7.8125V4.6875C12.5 4.16797 12.082 3.75 11.5625 3.75H7.1875C6.66797 3.75 6.25 4.16797 6.25 4.6875ZM14.375 4.375C14.375 4.71875 14.6562 5 15 5H16.875C17.2188 5 17.5 4.71875 17.5 4.375C17.5 4.03125 17.2188 3.75 16.875 3.75H15C14.6562 3.75 14.375 4.03125 14.375 4.375ZM14.375 8.125C14.375 8.46875 14.6562 8.75 15 8.75H16.875C17.2188 8.75 17.5 8.46875 17.5 8.125C17.5 7.78125 17.2188 7.5 16.875 7.5H15C14.6562 7.5 14.375 7.78125 14.375 8.125ZM6.25 11.875C6.25 12.2188 6.53125 12.5 6.875 12.5H16.875C17.2188 12.5 17.5 12.2188 17.5 11.875C17.5 11.5312 17.2188 11.25 16.875 11.25H6.875C6.53125 11.25 6.25 11.5312 6.25 11.875ZM6.25 15.625C6.25 15.9688 6.53125 16.25 6.875 16.25H16.875C17.2188 16.25 17.5 15.9688 17.5 15.625C17.5 15.2812 17.2188 15 16.875 15H6.875C6.53125 15 6.25 15.2812 6.25 15.625Z"
                        fill="black" />
                </svg>
                <span class="sectionTitleHeader">
                    آخرین خبرها
                </span>
            </div>
            <div class="row w-100 m-0 mt-4">
                @foreach ($news as $new)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-3 text-center">
                        <a href="{{ route('user.news.show' , $new->id) }}">
                            <div class="newsBox">
                                <img data-src="{{ asset($new->box_image_path) }}" alt="" >
                                <div class="newsTitleWrapper">
                                    <p class="newsTitle">
                                        {{ $new->title }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-2 mb-4">
            {{ $news->links() }}
        </div>
    </main>
@endsection
@section('script')
    <script src="{{ asset('plugins/lazysize/lazysizes.min.js') }}"></script>
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
@endsection
