@extends('panel.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/Tabs1.css') }}">
    <title>مشاهده گروه</title>
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
            /* position: absolute; */
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
        <span>مشاهده گروه</span>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-xl-3 mb-3">
            <a class="btn btn-primary d-block mb-3" href="{{ route('automationSystem.groupsPage') }}">بازگشت به گروه‌ها</a>
            @include('panel.automationsystem.automationsesyem-sidebar')
        </div>
        <div class="col-12 col-xl-9">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex" style="justify-content: space-between;align-items: center;">
                        <div style="min-width: 94px;">
                            گروه : {{ $group->name }}
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <form action="{{ route('automationSystem.addBrandToGroup') }}" method="post" autocomplete="off">
                            <input type="hidden" name="id" value="{{ encrypt($group->id) }}">
                            <input type="hidden" name="_token" id="csrfToken" value="{{ csrf_token() }}">
                            <input type="hidden" id="reciver_id" name="reciver_id">
                            <div class="form-group">
                                <label class="form-lable" from="searchInputShow">افزودن به گروه :</label>
                                <input type="text" class="form-control"
                                    onfocus="$('.searchedOption').css('display' , 'block')" id="searchInputShow"
                                    @if (isset($_GET['reciver_name'])) value="{{ $_GET['reciver_name'] }}" @else value="{{ old('reciver_name') }}" @endif
                                    placeholder="نام شرکت را وارد کنید">
                                <div class="searchedOption shadow-lg border">
                                </div>
                            </div>
                            <button class="mt-3 btn btn-primary">افزودن به گروه</button>
                        </form>
                        <table class="table table-striped table-hover mt-3">
                            <thead class="table-light">
                                <tr>
                                    <td>ردیف</td>
                                    <td>نام شرکت</td>
                                    <td>حذف</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $key => $brand)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $brand->name }}</td>
                                        <td>
                                            <a href="{{ route('automationSystem.removeBrandFromGroup') }}"
                                                data-brand="{{ encrypt($brand->id) }}"
                                                class=" btn btn-sm text-danger btn-delete">حذف</a>
                                        </td>
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
        $('#searchInputShow').keyup(function() {
            if ($('#searchInputShow').val().length >= 3) {
                // console.log($('#searchInputShow').val());
                $.ajax({
                    method: "POST",
                    url: "{{ route('automationSystem.search') }}",
                    data: {
                        '_token': $('#csrfToken').val(),
                        'type': 1,
                        'search': $('#searchInputShow').val(),
                    }
                }).done(function(response) {
                    htmlString = '';
                    response.forEach(function(item) {
                        htmlString += '<div class="searchedOptionItem" onclick="selectReciver(' +
                            item.id + ')">' + item.name + '</div>';
                    });
                    $('.searchedOption').html(htmlString);
                });
            }
        });
        selectReciver = function(id) {
            var name = event.target.innerHTML;
            $('#searchInputShow').val(name);
            $('#reciver_id').val(id);
            $('.searchedOption').css('display', 'none')
        }
        $('#reciverType').change(function() {
            $('#searchInputShow').val('');
            $('#reciver_id').val('');
            $('.searchedOption').html('');
        })
    </script>
    <script>
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "آیا اطمینان دارید؟",
                text: "این عمل غیرقابل بازگشت است.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "حذف",
                cancelButtonText: "انصراف"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement("form");
                    form.setAttribute("method", 'post');
                    form.setAttribute("action", $(this).attr('href'));

                    var token = document.createElement("input");
                    token.setAttribute("type", "hidden");
                    token.setAttribute("name", '_token');
                    token.setAttribute("value", $('meta[name="csrf-token"]').attr('content'));
                    form.appendChild(token);

                    var brand_id = document.createElement("input");
                    brand_id.setAttribute("type", "hidden");
                    brand_id.setAttribute("name", 'brand_id');
                    brand_id.setAttribute("value", $(this).attr('data-brand'));
                    form.appendChild(brand_id);

                    var group_id = document.createElement("input");
                    group_id.setAttribute("type", "hidden");
                    group_id.setAttribute("name", 'group_id');
                    group_id.setAttribute("value", "{{ encrypt($group->id) }}");
                    form.appendChild(group_id);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
@endsection
