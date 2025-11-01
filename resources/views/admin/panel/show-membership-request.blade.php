@extends('admin.panel.layout.master')
@section('content')
    <div class="row m-0">
        <div class="col-12 col-md-7">
            <form class="form-signup" action="{{route('admin.approve.membership', ['id' => encrypt($brand->id)])}}"
                  method="get" id="form">
                <label for="name-company" class="mt-5">نام شرکت</label>
                <input id="name-company" type="text" class="form-control disabled" disabled value="{{ $brand->name }}">
                <div class="d-flex justify-content-between">
                    <div>
                        <label>شماره ثبت</label>
                        <input type="text" class="form-control disabled" disabled value="{{ $brand->register_code }}">
                    </div>
                    <div>
                        <label>شناسه ملی</label>
                        <input type="text" class="form-control disabled" disabled
                               value="{{ $brand->nationality_code }}">
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        <label>استان</label>
                        <input type="text" class="form-control disabled" disabled value="{{ $brand->province->name }}">
                    </div>
                    <div>
                        <label>شهر</label>
                        <input type="text" class="form-control disabled" disabled value="{{ $brand->city->name }}">
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        <label>شهرک صنعتی</label>
                        <input type="text" id="ipark_id" class="form-control disabled" disabled
                               value="{{ $brand->ipark_id }}">
                    </div>
                    <div>
                        <label>حوزه فعالیت</label>
                        <input type="text" class="form-control disabled" disabled value="{{ $brand->category->name }}">
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        <label>تلفن</label>
                        <input type="text" class="form-control disabled" disabled value="{{ $brand->phone_number }}">
                    </div>
                    <div>
                        <label>کدپستی</label>
                        <input type="text" class="form-control disabled" disabled value="{{ $brand->post_code }}">
                    </div>
                </div>
                <label for="">نشانی</label>
                <textarea class="form-control disabled" disabled id="" cols="30" rows="10"
                          maxlength="120">{{ $brand->address }}</textarea>

                <label>اسکن مدارک</label>
                <div class="bg-scan">
                    <div id="madarek-gallery" class="carousel">
                        @php
                            $brandDocument = $brand->document;
                        @endphp
                        @if($brandDocument)
                            <a data-lg-size="1600-1200" data-src="{{ asset($brandDocument->newspaper) }}"
                               target="_blank" class="lg-item">
                                @switch(pathinfo(asset($brandDocument->newspaper), PATHINFO_EXTENSION))
                                    @case('pdf')
                                        <img src="{{ asset('admin-assets/panel-assets/img/pdfIcon.svg') }}"/>
                                        @break
                                    @default
                                        <img src="{{ asset($brandDocument->newspaper) }}"/>

                                @endswitch
                                <p class="">روزنامه رسمی</p>
                            </a>
                            <a data-lg-size="1600-1200" data-src="{{ asset($brandDocument->lastchange) }}"
                               target="_blank" class="lg-item">
                                @switch(pathinfo(asset($brandDocument->lastchange), PATHINFO_EXTENSION))
                                    @case('pdf')
                                        <img src="{{ asset('admin-assets/panel-assets/img/pdfIcon.svg') }}"/>
                                        @break
                                    @default
                                        <img src="{{ asset($brandDocument->lastchange) }}"/>

                                @endswitch
                                <p>ثبت تغییرات</p>
                            </a>
                            <a data-lg-size="1600-1200" data-src="{{ asset($brandDocument->ncard) }}" target="_blank"
                               class="lg-item">
                                @switch(pathinfo(asset($brandDocument->ncard), PATHINFO_EXTENSION))
                                    @case('pdf')
                                        <img src="{{ asset('admin-assets/panel-assets/img/pdfIcon.svg') }}"/>
                                        @break
                                    @default
                                        <img src="{{ asset($brandDocument->ncard) }}"/>

                                @endswitch
                                <p>کارت ملی</p>
                            </a>
                            {{--                        <a data-lg-size="1600-1200" data-src="4.jpg" class="lg-item">--}}
                            {{--                            <img src="4.jpg" />--}}
                            {{--                            <p>سایر...</p>--}}
                            {{--                        </a>--}}
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-5" style="padding-top: 43px;">
            <small class="text-light topCardUserSubmitter mb-5">کاربر ثبت کننده</small>
            <div class="cart-user-submitter mt-2">
                <div class="d-flex justify-content-between pt-3">
                    @php
                        $brandOwner = $brand->owner;
                    @endphp
                    <p>نام:</p>
                    <p>{{ $brandOwner?$brandOwner->first_name:''}}</p>
                </div>
                <div class="d-flex justify-content-between pt-3">
                    <p>نام خانوادگی:</p>
                    <p>{{ $brandOwner?$brandOwner->last_name:'' }}</p>
                </div>
                <div class="d-flex justify-content-between pt-3">
                    <p>شماره همراه:</p>
                    <p>{{ $brandOwner?$brandOwner->phone:'' }}</p>
                </div>
                <div class="d-flex justify-content-between pt-3">
                    <p>تاریخ:</p>
                    <p>{{ $brand->created_at }}</p>
                </div>
                <hr class="text-light mx-3">
                <div class="d-flex justify-content-between mx-3 gp-btn">

                    <button type="submit" class="btn btn-primary mx-1 my-2 my-md-0 w-100" id="brandValidationAccept"
                            form="form"
                            style="padding: 5px; height: 38px">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.62534 2.63932C0.75 3.84412 0.75 5.56275 0.75 9C0.75 12.4373 0.75 14.1559 1.62534 15.3607C1.90804 15.7498 2.25022 16.092 2.63932 16.3747C3.84412 17.25 5.56275 17.25 9 17.25C12.4373 17.25 14.1559 17.25 15.3607 16.3747C15.7498 16.092 16.092 15.7498 16.3747 15.3607C17.25 14.1559 17.25 12.4373 17.25 9C17.25 5.56275 17.25 3.84412 16.3747 2.63932C16.092 2.25022 15.7498 1.90804 15.3607 1.62534C14.1559 0.75 12.4373 0.75 9 0.75C5.56275 0.75 3.84412 0.75 2.63932 1.62534C2.25022 1.90804 1.90804 2.25022 1.62534 2.63932ZM14.0955 6.70858C14.3488 6.4257 14.3248 5.99106 14.0419 5.73779C13.759 5.48452 13.3244 5.50853 13.0711 5.79142L9.98271 9.241C9.35691 9.93999 8.93546 10.4083 8.57514 10.7111C8.23189 10.9996 8.03029 11.0625 7.85417 11.0625C7.67805 11.0625 7.47644 10.9996 7.13319 10.7111C6.77287 10.4082 6.35142 9.93999 5.72562 9.241L4.92888 8.35108C4.67561 8.0682 4.24097 8.04419 3.95808 8.29746C3.6752 8.55072 3.65119 8.98536 3.90446 9.26825L4.73523 10.1962C5.31809 10.8472 5.80427 11.3903 6.24849 11.7637C6.71841 12.1587 7.22527 12.4375 7.85417 12.4375C8.48307 12.4375 8.98993 12.1587 9.45984 11.7637C9.90407 11.3903 10.3902 10.8473 10.9731 10.1962L14.0955 6.70858Z"
                                  fill="white"/>
                        </svg>
                        تایید و فعال سازی
                    </button>

                    <button type="button" class="btn btn-danger mx-1 w-100" data-bs-toggle="modal" data-bs-target="#exampleModal77"
                            style="font-size: 12px;padding: 5px ; height: 38px">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.62534 2.63932C0.75 3.84412 0.75 5.56275 0.75 9C0.75 12.4373 0.75 14.1559 1.62534 15.3607C1.90804 15.7498 2.25022 16.092 2.63932 16.3747C3.84412 17.25 5.56275 17.25 9 17.25C12.4373 17.25 14.1559 17.25 15.3607 16.3747C15.7498 16.092 16.092 15.7498 16.3747 15.3607C17.25 14.1559 17.25 12.4373 17.25 9C17.25 5.56275 17.25 3.84412 16.3747 2.63932C16.092 2.25022 15.7498 1.90804 15.3607 1.62534C14.1559 0.75 12.4373 0.75 9 0.75C5.56275 0.75 3.84412 0.75 2.63932 1.62534C2.25022 1.90804 1.90804 2.25022 1.62534 2.63932ZM7.54158 6.79174C7.27309 6.52326 6.83779 6.52326 6.5693 6.79174C6.30082 7.06023 6.30082 7.49553 6.5693 7.76402L8.02771 9.22242L6.5693 10.6808C6.30082 10.9493 6.30082 11.3846 6.5693 11.6531C6.83779 11.9216 7.27309 11.9216 7.54158 11.6531L8.99998 10.1947L10.4584 11.6531C10.7269 11.9216 11.1622 11.9216 11.4307 11.6531C11.6991 11.3846 11.6991 10.9493 11.4307 10.6808L9.97226 9.22242L11.4307 7.76402C11.6991 7.49553 11.6991 7.06023 11.4307 6.79174C11.1622 6.52326 10.7269 6.52326 10.4584 6.79174L8.99998 8.25015L7.54158 6.79174Z"
                                  fill="#FFF"/>
                        </svg>
                        عدم تایید
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal77" tabindex="-1" aria-labelledby="exampleModalLabel77"
                         data-bs-target="#exampleModal77"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!--                                        <div class="modal-header">-->
                                <!--                                            <button type="button" class="btn-close" data-bs-dismiss="modal"-->
                                <!--                                                    aria-label="Close"></button>-->
                                <!--                                        </div>-->
                                <div class="modal-body mt-5">
                                    <div class="text-center">
                                        <svg width="98" height="98" viewBox="0 0 98 98" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M34 97.75C36.0711 97.75 37.75 96.0711 37.75 94C37.75 91.9289 36.0711 90.25 34 90.25H29C17.264 90.25 7.75 80.736 7.75 69V64C7.75 61.9289 6.07107 60.25 4 60.25C1.92893 60.25 0.25 61.9289 0.25 64V69C0.25 84.8782 13.1218 97.75 29 97.75H34Z"
                                                fill="#19BAC7"></path>
                                            <path
                                                d="M69 97.75C84.8782 97.75 97.75 84.8782 97.75 69V64C97.75 61.9289 96.0711 60.25 94 60.25C91.9289 60.25 90.25 61.9289 90.25 64V69C90.25 80.736 80.736 90.25 69 90.25H64C61.9289 90.25 60.25 91.9289 60.25 94C60.25 96.0711 61.9289 97.75 64 97.75H69Z"
                                                fill="#19BAC7"></path>
                                            <path
                                                d="M90.25 34C90.25 36.0711 91.9289 37.75 94 37.75C96.0711 37.75 97.75 36.0711 97.75 34V29C97.75 13.1218 84.8782 0.25 69 0.25H64C61.9289 0.25 60.25 1.92893 60.25 4C60.25 6.07107 61.9289 7.75 64 7.75H69C80.736 7.75 90.25 17.264 90.25 29V34Z"
                                                fill="#19BAC7"></path>
                                            <path
                                                d="M0.25 34C0.25 36.0711 1.92893 37.75 4 37.75C6.07107 37.75 7.75 36.0711 7.75 34V29C7.75 17.264 17.264 7.75 29 7.75H34C36.0711 7.75 37.75 6.07107 37.75 4C37.75 1.92893 36.0711 0.25 34 0.25H29C13.1218 0.25 0.25 13.1218 0.25 29V34Z"
                                                fill="#19BAC7"></path>
                                            <path
                                                d="M79 69C79 73.714 79 76.0711 77.5355 77.5355C76.0711 79 73.714 79 69 79C64.286 79 61.9289 79 60.4645 77.5355C59 76.0711 59 73.714 59 69C59 64.286 59 61.9289 60.4645 60.4645C61.9289 59 64.286 59 69 59C73.714 59 76.0711 59 77.5355 60.4645C79 61.9289 79 64.286 79 69Z"
                                                fill="#19BAC7"></path>
                                            <path
                                                d="M79 29C79 33.714 79 36.0711 77.5355 37.5355C76.0711 39 73.714 39 69 39C64.286 39 61.9289 39 60.4645 37.5355C59 36.0711 59 33.714 59 29C59 24.286 59 21.9289 60.4645 20.4645C61.9289 19 64.286 19 69 19C73.714 19 76.0711 19 77.5355 20.4645C79 21.9289 79 24.286 79 29Z"
                                                fill="#19BAC7"></path>
                                            <path
                                                d="M39 29C39 33.714 39 36.0711 37.5355 37.5355C36.0711 39 33.714 39 29 39C24.286 39 21.9289 39 20.4645 37.5355C19 36.0711 19 33.714 19 29C19 24.286 19 21.9289 20.4645 20.4645C21.9289 19 24.286 19 29 19C33.714 19 36.0711 19 37.5355 20.4645C39 21.9289 39 24.286 39 29Z"
                                                fill="#19BAC7"></path>
                                        </svg>
                                        <h4 class="mt-4">نیاز به بازبینی عضویت</h4>

                                    </div>
                                    <div>
                                        <form method="POST"
                                              action="{{ route('admin.reject.membership', ['id' => encrypt($brand->id)]) }}">
                                            @csrf
                                            <label class="mt-3">
                                                توضیحات
                                                <sup class="text-danger">
                                                    *
                                                </sup>
                                            </label>
                                            <textarea
                                                placeholder="توضیحات عدم تایید محصول را در اینجا بنویسید، کاربر توضیحات را مشاهده خواهد کرد."
                                                name="description"
                                                rows="10"
                                                class="form-control"> {{ $brand->rejectionReasons->first()?$brand->rejectionReasons->first()->description:'' }} </textarea>
                                            <div class="text-center">
                                                <div class="submitOrEject mt-3">
                                                    <button class="mx-1 btn btn-primary">ثبت</button>
                                                    <button class="mx-1 btn btn-outline-danger" data-bs-dismiss="modal">
                                                        انصراف
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
