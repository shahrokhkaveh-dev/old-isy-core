<!DOCTYPE html>
<html lang="fa">

<head>
    @include('panel.layout.head')
    @yield('head')
</head>

<body>
    <div class="loadingWrapper">
        <span class="loader"></span>
    </div>
    <div class="">
        <div class="dashboard">
            <aside>
                <div class="text-center mt-3">
                    <img src="{{ asset('icons/dashboardSidebar.png') }}" alt="">
                </div>
                @include('panel.layout.header')
                <div class="sidebarToggle" id="sidebarToggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="21" viewBox="0 0 14 21"
                        fill="none">
                        <g clip-path="url(#clip0_250_72)">
                            <path opacity="0.4"
                                d="M12.8828 9.36719C13.3711 9.85547 13.3711 10.6484 12.8828 11.1367L5.38281 18.6367C4.89453 19.125 4.10156 19.125 3.61328 18.6367C3.125 18.1484 3.125 17.3555 3.61328 16.8672L10.2305 10.25L3.61719 3.63281C3.12891 3.14453 3.12891 2.35156 3.61719 1.86328C4.10547 1.375 4.89844 1.375 5.38672 1.86328L12.8867 9.36328L12.8828 9.36719Z"
                                fill="black" />
                        </g>
                        <defs>
                            <clipPath id="clip0_250_72">
                                <rect width="12.5" height="20" fill="white" transform="translate(0.75 0.25)" />
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </aside>
            <main>
                <div class="mobileNav d-lg-none danger">
                    <img src="{{ asset('icons/dashboardSidebar.png') }}" alt="">
                    <div
                        style="
                    display: flex;
                    align-content: center;
                    flex-direction: row;
                    flex-wrap: nowrap;
                    justify-content: center;
                    align-items: center;
                ">
                        <a href="{{ url('/') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960"
                                width="40">
                                <path
                                    d="M226.666-186.666h140.001v-246.667h226.666v246.667h140.001v-380.001L480-756.667l-253.334 190v380.001ZM160-120v-480l320-240 320 240v480H526.667v-246.667h-93.334V-120H160Zm320-352Z" />
                            </svg></a>
                        <div id="nav-toggle">
                            <div>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid d-none d-md-block">
                    <div class="pishkhan-header d-flex justify-content-between mt-5">
                        <div>
                            <div class="border-img-pishkhan position-relative"></div>
                            <div class="border-wellcome d-flex position-relative">
                                @if (\Illuminate\Support\Facades\Auth::user()->avatar)
                                    <img class="img-wellcome"
                                        src="{{ asset(\Illuminate\Support\Facades\Auth::user()->avatar) }}"
                                        alt="">
                                @endif
                                <p class="wellcome-text">کاربر
                                    <span>{{ \Illuminate\Support\Facades\Auth::user()->first_name }}</span>، خوش آمدید.
                                </p>
                            </div>
                        </div>
                        <div>
                            <div class="time d-flex justify-content-between pt-2 px-3">
                                <p id="calendarDate">یکشنبه 15 بهمن 1402</p>
                                <p id="clock">14:57</p>

                            </div>
                        </div>


                    </div>
                </div>
                @yield('content')
            </main>

        </div>
    </div>
</body>
@include('panel.layout.script')
@yield('script')

</html>
