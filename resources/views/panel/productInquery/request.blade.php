@extends('panel.layout.master')
@section('head')
    <title>داشبورد صنعت یار ایران</title>
    <style>
        th {
            text-align: right !important;
        }

        .dataTables_wrapper .dataTables_paginate span .paginate_button {
            background: #fff !important;
            padding: 8px 16px !important;
            text-decoration: none !important;
            border: 1px solid #D2D2D2 !important;
            border-radius: 4px !important;
        }

        .dataTables_filter {

            float: left;
            margin-top: -40px;
        }

        .dataTables_info {

            float: left;
        }

        tbody tr {
            background: #EDEDED !important;
            margin-top: 15px !important;
            height: 50px !important;
            border-bottom: 5px solid white !important;
        }

        tbody tr td {
            border: none !important;
        }

        table {
            border-collapse: collapse !important;
        }
    </style>
@endsection
@section('content')
    <header class="d-flex justify-content-between">
        <h3 class="text-start mt-5">درخواست‌های خرید</h3>
    </header>
    <section class="content p-3">
        <div class="table-responsive tableWrapper profileImageWrapper mt-3 p-3">
            <table id="dataTable" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام محصول</th>
                        <th>نام برند</th>
                        <th>تعداد مورد نیاز</th>
                        <th>وضعیت</th>
                        <th>قیمت</th>
                        <th>تاریخ پاسخ</th>
                        <th>پیش فاکتور</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inqueries as $key => $inquery)
                        @if ($inquery->product)
                            <tr
                                @if ($inquery->status == 1) class="border-orangeRight" @elseif ($inquery->status == 2) class="border-successRight" @elseif ($inquery->status == 3) class="border-dangerRight" @endif>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $inquery->product->name }}</td>
                                <td>{{ $inquery->destination->name }}</td>
                                <td>{{ $inquery->number }}</td>
                                <td>{{ $inquery->status() }}</td>
                                <td>{{ $inquery->amount }}</td>
                                <td>{{ $inquery->response_date ? jdate($inquery->response_date) : '' }}</td>
                                <td>
                                    @if ($inquery->prefactor_path)
                                        <a href="{{ asset($inquery->prefactor_path) }}"
                                            class="btn btn-sm btn-primary text-white">دانلود پیش‌فاکتور</a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot class="d-none">
                    <tr>
                        <th>نام محصول</th>
                        <th>نام برند</th>
                        <th>تعداد مورد نیاز</th>
                        <th>وضعیت</th>
                        <th>قیمت</th>
                        <th>تاریخ پاسخ</th>
                        <th>پیش فاکتور</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/jquery-datatable/datatable.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "داده ای جهت نمایش وجود ندارد",
                    "info": "نمایش _START_ تا _END_ از _TOTAL_ نتیجه",
                    "infoEmpty": "نمایش 0 تا 0 از 0 نتیجه",
                    "infoFiltered": "محتوا محدود شده است",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "نمایش _MENU_ نتیجه",
                    "loadingRecords": "لطفا صبر کنید ...",
                    "processing": "در حال پردازش",
                    "search": "",
                    "searchPlaceholder": "جستجو...",
                    "zeroRecords": "رکوردی یافت نشد",
                    "paginate": {
                        "first": "اولین",
                        "last": "آخرین",
                        "next": "بعدی",
                        "previous": "قبلی"
                    }
                },
                columnDefs: [{
                    className: 'text-center',
                    target: '_all'
                }],
                columns: [{
                    width: "5%"
                }, null, null, null, null, null, {
                    searchable: false
                }, {
                    orderable: false,
                    searchable: false
                }],
            });
            $('div.dataTables_filter input').addClass('form-control');
            productInqueryResponse = function(id) {
                action = '#'
                Swal.fire({
                    title: 'پاسخ به درخواست خرید',
                    html: '<form id="productInqueryForm" method="post" action="' + action +
                        '"enctype="multipart/form-data">' +
                        '<select name="status" id="status" class="form-select"><option value="2">تایید</option><option value="3">عدم تایید</option></select>' +
                        '<input placeholder="قیمت" name="amount" class="form-control">' +
                        '<input type="hidden" name="productInqueryId" value="' + id + '">' +
                        '{{ csrf_field() }}' +
                        '<p class="mt-2">ارسال پیش فاکتور</p><input type="file" name="prefactor" class="form-control" accept="application/pdf">' +
                        '<button class="btn btn-primary mt-2">تایید</button>' +
                        '</form>',
                    showCancelButton: false,
                    showConfirmButton: false,
                    showLoaderOnConfirm: true,
                    showLoaderOnConfirm: true,
                    preConfirm: () => {},
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#productInqueryForm').submit();
                    }
                })
            }
        });
    </script>
@endsection
