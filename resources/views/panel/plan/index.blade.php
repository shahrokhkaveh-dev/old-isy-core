@extends('panel.layout.master')
@section('head')
    <title>خرید اشتراک</title>
@endsection
@section('content')
    <header class="d-flex justify-content-between">
        <h3 class="text-start mt-5">پلن‌های اشتراک</h3>
    </header>
    <div class="border-piskhan mt-3 text-center pt-5">
        @if (auth()->user()->brand->vip_expired_time)
            @if (\Carbon\Carbon::now() > auth()->user()->brand->vip_expired_time)
                <div class="border-danger mx-auto">
                    <p class="pt-3">اشتراک شما به اتمام رسیده است. لطفا جهت تمدید اقدام نمایید.</p>
                </div>
            @elseif(\Carbon\Carbon::now()->diffInDays(auth()->user()->brand->vip_expired_time) <= 5)
                <div class="border-warning mx-auto">
                    <p class="pt-3">اشتراک شما در تاریخ
                        {{ jdate(auth()->user()->brand->vip_expired_time)->format('d-m-Y') }} به تمام می رسد.</p>
                </div>
            @else
                <div class="border-success mx-auto">
                    <p class="pt-3">اشتراک شما تا تاریخ
                        {{ jdate(auth()->user()->brand->vip_expired_time)->format('d-m-Y') }} فعال است.</p>
                </div>
            @endif
        @endif


        <div class="d-flex mt-5 justify-content-center">
            @foreach ($plans as $plan)
                <div class="card-subscription position-relative mx-3">
                    <div class="d-flex justify-content-center mt-4">
                        {!! $plan->icon !!}

                        <h5 class="pe-3 ">{{ $plan->name }}</h5>

                    </div>
                    <hr class="mx-3">
                    <div>
                        <div class="d-flex justify-content-center mt-4">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.457 8.04688H13.457C13.3711 8.04688 13.3008 8.11719 13.3008 8.20312V9.14062C13.3008 9.22656 13.3711 9.29688 13.457 9.29688H18.457C18.543 9.29688 18.6133 9.22656 18.6133 9.14062V8.20312C18.6133 8.11719 18.543 8.04688 18.457 8.04688ZM15.8398 10.7031H13.457C13.3711 10.7031 13.3008 10.7734 13.3008 10.8594V11.7969C13.3008 11.8828 13.3711 11.9531 13.457 11.9531H15.8398C15.9258 11.9531 15.9961 11.8828 15.9961 11.7969V10.8594C15.9961 10.7734 15.9258 10.7031 15.8398 10.7031ZM9.32227 6.29883H8.47656C8.35547 6.29883 8.25781 6.39648 8.25781 6.51758V11.3613C8.25781 11.4316 8.29102 11.4961 8.34766 11.5371L11.2559 13.6582C11.3535 13.7285 11.4902 13.709 11.5605 13.6113L12.0625 12.9258V12.9238C12.1328 12.8262 12.1113 12.6895 12.0137 12.6191L9.53906 10.8301V6.51758C9.54102 6.39648 9.44141 6.29883 9.32227 6.29883Z"
                                    fill="{{ $plan->color }}" />
                                <path
                                    d="M15.7188 13.1621H14.5899C14.4805 13.1621 14.377 13.2188 14.3184 13.3125C14.0703 13.7051 13.7813 14.0684 13.4492 14.4004C12.877 14.9727 12.211 15.4219 11.4707 15.7344C10.7031 16.0586 9.88869 16.2227 9.04884 16.2227C8.20704 16.2227 7.39259 16.0586 6.62697 15.7344C5.88673 15.4219 5.22072 14.9727 4.64845 14.4004C4.07619 13.8281 3.62697 13.1621 3.31447 12.4219C2.99025 11.6562 2.82619 10.8418 2.82619 10C2.82619 9.1582 2.99025 8.3457 3.31447 7.57813C3.62697 6.83789 4.07619 6.17188 4.64845 5.59961C5.22072 5.02734 5.88673 4.57813 6.62697 4.26563C7.39259 3.94141 8.209 3.77734 9.04884 3.77734C9.89064 3.77734 10.7051 3.94141 11.4707 4.26563C12.211 4.57813 12.877 5.02734 13.4492 5.59961C13.7813 5.93164 14.0703 6.29492 14.3184 6.6875C14.377 6.78125 14.4805 6.83789 14.5899 6.83789H15.7188C15.8535 6.83789 15.9395 6.69727 15.8789 6.57813C14.6055 4.04492 12.0235 2.39844 9.14064 2.36524C4.91993 2.3125 1.41408 5.76758 1.40626 9.98438C1.39845 14.209 4.82228 17.6367 9.04689 17.6367C11.9668 17.6367 14.5918 15.9844 15.8789 13.4219C15.9395 13.3027 15.8516 13.1621 15.7188 13.1621Z"
                                    fill="{{ $plan->color }}" />
                            </svg>

                            <p class="pe-3">اشتراک {{ $plan->period }} ماهه</p>
                            <br>

                        </div>
                        <form action="{{ route('panel.plan.buy') }}" method="post">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <a href="javascript:void(0);" class="btn bg-white text-dark mt-3"
                                style="border: 2px solid {{ $plan->color }};">{{ $plan->showPrice }} میلیون تومان</a>
                            <button class="order-success d-flex justify-content-center"
                                style="background: {{ $plan->color }} ; cursor:pointer;border: none;">
                                <svg class="mt-3" width="11" height="11" viewBox="0 0 11 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.1436 0.209178C9.95232 0.102722 9.7419 0.0350225 9.5244 0.0099513C9.3069 -0.0151199 9.08659 0.00292874 8.87608 0.0630654C8.66556 0.123202 8.46896 0.224247 8.29753 0.360422C8.12609 0.496597 7.98318 0.66523 7.87696 0.856678L4.7828 6.42501L3.01196 4.65418C2.85822 4.49499 2.67431 4.36802 2.47097 4.28068C2.26763 4.19333 2.04893 4.14735 1.82763 4.14543C1.60633 4.1435 1.38687 4.18567 1.18204 4.26948C0.977214 4.35328 0.791128 4.47703 0.63464 4.63352C0.478152 4.79001 0.354397 4.97609 0.270595 5.18092C0.186794 5.38575 0.144624 5.60521 0.146547 5.82651C0.14847 6.04781 0.194447 6.26651 0.281796 6.46985C0.369144 6.67319 0.496114 6.8571 0.655298 7.01085L3.98863 10.3442C4.30363 10.66 4.72863 10.8333 5.16696 10.8333L5.3978 10.8167C5.65326 10.7809 5.89693 10.6864 6.10965 10.5405C6.32236 10.3946 6.49831 10.2013 6.62363 9.97585L10.7903 2.47584C10.8967 2.28455 10.9643 2.07418 10.9894 1.85674C11.0145 1.63931 10.9965 1.41906 10.9364 1.20858C10.8764 0.998094 10.7755 0.801502 10.6394 0.630024C10.5034 0.458547 10.3349 0.315543 10.1436 0.209178Z"
                                        fill="white" />
                                </svg>
                                <p class="text-light mt-2 pe-2">ثبت سفارش</p>
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach
        </div>
        <img class="py-5" src="img/vv.png" alt="">
    </div>
    {{-- <section class="content table-responsive">
        @if (auth()->user()->brand && time() < auth()->user()->brand->vip_expired_time)
            <div class="alert alert-warning" role="alert">
                شما دارای اشتراک ویژه تا تاریخ : {{ jdate(auth()->user()->brand->vip_expired_time)->format('d-m-Y') }}
                هستید
            </div>
        @endif

    </section> --}}
@endsection
@section('script')
@endsection
