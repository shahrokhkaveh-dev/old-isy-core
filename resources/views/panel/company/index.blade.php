@extends('panel.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/Tabs1.css') }}">
    <title>اطلاعات برند</title>
    <link href="{{ asset('assets/plugins/select2@4.1.0/select2min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .addImageBox {
            height: 180px;
            width: 180px;
            border: 1px dashed #FD7E14;
            position: relative;
            cursor: pointer;
        }

        .addImageBox>span {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            text-align: center;
        }

        .imageBox {
            position: relative;
            height: 180px;
            width: 180px;
        }

        .imageBox img {
            height: 180px;
            width: 180px;
        }

        .deleteImageBox {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            padding-top: 60px;
            background: #0000009c;
            display: none;
            transition: all 0.5s ease;
        }

        .imageBox:hover .deleteImageBox {
            display: unset;
        }

        .actionBtn {
            border: none;
            width: 164px;
            height: 40px;
            flex-shrink: 0;
            bottom: none;
            border-radius: 15px;
            background: #0A0E29;
            color: #fff;
            transition: all 0.2s ease-in-out;
            -webkit-transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -ms-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;
        }

        .ck.ck-word-count {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="body-pishkhan mt-4">
        <span class="dot"></span>
        <span>پروفایل شرکت </span>
    </div>
    <div class="content mt-4">
        <div class="tabs">
            <input type="radio" id="tab1" name="tab-control" checked>
            <input type="radio" id="tab2" name="tab-control">
            <input type="radio" id="tab3" name="tab-control">
            <input type="radio" id="tab4" name="tab-control">
            <ul>
                <li title="Features"><label for="tab1" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-buildings" viewBox="0 0 16 16">
                            <path
                                d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022ZM6 8.694 1 10.36V15h5V8.694ZM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15Z" />
                            <path
                                d="M2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-2 2h1v1H2v-1Zm2 0h1v1H4v-1Zm4-4h1v1H8V9Zm2 0h1v1h-1V9Zm-2 2h1v1H8v-1Zm2 0h1v1h-1v-1Zm2-2h1v1h-1V9Zm0 2h1v1h-1v-1ZM8 7h1v1H8V7Zm2 0h1v1h-1V7Zm2 0h1v1h-1V7ZM8 5h1v1H8V5Zm2 0h1v1h-1V5Zm2 0h1v1h-1V5Zm0-2h1v1h-1V3Z" />
                        </svg>
                        <br>
                        <span>اطلاعات شرکت</span></label></li>
                <li title="Gallery"><label for="tab2" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-images" viewBox="0 0 16 16">
                            <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                            <path
                                d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z" />
                        </svg>
                        <br>
                        <span>گالری تصاویر</span></label></li>
                <li title="Delivery Contents"><label for="tab3" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                        <br>
                        <span>کاربران</span></label></li>
                <li title="Delivery Contents"><label for="tab4" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-file-earmark" viewBox="0 0 16 16">
                            <path
                                d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
                        </svg>
                        <br>
                        <span>درباره شرکت</span></label></li>

            </ul>

            <div class="slider">
                <div class="indicator"></div>
            </div>
            <div class="tabContent">
                <section>
                    <div class="border-piskhan mt-3">
                        <div class="row text-center pb-4 mx-auto ps-4">
                            <div class="row ">
                                <div class="d-flex justify-content-between">
                                    <h3 class="text-start mt-5">مشخصات حساب</h3>
                                    {{--                                    'panel.company.setlogo' --}}
                                    <form action="{{ route('panel.company.setlogo') }}" id="logoChanger" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <label>
                                            <img class="mt-5 img-profile"
                                                src="{{ \Illuminate\Support\Facades\Auth::user()->brand ? asset(\Illuminate\Support\Facades\Auth::user()->brand->logo_path) : null }}"
                                                alt="">
                                            <input accept="image/*" type="file" name="image"
                                                onchange="logoChanger.submit()" class="d-none">
                                            <span class="pen">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2.5 17.5L4.16665 12.5L13.3333 3.33333C14.1667 2.5 15.8333 2.5 16.6667 3.33333C17.5 4.16667 17.5 5.83333 16.6667 6.66667L7.49998 15.8333L2.5 17.5Z"
                                                        stroke="#252525" stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M12.5 4.16666L15.8333 7.5" stroke="#252525"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M5 12.5L7.5 15" stroke="#252525" stroke-width="0.833333"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M14.1667 3.33333H16.6667V5.83333L7.5 15L5 12.5L14.1667 3.33333Z"
                                                        fill="#252525" fill-opacity="0.3" />
                                                </svg>
                                            </span>
                                        </label>
                                    </form>
                                </div>
                                <div class="col-12 col-md-3 mt-5">
                                    <label class="form-label float-end">نام شرکت</label>
                                    <input type="text" disabled class="form-control disabled"
                                        value="{{ $brand->name }}">
                                </div>
                                <div class="col-12 col-md-3 mt-5">
                                    <label class="form-label float-end">شناسه ملی</label>
                                    <input type="text" disabled class="form-control disabled"
                                        value="{{ $brand->nationality_code }}">
                                </div>
                                <div class="col-12 col-md-3 mt-5">
                                    <label class="form-label float-end">شماره ثبت </label>
                                    <input type="text" disabled class="form-control disabled"
                                        value="{{ $brand->register_code }}">
                                </div>
                                <div class="col-12 col-md-3 mt-5">

                                </div>
                                <div class="col-12 col-md-3 mt-5">
                                    <label class="form-label float-end"> استان </label>
                                    <input type="text" disabled class="form-control disabled"
                                        value="{{ $brand->province ? $brand->province->name : null }}">
                                </div>
                                <div class="col-12 col-md-3 mt-5">
                                    <label class="form-label float-end">شهر</label>
                                    <input type="text" disabled class="form-control disabled"
                                        value="{{ $brand->city ? $brand->city->name : null }}">
                                </div>
                                <div class="col-12 col-md-3 mt-5">
                                    <label class="form-label float-end">شماره تلفن </label>
                                    <input type="text" disabled class="form-control disabled"
                                        value="{{ $brand->phone }}">
                                </div>
                                <div class="col-12 col-md-3 mt-5">
                                    <label class="form-label float-end">کد پستی </label>
                                    <input type="text" disabled class="form-control disabled"
                                        value="{{ $brand->postal_code }}">
                                </div>
                                <div class="col-12 mt-5">
                                    <label class="form-label float-end">نشانی</label>
                                    <input type="text" disabled class="form-control disabled"
                                        value="{{ $brand->address }}">
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="border-piskhan mt-3">
                        <div class="row text-center pb-4 mx-auto ps-4">
                            <div class="row ">
                                <div class="d-flex justify-content-between">
                                    <h3 class="text-start mt-5">گالری تصاویر</h3>
                                    <label class="btn btn-add mt-5">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.8332 10.8317H10.8332V15.8317H9.1665V10.8317H4.1665V9.16499H9.1665V4.16499H10.8332V9.16499H15.8332V10.8317Z"
                                                fill="#0FA958" />
                                        </svg>
                                        افزودن تصویر جدید
                                        <input type="file" name="image" id="setImageToGalleryInput" class="d-none"
                                            accept="image/*" onchange="setImageToGallery()">
                                    </label>
                                </div>
                                <div class="d-flex flex-wrap img-gallery ">
                                    @foreach ($images as $image)
                                        <img style="cursor: pointer" src="{{ asset($image) }}" alt=""
                                            onclick="galleryModalShow()" data-link="{{ $image }}">
                                    @endforeach
                                </div>

                            </div>
                            <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header ">
                                            <!--                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>-->
                                            <button type="button" class="btn btn-transpaernt text-danger p-0"
                                                data-bs-dismiss="modal" aria-label="Close"><span>بستن</span>
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2.3681 0.724024L7.0001 5.35602L11.6081 0.748024C11.7099 0.639685 11.8325 0.553018 11.9686 0.493219C12.1047 0.43342 12.2515 0.401722 12.4001 0.400024C12.7184 0.400024 13.0236 0.526453 13.2486 0.751496C13.4737 0.97654 13.6001 1.28176 13.6001 1.60002C13.6029 1.74715 13.5756 1.89329 13.5199 2.02948C13.4642 2.16568 13.3812 2.28905 13.2761 2.39202L8.6081 7.00002L13.2761 11.668C13.4739 11.8615 13.5899 12.1235 13.6001 12.4C13.6001 12.7183 13.4737 13.0235 13.2486 13.2486C13.0236 13.4736 12.7184 13.6 12.4001 13.6C12.2472 13.6064 12.0946 13.5808 11.952 13.5251C11.8095 13.4693 11.6801 13.3845 11.5721 13.276L7.0001 8.64402L2.3801 13.264C2.2787 13.3688 2.15758 13.4524 2.0237 13.51C1.88983 13.5677 1.74586 13.5983 1.6001 13.6C1.28184 13.6 0.976613 13.4736 0.751569 13.2486C0.526526 13.0235 0.400098 12.7183 0.400098 12.4C0.3973 12.2529 0.424596 12.1068 0.480312 11.9706C0.536027 11.8344 0.618986 11.711 0.724098 11.608L5.3921 7.00002L0.724098 2.33202C0.52632 2.13854 0.410345 1.87652 0.400098 1.60002C0.400098 1.28176 0.526526 0.97654 0.751569 0.751496C0.976613 0.526453 1.28184 0.400024 1.6001 0.400024C1.8881 0.403624 2.1641 0.520024 2.3681 0.724024Z"
                                                        fill="#FF0000" />
                                                </svg>

                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="" id="galleryModalImg" alt="">
                                        </div>
                                        <div class="modal-footer mt-3">
                                            <a download="" id="galleryModalDownload" href=""
                                                class="btn btn-primary">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.00016 10.3334L2.8335 6.16671L4.00016 4.95837L6.16683 7.12504V0.333374H7.8335V7.12504L10.0002 4.95837L11.1668 6.16671L7.00016 10.3334ZM2.00016 13.6667C1.54183 13.6667 1.14961 13.5037 0.823496 13.1775C0.497385 12.8514 0.334052 12.4589 0.333496 12V9.50004H2.00016V12H12.0002V9.50004H13.6668V12C13.6668 12.4584 13.5038 12.8509 13.1777 13.1775C12.8516 13.5042 12.4591 13.6673 12.0002 13.6667H2.00016Z"
                                                        fill="white" />
                                                </svg>

                                                <span class="ps-2">دانلود</span>
                                            </a>
                                            <button id="galleryRemoveBtn" type="button" class="btn btn-danger"
                                                onclick="removeImage()" data-link="">

                                                <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2.8335 15.5C2.37516 15.5 1.98294 15.3369 1.65683 15.0108C1.33072 14.6847 1.16738 14.2922 1.16683 13.8333V3H0.333496V1.33333H4.50016V0.5H9.50016V1.33333H13.6668V3H12.8335V13.8333C12.8335 14.2917 12.6704 14.6842 12.3443 15.0108C12.0182 15.3375 11.6257 15.5006 11.1668 15.5H2.8335ZM4.50016 12.1667H6.16683V4.66667H4.50016V12.1667ZM7.8335 12.1667H9.50016V4.66667H7.8335V12.1667Z"
                                                        fill="white" />
                                                </svg>

                                                <span class="ps-2">حذف</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addmember">
                        <svg xmlns="http://www.w3.org/2000/svg" width="58" height="58" viewBox="0 0 58 58"
                            fill="none">
                            <g id="Group 109">
                                <g id="Rectangle 135" filter="url(#filter0_d_1264_1462)">
                                    <rect x="4" width="50" height="50" rx="25" fill="#D9D9D9" />
                                </g>
                                <path id="+"
                                    d="M36.973 26.4344H30.0204V33.3571H27.4691V26.4344H20.5464V23.8085H27.4691V16.8857H30.0204V23.8085H36.973V26.4344Z"
                                    fill="#0A0E29" />
                            </g>
                            <defs>
                                <filter id="filter0_d_1264_1462" x="0" y="0" width="58" height="58"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                    <feOffset dy="4" />
                                    <feGaussianBlur stdDeviation="2" />
                                    <feComposite in2="hardAlpha" operator="out" />
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                                    <feBlend mode="normal" in2="BackgroundImageFix"
                                        result="effect1_dropShadow_1264_1462" />
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1264_1462"
                                        result="shape" />
                                </filter>
                            </defs>
                        </svg>
                        <span>افزودن کاربر</span>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addmember" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="addmember" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">ثبت کاربر</h5>
                                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('panel.company.addmember') }}" method="post"
                                        id="addMemberForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <input class="form-control" name="fname" id="fname"
                                                    placeholder="نام" required>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <input class="form-control" name="lname" id="lname"
                                                    placeholder="نام خانوادگی" required>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <input class="form-control" name="phone" id="phone"
                                                    placeholder="شماره تلفن" maxlength="11" required>
                                            </div>
                                            @foreach (\App\Models\Permission::all() as $p)
                                                <div class="col-6 mt-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="permission[{{ $p->id }}]"
                                                        id="{{ 'create-' . $p->id }}">
                                                    <label class="form-check-label" for="{{ 'create-' . $p->id }}">
                                                        {{ $p->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">لغو</button>
                                    <button type="submit" class="btn btn-primary" form="addMemberForm">ثبت</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table" id="usersTable">
                        <tr>
                            <th>نام</th>
                            <th>شماره تماس</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach ($users as $u)
                            <tr>
                                <td>
                                    {{ $u->name }}
                                </td>
                                <td>
                                    {{ $u->phone }}
                                </td>
                                <td>
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="{{ '#edit' . $u->id }}" class="btn btn-primary">ویرایش
                                    </button>
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="{{ '#delete' . $u->id }}" class="btn btn-danger">حذف
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="{{ 'delete' . $u->id }}" tabindex="-1"
                                        aria-labelledby="{{ 'delete' . $u->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">هشدار</h1>
                                                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    این عمل غیرقابل بازگشت است.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">انصراف
                                                    </button>
                                                    <form action="{{ route('panel.company.removemember') }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="user_id"
                                                            value="{{ $u->id }}">
                                                        <button class="btn btn-danger">حذف</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="{{ 'edit' . $u->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="{{ 'edit' . $u->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">ثبت کاربر</h5>
                                                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('panel.company.editmember') }}" method="post"
                                                        id="{{ 'addMemberForm' . $u->id }}">
                                                        @csrf
                                                        <input type="hidden" name="user_id"
                                                            value="{{ $u->id }}">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input class="form-control" name="fname" id="fname"
                                                                    placeholder="نام" required
                                                                    value="{{ $u->first_name }}">
                                                            </div>
                                                            <div class="col-12 mt-3">
                                                                <input class="form-control" name="lname" id="lname"
                                                                    placeholder="نام خانوادگی" required
                                                                    value="{{ $u->last_name }}">
                                                            </div>
                                                            <div class="col-12 mt-3">
                                                                <input class="form-control" name="phone" id="phone"
                                                                    placeholder="شماره تلفن" maxlength="11" required
                                                                    value="{{ $u->phone }}">
                                                            </div>
                                                            @foreach (\App\Models\Permission::all() as $p)
                                                                <div class="col-6 mt-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="permission[{{ $p->id }}]"
                                                                        id="{{ 'create-' . $p->id }}"
                                                                        @if ($u->access($p->id)) checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="{{ 'create-' . $p->id }}">
                                                                        {{ $p->name }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        لغو
                                                    </button>
                                                    <button type="submit" class="btn btn-primary"
                                                        form="{{ 'addMemberForm' . $u->id }}">
                                                        ثبت
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>


                            </tr>
                        @endforeach

                    </table>
                </section>
                <section>
                    <form action="{{ route('panel.company.managment') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="editorWrapper">
                            <textarea class="form-control" name="description" id="description" maxlength="15">{{ $brand->description }}</textarea>
                            <div id="word-count">
                                <span class="demo-update__words">کلمات : 12</span>
                                <svg class="demo-update__chart" viewBox="0 0 40 40" width="40" height="40"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle stroke="hsl(0, 0%, 93%)" stroke-width="3" fill="none" cx="20"
                                        cy="20" r="17"></circle>
                                    <circle class="demo-update__chart__circle" stroke="hsl(202, 92%, 59%)"
                                        stroke-width="3" stroke-dasharray="71.55000000000001,106" stroke-linecap="round"
                                        fill="none" cx="20" cy="20" r="17"></circle>
                                    <text class="demo-update__chart__characters" x="50%" y="50%"
                                        dominant-baseline="central" text-anchor="middle">81</text>
                                </svg>
                            </div>
                        </div>
                        <div class="table-responsive tableWrapper mt-5 profileImageWrapper">
                            <img src="{{ asset($brand->managment_profile_path) }}" alt=""
                                class="img-fluid profileImage" id="managment_profile_path">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            مشخصات نماینده جهت نمایش در سایت
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>
                                            نام و نام خانوادگی
                                        </th>
                                        <td class="descriptionParent">
                                            <input type="text" value="{{ $brand->managment_name }}"
                                                name="managment_name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            شماره تماس
                                        </th>
                                        <td class="descriptionParent">
                                            <input type="text" value="{{ $brand->managment_number }}"
                                                name="managment_number">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            بارگزاری تصویر نماینده
                                        </th>
                                        <td class="descriptionParent">
                                            <input type="file" name="managment_profile_image">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="actionBtn" id="aboutActionBtn">
                            ثبت اطلاعات
                        </button>
                    </form>
                </section>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/ckeditor5/about/build/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweet-alert2@11.10.6/sweet-alert.min.js') }}"></script>
    <script>
        const maxCharacters = 1000;
        const container = document.querySelector('#editorWrapper');
        const progressCircle = document.querySelector('.demo-update__chart__circle');
        const charactersBox = document.querySelector('.demo-update__chart__characters');
        const wordsBox = document.querySelector('.demo-update__words');
        const circleCircumference = Math.floor(2 * Math.PI * progressCircle.getAttribute('r'));
        const sendButton = document.querySelector('#aboutActionBtn');
        ClassicEditor
            .create(document.querySelector('#description', {}))
            .then(editor => {
                const wordCountPlugin = editor.plugins.get('WordCount');
                const wordCountWrapper = document.getElementById('word-count');

                wordCountWrapper.appendChild(wordCountPlugin.wordCountContainer);

                charactersNumber = wordCountPlugin.characters;
                charactersProgress = charactersNumber / maxCharacters * circleCircumference;
                isLimitExceeded = charactersNumber > maxCharacters;
                isCloseToLimit = !isLimitExceeded && charactersNumber > maxCharacters * .8;
                circleDashArray = Math.min(charactersProgress, circleCircumference);
                progressCircle.setAttribute('stroke-dasharray',
                    `${ circleDashArray },${ circleCircumference }`);
                if (isLimitExceeded) {
                    charactersBox.textContent = `-${ charactersNumber - maxCharacters }`;
                } else {
                    charactersBox.textContent = charactersNumber;
                }
                wordsBox.textContent = `کلمات : ${ wordCountPlugin.words }`;
                container.classList.toggle('demo-update__limit-close', isCloseToLimit);
                container.classList.toggle('demo-update__limit-exceeded', isLimitExceeded);
                sendButton.toggleAttribute('disabled', isLimitExceeded);

                editor.model.document.on('change:data', (evt, data) => {
                    charactersNumber = wordCountPlugin.characters;
                    charactersProgress = charactersNumber / maxCharacters * circleCircumference;
                    isLimitExceeded = charactersNumber > maxCharacters;
                    isCloseToLimit = !isLimitExceeded && charactersNumber > maxCharacters * .8;
                    circleDashArray = Math.min(charactersProgress, circleCircumference);
                    progressCircle.setAttribute('stroke-dasharray',
                        `${ circleDashArray },${ circleCircumference }`);
                    if (isLimitExceeded) {
                        charactersBox.textContent = `-${ charactersNumber - maxCharacters }`;
                    } else {
                        charactersBox.textContent = charactersNumber;
                    }
                    wordsBox.textContent = `کلمات : ${ wordCountPlugin.words }`;
                    container.classList.toggle('demo-update__limit-close', isCloseToLimit);
                    container.classList.toggle('demo-update__limit-exceeded', isLimitExceeded);
                    sendButton.toggleAttribute('disabled', isLimitExceeded);
                });
                // console.log(wordCountPlugin);
                // console.log(`Characters: ${stats.characters}\nWords: ${stats.words}`);
                // wordCount: {
                //     onUpdate: stats => {
                //     }
                // }
            })
            .catch(error => {
                console.error(error);
            });
        // CKEDITOR.replace('description', {
        //     uiColor: '#EBEBEB',
        //     removeButtons: 'PasteFromWord',
        // });
    </script>
    <script>
        $('#addImageBox').click(function() {
            $('#image').click();
        });
        $('#image').change(function() {
            $('#addImageForm').submit();
        });
    </script>

    <script>
        function setImageToGallery() {
            var fd = new FormData();
            var files = $('#setImageToGalleryInput')[0].files[0];
            fd.append('image', files);
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('panel.company.insertimage') }}",
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    htmlString = '<img style="cursor: pointer" onclick="galleryModalShow()" src="' + response
                        .path + '" alt="" data-link="' + response.link + '">';
                    $('.img-gallery').prepend(htmlString);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "تصویر افزوده شد"
                    });
                },
                error: function(data) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "error",
                        title: "ارتباط برقرار نشد"
                    });
                }
            });
        }

        function removeImage() {
            var fd = new FormData();
            var image_path = document.getElementById('galleryRemoveBtn').getAttribute('data-link');
            fd.append('image_path', image_path);
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('panel.company.removeimage') }}",
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#galleryModal').modal('hide');
                    $('img[data-link="' + response.link + '"]').remove();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "تصویر حذف شد"
                    });
                },
                error: function(data) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "error",
                        title: "ارتباط برقرار نشد"
                    });
                }
            });
        }

        function galleryModalShow() {
            $('#galleryModalImg').attr('src', event.target.src);
            $('#galleryModalDownload').attr('href', event.target.src);
            $('#galleryRemoveBtn').attr('data-link', event.target.getAttribute('data-link'))
            $('#galleryModal').modal('show');
        }
    </script>
@endsection
