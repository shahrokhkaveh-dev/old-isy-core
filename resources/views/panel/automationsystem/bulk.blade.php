@extends('panel.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/Tabs1.css') }}">
    <title>ارسال نامه</title>
    <link href="{{ asset('assets/plugins/select2@4.1.0/select2min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .modal-header .btn-close {
            padding: 0;
            margin: 0;
        }

        .top-nav1 {
            display: none;
        }

        .send-letter-btn {
            background-color: unset;
            border: unset;
        }

        .input-group:not(.has-validation)> :not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating) {
            border-top-right-radius: unset;
            border-bottom-right-radius: unset;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            width: 65px;
        }

        .input-group> :not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
            margin-left: 0;
            border-top-left-radius: unset;
            border-bottom-left-radius: unset;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        select {
            border: none;
        }

        select option {
            font-family: 'vazir';
        }

        #reciverId {
            width: 250px;
        }

        .tox-promotion,
        .tox-statusbar__branding {
            display: none;
        }

        .tox.tox-tinymce {
            margin-top: 10px;
        }
    </style>
    <style>
        .inputSearchWrapper {
            position: relative;
            width: calc(100% - 65px);
        }

        .searchInputShow,
        .searchInputShow:focus {
            width: 100%;
            border: none;
            outline: none;
            padding: 10px;
            height: 40px;
            border: 1px solid #b8b8b8;
            border-radius: 3px;
        }

        .searchInputShow {
            background-color: #f9f9f9;
        }

        .searchInputShow:focus {
            background-color: #fff;
        }

        .searchedOption {
            position: absolute;
            background: #fff;
            width: 100%;
            display: none;
            z-index: 3;
        }

        .searchedOptionItem {
            padding: 5px 8px;
            font-size: 12px;
            cursor: pointer;
        }

        .searchedOptionItem:hover {
            background-color: #0A0E29;
            color: #fff;
        }

        /*.inputSearchWrapper:has(.searchInputShow:focus) .searchedOption , .searchedOption:hover{*/
        /*    display: block;*/
        /*}*/
        .searchIcon {
            position: absolute;
            top: 7px;
            left: 10px;
            transition: 0.3s all;
        }

        .inputSearchWrapper:has(.searchInputShow:focus) .searchIcon {
            transform: rotate(180deg);
        }

        .subjectInput,
        .subjectInput:focus {
            width: calc(100% - 65px);
            border: none;
            outline: none;
            padding: 10px;
            height: 40px;
            border: 1px solid #b8b8b8;
            border-radius: 3px;
            margin-right: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="body-pishkhan mt-4">
        <span class="dot"></span>
        <span>ارسال نامه</span>
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
                            ارسال نامه
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('automationSystem.doBulk') }}" method="post" autocomplete="off" class="p-4"
                        enctype="multipart/form-data">
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="csrfToken">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <label for="category_id" class="form-label">حوزه فعالیت:</label>
                                <select class="form-select" type="button" name="category_id" id="category_id">
                                    <option value="">حوزه فعالیت</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if (old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-4 mt-2">
                                <label for="province_id" class="form-label">استان:</label>
                                <select class="form-select" type="button" name="province_id" id="province_id">
                                    <option value="">استان</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            @if (old('province_id') == $province->id) selected @endif>{{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-4 mt-2">
                                <label for="city_id" class="form-label">شهر:</label>
                                <select class="form-select" type="button" name="city_id" id="city_id" disabled>
                                    <option value="">شهر</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-4 mt-2">
                                <label for="ipark_id" class="form-label">شهرک‌صنعتی:</label>
                                <select class="form-select" type="button" name="ipark_id" id="ipark_id" disabled>
                                    <option value="">شهرک‌صنعتی</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-2">
                            <label for="subjectInput">موضوع نامه:</label>
                            <input type="text" name="subject" id="subjectInput" class="form-control"
                                value="{{ old('subjectInput') }}">
                        </div>
                        <div class="mt-3">
                            <label for="subjectInput">متن نامه:</label>
                            <textarea id="letter" name="content">
@if (isset($_GET['content']))
{{ $_GET['content'] }}@end{{ old('content') }}
@endif
</textarea>
                        </div>
                        <div class="mt-3">
                            <label for="attachment" class="form-label">فایل پیوست:</label>
                            <input type="file" class="form-control" name="attachment" id="attachment"
                                accept=".pdf , .png , .jpg">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg>
                                ارسال نامه
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#letter',
            language: "fa",
            plugins: 'table colorpicker textcolor',
            toolbar: 'table bold italic alignleft aligncenter alignright alignjustify | outdent indent ',
            toolbar_mode: 'floating'
        });
    </script>
    <script>
        $('#province_id').change(function() {
            let province = $(this).val();
            if (province) {
                $.ajax({
                    type: "get",
                    url: "{{ route('api.application.location.city') }}",
                    data: {
                        'province': province,
                    },
                    success: function(response) {
                        let htmlString = '<option value="">شهر</option>';
                        response.response.cities.forEach(element => {
                            htmlString +=
                                `<option value="${element.id}">${element.name}</option>`
                        });
                        $('#city_id').html(htmlString);
                        $('#city_id').prop('disabled', false);
                    }
                });
                $.ajax({
                    type: "get",
                    url: "{{ route('api.application.location.ipark') }}",
                    data: {
                        'province': province,
                    },
                    success: function(response) {
                        let htmlString = '<option value="">شهرک‌صنعتی</option>';
                        response.response.iparks.forEach(element => {
                            htmlString +=
                                `<option value="${element.id}">${element.name}</option>`
                        });
                        $('#ipark_id').html(htmlString);
                        $('#ipark_id').prop('disabled', false);
                    }
                });
            }else{
                let htmlString = '<option value="">شهر</option>';
                $('#city_id').html(htmlString);
                htmlString = '<option value="">شهرک‌صنعتی</option>';
                $('#ipark_id').html(htmlString);
                $('#city_id').prop('disabled', true);
                $('#ipark_id').prop('disabled', true);
            }
        });
    </script>
@endsection
