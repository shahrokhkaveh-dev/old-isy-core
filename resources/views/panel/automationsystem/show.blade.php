@extends('panel.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/Tabs1.css') }}">
    <title>مشاهده نامه</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .letter-title {
            font-size: 1.25rem;
        }
    </style>
@endsection
@section('content')
    <div class="body-pishkhan mt-4">
        <span class="dot"></span>
        <span>مشاهده نامه</span>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-xl-3 mb-3">
            <a href="{{ route('automationSystem.inboxpage') }}" class="btn btn-primary d-block mb-3">بازگشت به صندوق
                ورودی</a>
            @include('panel.automationsystem.automationsesyem-sidebar')
        </div>
        <div class="col-12 col-xl-9">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex" style="justify-content: space-between;align-items: center;">
                        <div style="min-width: 94px;">
                            مشاهده نامه
                        </div>
                        <div>
                            <a href="{{ $is_attach ? route('automationSystem.attach' , ['id'=>encrypt($letter->id) , 'type'=>$type]) : 'javascript:void(0);' }}" type="button" class="btn btn-light btn-sm border @if(!$is_attach) disabled @endif">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-paperclip" viewBox="0 0 16 16">
                                    <path
                                        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                </svg>
                            </a>
                            @if ($type == 'reciver')
                            <a href="{{ route('automationSystem.archive' , ['id'=>encrypt($letter->id) , 'type'=>$type]) }}" type="button" class="btn btn-light btn-sm border">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-archive" viewBox="0 0 16 16">
                                    <path
                                        d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                                </svg>
                            </a>
                            @endif
                            <a target="_blank" type="button" href="{{ route('automationSystem.print' , ['id'=>encrypt($letter->id) , 'type'=>$type]) }}" class="btn btn-light btn-sm border">                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-printer" viewBox="0 0 16 16">
                                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                                    <path
                                        d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <hr />
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="width: 300px">
                                <p class="letter-title m-0">{{ $letter->name }}</p>
                                <p class="m-0">{{ $brand->name }}</p>
                            </div>
                            <div>
                                <img src="{{ asset($brand->logo_path) }}" alt="" style="height: 90px;width: 90px;">
                            </div>
                            <div style="color: #999; font-size:13px;width:300px;text-align:end;">
                                <p class="m-0 p-0 pe-3">شماره نامه: <span>{{ 1000 + $letter->id }}</span></p>
                                <p class="m-0 p-0 pe-3">تاریخ:
                                    <span>{{ jdate($letter->created_at)->format('y/m/d') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-3">{!! $letter->content !!}</div>
                    <div class="signatureWrapper">
                        <p style="text-align: left;padding-left: 100px;" >امضا<br/>
                            <img src="{{ $signature }}" alt="" class="img-fluid"></p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <a
                            href="{{ url('/panel/automationSystem/create' . "?reciver_name={$letter->author->name}&reciver_id={$letter->author->id}") }}">
                            <img class="my-2" src="{{ asset('automationMobile/img/replay.svg') }}"
                                alt="" /><span class="ps-2">پاسخ</span>
                        </a>
                        <a href="{{ url('/panel/automationSystem/create' . "?content={$letter->content}") }}">
                            <span class="pe-1">ارسال به دیگری</span><img class="my-2"
                                src="{{ asset('automationMobile/img/send-other.svg') }}" alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
