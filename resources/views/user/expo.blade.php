@extends('user.layout.master')
@section('head')
    <title>نمایشگاه</title>
    <style>
        .mainHeader::before {
            background: url('{{ asset('image/products.jpg') }}');
        }

        .productsMain .mainHeader .searchForm .filters .filterSelect {
            display: inline-block;
            width: unset;
            width: 150px;
            height: 40px;
            font-size: 14px;
            /* border: 1px solid #032049; */
            background: #ffffff;
            color: #000000;
            font-weight: bold;
            margin-left: 15px;
            border-radius: 6px;
        }

        select {

            background-color: white !important;
            border-radius: 4px !important;
            display: inline-block !important;
            font: inherit !important;
            line-height: 1.5em !important;
            padding-right: 10px !important;

            margin: 0 !important;
            -webkit-box-sizing: border-box !important;
            -moz-box-sizing: border-box !important;
            box-sizing: border-box !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
        }

        select {
            background-image:
                linear-gradient(45deg, transparent 50%, gray 50%),
                linear-gradient(135deg, gray 50%, transparent 50%),
                linear-gradient(to right, #ccc, #ccc) !important;
            background-position:
                8px 17px,
                13px 17px,
                22px 7px !important;
            background-size:
                5px 5px,
                5px 5px,
                1px 1.5em !important;
            background-repeat: no-repeat !important;
        }

        .filters p {
            color: #fff;
            margin: 0;
            margin-bottom: 8px;
        }

        @media screen and (max-width: 1288px) {
            .productsMain .mainHeader .searchForm {
                margin-top: 0;
            }
        }

        @media screen and (max-width: 1199px) {
            .productsMain .mainHeader .searchForm .filters {
                padding-right: 0;
                text-align: center;
            }

            .productsMain .mainHeader .searchForm .filters p {
                text-align: right;
                color: black;
                padding-right: 19.5%;
            }
        }

        @media screen and (max-width: 991px) {
            .productsMain .mainHeader .searchForm .filters {
                border-radius: 0;
                box-shadow: none;
            }

            .productsMain .mainHeader .searchForm>div:nth-child(1) {
                box-shadow: none;
            }

            .productsMain .mainHeader .searchForm .filters p {
                margin-right: 0;
            }
        }

        @media screen and (max-width: 1270px) {
            .sectionTitle {
                text-align: right;
            }
        }

        @media screen and (max-width: 767px) {
            .productsMain .mainHeader .searchForm .filters .filterSelect {
                font-size: 12px;
                width: 133px;
                height: 35px;
            }

            .productsMain .mainHeader .searchForm .filters p {
                padding-right: 0;
            }
        }

        @media screen and (max-width: 575px) {
            .bi-person-circle+span {
                display: none;
            }

            button.dropdown-toggle {
                margin-top: -17px !important;
                margin-left: -20px !important;
            }

            .productsMain .mainHeader .searchForm .filters .filterSelect {
                font-size: 12px !important;
                width: 69px;
                height: 27px;
            }

            .productsMain .mainHeader .searchForm .filters .filterSelect {
                padding: 0 !important;
                padding-right: 0px;
                text-align: right;
                padding-right: 5px !important;
            }

            .productsMain .mainHeader .searchForm .filters p{
                font-size: 13px
            }
        }
    </style>
@endsection
@section('bodyStyle')
    home
@endsection
@section('content')
    <main class="productsMain">
        <div class="mainHeader">
            <h1 class="mainHeaderHeader">
                نمایشگاه مجازی توانمندی‌های تولیدی و خدماتی صنعت جمهوری اسلامی ایران
            </h1>
            <form action="{{ route('user.expo.index') }}" method="get" class="searchForm">

                <div class="filters">
                    <p>فیلتر بر اساس</p>
                    <select class="filterSelect" name="category_id" id="category_id">
                        <option value="">دسته بندی</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (isset($_GET['category_id']) && $_GET['category_id'] == $category->id) selected @endif>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select class="filterSelect" name="province_id" id="province_id">
                        <option value="">استان</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" @if (isset($_GET['province_id']) && $_GET['province_id'] == $province->id) selected @endif>
                                {{ $province->name }}</option>
                        @endforeach
                    </select>
                    <select class="filterSelect" name="city_id" id="city_id">
                        <option value="">شهر</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @if (isset($_GET['city_id']) && $_GET['city_id'] == $city->id) selected @endif>
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                    <select class="filterSelect" name="ipark_id" id="ipark_id">
                        <option value="">شهرک صنعتی</option>
                        @foreach ($iparks as $ipark)
                            <option value="{{ $ipark->id }}" data-province="{{ $ipark->province_id }}"
                                @if (isset($_GET['ipark_id']) && $_GET['ipark_id'] == $ipark->id) selected @endif>
                                {{ $ipark->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="container">
            <div class="sectionTitle mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none">
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
                    توامندی های ایران
                </span>
            </div>
            <div class="row mt-4 w-100">
                @foreach ($products as $p)
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
                                                            fill="url(#paint0_radial_172_6)" shape-rendering="crispEdges" />
                                                        <path
                                                            d="M43.2492 26.7855L43.9631 27.0175L51.0144 22.84L49.2203 30.8371L49.6615 31.4444L57.8216 32.2094L51.6696 37.6247V38.3753L57.8216 43.7906L49.6615 44.5556L49.2203 45.1629L51.0144 53.16L43.9631 48.9825L43.2492 49.2145L40 56.7388L36.7508 49.2145L36.0369 48.9825L28.9856 53.16L30.7797 45.1629L30.3385 44.5556L22.1784 43.7906L28.3304 38.3753V37.6247L22.1784 32.2094L30.3385 31.4444L30.7797 30.8371L28.9856 22.84L36.0369 27.0175L36.7508 26.7855L40 19.2612L43.2492 26.7855Z"
                                                            stroke="url(#paint1_linear_172_6)" stroke-linejoin="bevel"
                                                            shape-rendering="crispEdges" />
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_d_172_6" x="0.979004" y="0" width="78.042"
                                                            height="80" filterUnits="userSpaceOnUse"
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
                                    <span class="productBoxLocationCuty">{{ $p->city->name }}</span>
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
        <div class="mt-5 mb-5 container">
            {{ $products->links() }}
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

    <script>
        $('.searchForm select').change(function() {
            $('.searchForm').submit();
        })
    </script>
@endsection
