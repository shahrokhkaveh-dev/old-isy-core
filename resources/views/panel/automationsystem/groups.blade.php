@extends('panel.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/Tabs1.css') }}">
    <title>گروه‌های من</title>
    <link href="{{ asset('assets/plugins/select2@4.1.0/select2min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <div class="body-pishkhan mt-4">
        <span class="dot"></span>
        <span>گروه‌های من</span>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-xl-3 mb-3">
            <a class="btn btn-primary d-block mb-3" href="{{ route("automationSystem.groupCreatePage") }}">ساخت گروه جدید</a>
            @include('panel.automationsystem.automationsesyem-sidebar')
        </div>
        <div class="col-12 col-xl-9">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex" style="justify-content: space-between;align-items: center;">
                        <div style="min-width: 94px;">
                            گروه‌های من
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover"">
                            <thead class="table-light">
                                <tr>
                                    <td>ردیف</td>
                                    <td>نام گروه</td>
                                    <td>حذف</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $key => $group)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><a href="{{ route('automationSystem.groupShow' , ['id'=>encrypt($group->id)]) }}" class="text-primary">{{ $group->name }}</a></td>
                                        <td>
                                            <a href="{{ route('automationSystem.destroyGroup') }}"
                                                data-group="{{ encrypt($group->id) }}"
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

                var group_id = document.createElement("input");
                group_id.setAttribute("type", "hidden");
                group_id.setAttribute("name", 'group_id');
                group_id.setAttribute("value", $(this).attr('data-group'));
                form.appendChild(group_id);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>
@endsection
