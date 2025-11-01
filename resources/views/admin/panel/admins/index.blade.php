@extends('admin.panel.layout.master')
@section('content')
<div class="pt-5">
    <div class="text-center add-btn">
        <a href="{{ route('admin.admin.create') }}">
            <button class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.75 1C9.75 0.585786 9.41421 0.25 9 0.25C8.58579 0.25 8.25 0.585786 8.25 1L8.25 8.25H1C0.585786 8.25 0.25 8.58579 0.25 9C0.25 9.41421 0.585786 9.75 1 9.75H8.25V17C8.25 17.4142 8.58579 17.75 9 17.75C9.41421 17.75 9.75 17.4142 9.75 17V9.75H17C17.4142 9.75 17.75 9.41421 17.75 9C17.75 8.58579 17.4142 8.25 17 8.25H9.75L9.75 1Z" fill="white"></path>
                </svg>

                افزودن مدیر جدید
            </button>
        </a>
    </div>
    <h5 class="title-card text-light">لیست کاربران</h5>
    <div class="d-flex justify-content-around main-record-boxes">
        <div class="bg-check-signup mt-1">
            <div class="d-flex justify-content-between">
                <div class="mt-4 ms-2">
                    <form class="searcher1" method="get" action="{{ route('admin.admin.index') }}">
                        @if (isset($_GET['page']))
                        <input type="hidden" value="{{ $_GET['page'] }}" name="page">
                        @endif
                        <input type="text" class="form-control" placeholder="جستجو..." name="search" @if(isset($_GET['search'])) value="{{ $_GET['search'] }}" @endif>
                        @if (isset($_GET['perPage']))
                        <input type="hidden" value="{{ $_GET['perPage'] }}" name="perPage">
                        @endif
                    </form>
                </div>
                <div class="dropdown text-end mt-4 me-4 show-page-num d-none d-md-block">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-none d-md-inline-block">نمایش</span> (10)
                        <svg class="ms-1" width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.5327 1.52796C11.8243 1.23376 11.8222 0.758893 11.528 0.467309C11.2338 0.175726 10.7589 0.177844 10.4673 0.472041L8.72 2.23501C8.01086 2.9505 7.52282 3.44131 7.1093 3.77341C6.7076 4.096 6.44958 4.20668 6.2185 4.23613C6.07341 4.25462 5.92659 4.25462 5.7815 4.23613C5.55042 4.20668 5.2924 4.09601 4.89071 3.77341C4.47718 3.44131 3.98914 2.95051 3.28 2.23501L1.53269 0.472042C1.24111 0.177845 0.766238 0.175726 0.472041 0.46731C0.177844 0.758894 0.175726 1.23376 0.467309 1.52796L2.24609 3.32269C2.91604 3.99866 3.46359 4.55114 3.95146 4.94294C4.45879 5.35037 4.97373 5.64531 5.59184 5.72409C5.86287 5.75864 6.13714 5.75864 6.40816 5.72409C7.02628 5.64531 7.54122 5.35037 8.04854 4.94294C8.53641 4.55114 9.08396 3.99867 9.7539 3.32269L11.5327 1.52796Z" fill="#97F7FF"></path>
                        </svg>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ route('admin.admin.index' , ['perPage'=>10]) }}">10</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.admin.index' , ['perPage'=>50]) }}">50</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.admin.index' , ['perPage'=>100]) }}">100</a></li>
                    </ul>
                </div>
            </div>
            <div class="list-industrial-zone check-product">
                <table>
                    <tbody>
                    <tr class="head-nav">
                        <th class="rounded-right"><span class="d-none d-md-block">#</span></th>
                        <th class="">نام کاربری</th>
                        <th class="d-none d-md-table-cell">نام</th>
                        <th class="d-none d-md-table-cell">سطح دسترسی</th>
                        <th class="d-none d-md-table-cell">تاریخ عضویت</th>
                        <th class="rounded-left">عملیات</th>
                    </tr>
                    @foreach ($items as $key => $item)
                    <tr>
                        <td class="rounded-right">
                            <span class="d-none d-md-block">{{ $key + 1 }}</span>
                        </td>
                        <td class="">{{ $item['username'] }}</td>
                        <td class="d-none d-md-table-cell">{{ $item['name'] }}</td>
                        <td class="d-none d-md-table-cell mt-2">{{ $item['role'] }}</td>
                        <td class="d-none d-md-table-cell mt-2">{{ $item['created_at'] }}</td>
                        <td class="rounded-left">
                            <a href="{{ route('admin.admin.edit' , $item['id']) }}" class="btn btn-primary me-3 d-none d-md-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10" fill="none">
                                    <path d="M4.87451 5C4.87451 4.37868 5.37819 3.875 5.99951 3.875C6.62083 3.875 7.12451 4.37868 7.12451 5C7.12451 5.62132 6.62083 6.125 5.99951 6.125C5.37819 6.125 4.87451 5.62132 4.87451 5Z" fill="white"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.17538 1.79786C3.96114 1.1545 4.92904 0.625 5.99951 0.625C7.06999 0.625 8.03789 1.1545 8.82365 1.79786C9.6137 2.44473 10.2597 3.23932 10.6938 3.84401L10.7296 3.8938C10.9909 4.25692 11.2061 4.55583 11.2061 5C11.2061 5.44417 10.9909 5.74308 10.7296 6.10621L10.6938 6.15599C10.2597 6.76068 9.6137 7.55527 8.82365 8.20214C8.03789 8.8455 7.06999 9.375 5.99951 9.375C4.92904 9.375 3.96114 8.8455 3.17538 8.20214C2.38533 7.55527 1.73932 6.76068 1.30522 6.15599L1.26942 6.10621C1.00809 5.74308 0.792969 5.44417 0.792969 5C0.792969 4.55583 1.00809 4.25692 1.26942 3.8938L1.30522 3.84401C1.73932 3.23932 2.38533 2.44473 3.17538 1.79786ZM5.99951 3.125C4.96398 3.125 4.12451 3.96447 4.12451 5C4.12451 6.03553 4.96398 6.875 5.99951 6.875C7.03505 6.875 7.87451 6.03553 7.87451 5C7.87451 3.96447 7.03505 3.125 5.99951 3.125Z" fill="white"></path>
                                </svg>
                                <span class="text-light">مشاهده</span>
                            </a>
                            <a href="{{ route('admin.admin.edit' , $item['id']) }}" class="d-block d-md-none ms-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                                    <path d="M8.75 9C8.75 7.75736 9.75736 6.75 11 6.75C12.2426 6.75 13.25 7.75736 13.25 9C13.25 10.2426 12.2426 11.25 11 11.25C9.75736 11.25 8.75 10.2426 8.75 9Z" fill="#2E75DC"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.35173 2.59572C6.92325 1.30899 8.85905 0.25 11 0.25C13.141 0.25 15.0768 1.30899 16.6483 2.59572C18.2284 3.88946 19.5204 5.47865 20.3886 6.68801L20.4602 6.78759C20.9829 7.51384 21.4131 8.11166 21.4131 9C21.4131 9.88835 20.9829 10.4862 20.4602 11.2124L20.3886 11.312C19.5204 12.5214 18.2284 14.1105 16.6483 15.4043C15.0768 16.691 13.141 17.75 11 17.75C8.85905 17.75 6.92325 16.691 5.35173 15.4043C3.77164 14.1105 2.47962 12.5214 1.61142 11.312L1.53981 11.2124C1.01715 10.4862 0.586914 9.88834 0.586914 9C0.586914 8.11166 1.01715 7.51384 1.53981 6.78759L1.61142 6.68801C2.47962 5.47865 3.77164 3.88946 5.35173 2.59572ZM11 5.25C8.92893 5.25 7.25 6.92893 7.25 9C7.25 11.0711 8.92893 12.75 11 12.75C13.0711 12.75 14.75 11.0711 14.75 9C14.75 6.92893 13.0711 5.25 11 5.25Z" fill="#2E75DC"></path>
                                </svg>
                            </a>
                        </td>
                        {{-- <td class="rounded-left">
                            <a href="{{ route('admin.admin.edit' , ['id'=>$admin->id]) }}" class="btn btn-primary">

                                <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.87451 5C4.87451 4.37868 5.37819 3.875 5.99951 3.875C6.62083 3.875 7.12451 4.37868 7.12451 5C7.12451 5.62132 6.62083 6.125 5.99951 6.125C5.37819 6.125 4.87451 5.62132 4.87451 5Z" fill="white"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.17538 1.79786C3.96114 1.1545 4.92904 0.625 5.99951 0.625C7.06999 0.625 8.03789 1.1545 8.82365 1.79786C9.6137 2.44473 10.2597 3.23932 10.6938 3.84401L10.7296 3.8938C10.9909 4.25692 11.2061 4.55583 11.2061 5C11.2061 5.44417 10.9909 5.74308 10.7296 6.10621L10.6938 6.15599C10.2597 6.76068 9.6137 7.55527 8.82365 8.20214C8.03789 8.8455 7.06999 9.375 5.99951 9.375C4.92904 9.375 3.96114 8.8455 3.17538 8.20214C2.38533 7.55527 1.73932 6.76068 1.30522 6.15599L1.26942 6.10621C1.00809 5.74308 0.792969 5.44417 0.792969 5C0.792969 4.55583 1.00809 4.25692 1.26942 3.8938L1.30522 3.84401C1.73932 3.23932 2.38533 2.44473 3.17538 1.79786ZM5.99951 3.125C4.96398 3.125 4.12451 3.96447 4.12451 5C4.12451 6.03553 4.96398 6.875 5.99951 6.875C7.03505 6.875 7.87451 6.03553 7.87451 5C7.87451 3.96447 7.03505 3.125 5.99951 3.125Z" fill="white"></path>
                                </svg>

                                <span class="text-light d-none d-md-inline-block ">مشاهده</span>
                            </a>

                        </td> --}}
                    </tr>
                    @endforeach

                </tbody></table>

                {{ $admins->links('vendor.pagination.admin-pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection
