@extends('panel.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/Tabs1.css') }}">
    <title>تنظیمات</title>
    <link href="{{ asset('assets/plugins/select2@4.1.0/select2min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <div class="body-pishkhan mt-4">
        <span class="dot"></span>
        <span>تنظیمات</span>
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
                            تنظیمات
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-4">
                        <form action="{{route('automationSystem.setting')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label class="form-label">تغییر امضا</label>
                                <input type="file" name="signature" required class="form-control" accept="image/*">
                            </div>
                            <div>
                                <button class="btn btn-primary mt-3" type="submit">
                                    تغییر امضا
                                </button>
                            </div>
                        </form>
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
