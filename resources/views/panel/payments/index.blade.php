@extends('dashboard.layout.master')
@section('head')
    <title> تاریخچه پرداخت</title>
@endsection
@section('content')
    <header class="d-flex" style="justify-content: space-between">
        <h1>
            پرداخت ها
        </h1>
        <button class="actionBtn">
            <a href="{{ route('panel.news.create') }}">افزودن</a>
        </button>
    </header>
    <section class="content">
        <div class="table-responsive tableWrapper profileImageWrapper mt-3">
            <table class="table prodductTable">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">مبلغ</th>
                        <th class="text-center">کد پیگیری</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $key => $payment)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->refrence_code }}</td>
                        <td>{{ $payment->status ? 'موفق' : 'ناموفق' }}</td>
                        <td>{{ jdate($payment->created_at) }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $('.deleteBtn').click(function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'این عمل غیرقابل بازگشت است',
                icon: 'warning',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله مطمئن هستم',
                cancelButtonText: 'انصراف'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
