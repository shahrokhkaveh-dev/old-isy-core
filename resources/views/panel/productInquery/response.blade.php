@extends('panel.layout.master')
@section('head')
    <title>داشبورد صنعت یار ایران</title>
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/datatable.min.css') }}">
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
        <h3 class="text-start mt-5">درخواست‌های فروش</h3>
    </header>
    <section class="content p-3">
        <div class="table-responsive tableWrapper profileImageWrapper mt-3 p-3">
            <table id="dataTable" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام درخواست کننده</th>
                        <th>نام محصول</th>
                        <th>نام شرکت</th>
                        <th>تعداد مورد نیاز</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inqueries as $key => $inquery)
                    @if ($inquery->product)
                    <tr @if ($inquery->status == 1) class="border-orangeRight" @elseif ($inquery->status == 2) class="border-successRight" @elseif ($inquery->status == 3) class="border-dangerRight" @endif>
                        <td> {{ $key + 1 }} </td>
                        <td>{{ $inquery->author->name }}</td>
                        <td>{{ $inquery->product->name }}</td>
                        <td>{{ $inquery->brand ? $inquery->brand->name : '' }}</td>
                        <td>{{ $inquery->number }}</td>
                        @switch($inquery->status)
                            @case(1)
                                <td>

                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="10" height="10" rx="2" fill="#FD7E14"></rect>
                                        <path
                                            d="M1.66699 0.833336H8.33366V2.08334C8.33387 2.67866 8.1746 3.26317 7.87242 3.7761C7.57023 4.28903 7.13615 4.71164 6.61533 5C7.13615 5.28836 7.57023 5.71097 7.87242 6.2239C8.1746 6.73683 8.33387 7.32134 8.33366 7.91667V9.16667H1.66699V7.91667C1.66678 7.32134 1.82605 6.73683 2.12824 6.2239C2.43042 5.71097 2.8645 5.28836 3.38533 5C2.8645 4.71164 2.43042 4.28903 2.12824 3.7761C1.82605 3.26317 1.66678 2.67866 1.66699 2.08334V0.833336ZM5.00033 5.41667C4.33728 5.41667 3.7014 5.68006 3.23256 6.1489C2.76372 6.61774 2.50033 7.25363 2.50033 7.91667V8.33334H7.50033V7.91667C7.50033 7.25363 7.23693 6.61774 6.76809 6.1489C6.29925 5.68006 5.66337 5.41667 5.00033 5.41667ZM2.50033 1.66667V2.08334C2.50033 2.74638 2.76372 3.38226 3.23256 3.8511C3.7014 4.31994 4.33728 4.58334 5.00033 4.58334C5.66337 4.58334 6.29925 4.31994 6.76809 3.8511C7.23693 3.38226 7.50033 2.74638 7.50033 2.08334V1.66667H2.50033Z"
                                            fill="white"></path>
                                    </svg>

                                    <span class="ps-2"> درانتظار بررسی</span>

                                </td>
                            @break

                            @case(2)
                                <td>

                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="10" height="10" rx="4" fill="#34C759"></rect>
                                        <path
                                            d="M7.07182 2.60459C6.97616 2.55136 6.87095 2.51751 6.7622 2.50498C6.65345 2.49244 6.5433 2.50146 6.43804 2.53153C6.33278 2.5616 6.23448 2.61212 6.14876 2.68021C6.06304 2.7483 5.99159 2.83261 5.93848 2.92834L4.3914 5.71251L3.50598 4.82709C3.42911 4.7475 3.33716 4.68401 3.23549 4.64034C3.13382 4.59666 3.02447 4.57368 2.91382 4.57271C2.80317 4.57175 2.69343 4.59284 2.59102 4.63474C2.48861 4.67664 2.39556 4.73852 2.31732 4.81676C2.23908 4.895 2.1772 4.98805 2.1353 5.09046C2.0934 5.19287 2.07231 5.30261 2.07327 5.41326C2.07424 5.52391 2.09722 5.63326 2.1409 5.73493C2.18457 5.8366 2.24806 5.92855 2.32765 6.00542L3.99432 7.67209C4.15182 7.83001 4.36432 7.91667 4.58348 7.91667L4.6989 7.90834C4.82663 7.89047 4.94847 7.8432 5.05482 7.77025C5.16118 7.69729 5.24915 7.60065 5.31182 7.48792L7.39515 3.73792C7.44834 3.64228 7.48217 3.53709 7.4947 3.42837C7.50724 3.31965 7.49824 3.20953 7.46821 3.10429C7.43819 2.99905 7.38773 2.90075 7.31972 2.81501C7.2517 2.72927 7.16746 2.65777 7.07182 2.60459Z"
                                            fill="white"></path>
                                    </svg>
                                    <span class="ps-2">تایید شده</span>

                                </td>
                            @break

                            @case(3)
                                <td>

                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="10" height="10" rx="2" fill="#FF5151"></rect>
                                        <path d="M7.03125 2.96875L2.96875 7.03125M2.96875 2.96875L7.03125 7.03125"
                                            stroke="white" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                    </svg>


                                    <span class="ps-2">رد شده</span>

                                </td>
                            @break
                        @endswitch
                        <td>
                            @if ($inquery->status == 1)
                            <button type="bottun" class="btn btn-sm btn-primary" onclick="productInqueryResponse({{ $inquery->id }})">
                                پاسخ
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                <tfoot class="d-none">
                    <tr>
                        <th>ردیف</th>
                        <th>نام درخواست کننده</th>
                        <th>نام محصول</th>
                        <th>نام شرکت</th>
                        <th>تعداد مورد نیاز</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/jquery-datatable/datatable.min.js') }}"></script>
    <script>
        // $(document).ready(function() {
        //     $('#dataTable').DataTable();
        // });
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
                }, null, null, null, null, {
                    searchable: false
                }, {
                    orderable: false,
                    searchable: false
                }],
            });
            $('div.dataTables_filter input').addClass('form-control');
            productInqueryResponse = function(id) {
                action = '{{ route('panel.inquiry.store') }}'
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
                // const {
                //     value: formValues
                // } = await Swal.fire({
                //     title: 'Multiple inputs',
                //     html: '<input id="swal-input1" class="swal2-input">' +
                //         '<input id="swal-input2" class="swal2-input">',
                //     focusConfirm: false,
                //     preConfirm: () => {
                //         return [
                //             document.getElementById('swal-input1').value,
                //             document.getElementById('swal-input2').value
                //         ]
                //     }
                // })

                // if (formValues) {
                //     Swal.fire(JSON.stringify(formValues))
                // }
                // $.ajax({
                //     type: "method",
                //     url: "url",
                //     data: "data",
                //     dataType: "dataType",
                //     success: function (response) {

                //     }
                // });
            }
        });
    </script>
@endsection
