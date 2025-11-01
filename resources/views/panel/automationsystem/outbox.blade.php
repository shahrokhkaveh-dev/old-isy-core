@extends('panel.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/Tabs1.css') }}">
    <title>صندوق خروجی</title>
    <link href="{{ asset('assets/plugins/select2@4.1.0/select2min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <div class="body-pishkhan mt-4">
        <span class="dot"></span>
        <span>صندوق خروجی</span>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-xl-3 mb-3">
            <a class="btn btn-primary d-block mb-3" href="{{ route("automationSystem.createpage") }}">نوشتن نامه جدید</a>
            @include('panel.automationsystem.automationsesyem-sidebar')
        </div>
        <div class="col-12 col-xl-9">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex" style="justify-content: space-between;align-items: center;">
                        <div style="min-width: 94px;">
                            صندوق خروجی
                        </div>
                        <div class="input-group input-group-sm" style="width: unset;">
                            <form action="{{ route('automationSystem.outboxpage') }}" method="get" class="d-inline-flex">
                                <input style="max-width: 200px;max-height:31px;" type="text"
                                    class="form-control rounded-0 rounded-end" placeholder="جستجو نامه"
                                    @if (isset($_GET['search'])) value="{{ $_GET['search'] }}" @endif name="search" id="search" onchange="$('#page').val(1)">
                                <div class="input-group-append">
                                    <button class="btn btn-primary rounded-0 rounded-start btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                        </svg>
                                    </button>
                                </div>
                                <input type="hidden" value="{{ isset($_GET['page']) ? $_GET['page'] : 1 }}" id="page" name="page">
                            </form>
                        </div>
                    </div>
                    <hr />
                    <div class="d-flex" style="justify-content: space-between;align-items: center;">
                        <div>
                            <a class="btn btn-light btn-sm border" href="javascript:void(0);" onclick="location.reload();" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="رفرش صفحه">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                    <path
                                        d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                </svg>
                            </a>
                        </div>
                        <div>
                            <span style="vertical-align: sub;">{{ "$total / $to - $from" }}</span>
                            <button type="button" class="btn btn-light btn-sm border" onclick="back()" @if ($current_page == 1) disabled @endif data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="قبلی">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-light btn-sm border" onclick="forward();" @if ($current_page == $last_page) disabled @endif data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="بعدی">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                                </svg>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover"">
                            <thead class="table-light">
                                <tr>
                                    <td>ردیف</td>
                                    <td>کد رهگیری</td>
                                    <td>عنوان نامه</td>
                                    <td>زمان</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($letters as $key => $letter)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ 1000 + $letter->id }}</td>
                                        <td class="text-primary"><a href="{{ route('automationSystem.show' , ['id'=>encrypt($letter->id) , 'type'=>'sended']) }}">{{ $letter->name }}</a></td>
                                        <td>{{ jdate($letter->created_at)->ago() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    function back() {
        let page = $('#page').val();
        let search = $('#search').val();
        let targetPage = page - 1;
        let url = "{{ route('automationSystem.inboxpage') }}?search="+search+"&page="+targetPage;
        window.location.href = url;
    }

    function forward() {
        let page = $('#page').val();
        let search = $('#search').val();
        let targetPage = page + 1;
        let url = "{{ route('automationSystem.inboxpage') }}?search="+search+"&page="+targetPage;
        window.location.href = url;
    }
</script>
@endsection
