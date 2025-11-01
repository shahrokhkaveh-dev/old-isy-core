@extends('admin.panel.layout.master')
@section('content')
<form action="{{ route('admin.brands.index') }}" class="pt-5 search-company-form" id="searchForm" accept-charset="utf-8">
    <input type="number" name="page" id="page" value="{{ isset($_GET['page']) ? $_GET['page'] : 1 }}" class="d-none">
    <div class="search-company">
        <svg class="d-inline-block me-1" width="27" height="27" viewBox="0 0 27 27" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M21.6967 20.4701C21.4039 20.1772 20.929 20.1772 20.6361 20.4701C20.3432 20.763 20.3432 21.2379 20.6361 21.5308L21.6967 20.4701ZM25.3026 26.1974C25.5955 26.4903 26.0704 26.4903 26.3633 26.1974C26.6562 25.9045 26.6562 25.4296 26.3633 25.1367L25.3026 26.1974ZM9.87109 5.47957C10.2802 5.41477 10.5593 5.03059 10.4945 4.62148C10.4297 4.21237 10.0456 3.93324 9.63644 3.99804L9.87109 5.47957ZM4.16402 9.47046C4.09922 9.87957 4.37835 10.2638 4.78746 10.3286C5.19657 10.3933 5.58075 10.1142 5.64555 9.70511L4.16402 9.47046ZM20.6361 21.5308L25.3026 26.1974L26.3633 25.1367L21.6967 20.4701L20.6361 21.5308ZM11.833 21.417C6.44823 21.417 2.08301 17.0518 2.08301 11.667H0.583008C0.583008 17.8802 5.6198 22.917 11.833 22.917V21.417ZM21.583 11.667C21.583 17.0518 17.2178 21.417 11.833 21.417V22.917C18.0462 22.917 23.083 17.8802 23.083 11.667H21.583ZM11.833 1.91699C17.2178 1.91699 21.583 6.28222 21.583 11.667H23.083C23.083 5.45379 18.0462 0.416992 11.833 0.416992V1.91699ZM11.833 0.416992C5.6198 0.416992 0.583008 5.45379 0.583008 11.667H2.08301C2.08301 6.28222 6.44823 1.91699 11.833 1.91699V0.416992ZM9.63644 3.99804C6.81948 4.4442 4.61018 6.6535 4.16402 9.47046L5.64555 9.70511C5.99006 7.52999 7.69597 5.82408 9.87109 5.47957L9.63644 3.99804Z"
                  fill="#C8CCD0"/>
        </svg>
        <input type="text" class="input-search-company d-inline-block" placeholder="نام شرکت" name="name" value="{{ $_GET['name'] ?? '' }}">
        <div class="divider-searcher d-inline-block"></div>
        <svg class="d-inline-block mx-1" width="22" height="28" viewBox="0 0 22 28" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M14.476 24.3756L13.8858 23.9128L13.8858 23.9128L14.476 24.3756ZM7.52401 24.3756L6.93383 24.8384L7.52401 24.3756ZM11 27.2568L11 26.5068L11 27.2568ZM20.25 11.7609C20.25 13.3458 19.4285 15.4336 18.1679 17.6623C16.9238 19.8618 15.3181 22.0863 13.8858 23.9128L15.0662 24.8384C16.521 22.9832 18.1773 20.6924 19.4735 18.4008C20.7531 16.1387 21.75 13.76 21.75 11.7609H20.25ZM8.11418 23.9128C6.68186 22.0863 5.07616 19.8618 3.83211 17.6623C2.57146 15.4336 1.75 13.3458 1.75 11.7609H0.25C0.25 13.76 1.24695 16.1387 2.5265 18.4008C3.82266 20.6924 5.47896 22.9832 6.93383 24.8384L8.11418 23.9128ZM1.75 11.7609C1.75 6.17927 5.94221 1.75 11 1.75V0.25C5.01209 0.25 0.25 5.45633 0.25 11.7609H1.75ZM11 1.75C16.0578 1.75 20.25 6.17927 20.25 11.7609H21.75C21.75 5.45633 16.9879 0.25 11 0.25V1.75ZM13.8858 23.9128C13.1162 24.8942 12.5957 25.5538 12.125 25.9814C11.6865 26.3798 11.3658 26.5068 11 26.5068L11 28.0068C11.8507 28.0068 12.5149 27.6537 13.1336 27.0917C13.7202 26.5588 14.3295 25.7779 15.0662 24.8384L13.8858 23.9128ZM6.93383 24.8384C7.67054 25.7779 8.27976 26.5588 8.86638 27.0917C9.4851 27.6537 10.1493 28.0068 11 28.0068L11 26.5068C10.6342 26.5068 10.3135 26.3798 9.87495 25.9814C9.40428 25.5538 8.88377 24.8942 8.11418 23.9128L6.93383 24.8384ZM6.5 12.25C6.5 14.7353 8.51472 16.75 11 16.75V15.25C9.34315 15.25 8 13.9069 8 12.25H6.5ZM11 16.75C13.4853 16.75 15.5 14.7353 15.5 12.25H14C14 13.9069 12.6569 15.25 11 15.25V16.75ZM15.5 12.25C15.5 9.76472 13.4853 7.75 11 7.75V9.25C12.6569 9.25 14 10.5931 14 12.25H15.5ZM11 7.75C8.51472 7.75 6.5 9.76472 6.5 12.25H8C8 10.5931 9.34315 9.25 11 9.25V7.75Z"
                  fill="#C8CCD0"/>
        </svg>
        <input type="text" class="d-inline-block input-search-company" placeholder=" شهر یا استان" name="locale" id="locale" onkeyup="mobileLocale.value = this.value" value="{{ $_GET['locale'] ?? '' }}">
        <button class="btn btn-primary d-inline-block">جست و جو</button>
    </div>
    <!--                <div class=" city-in-mobile">-->
        <!--                    <div class="col mt-3 ">-->
            <!--                        <label class="w-100">-->
<!--                            <input type="text" class="form-control city-in-mobile-F d-inline-block" style="padding-right: 40px" placeholder="شهر یا استان">-->
<!--                        </label>-->
<!--                    </div>-->
<!--                </div>-->
    <div class="city-mob">
        <input type="text" class="d-inline-block input-search-company p-0" placeholder=" شهر یا استان" id="mobileLocale" onkeyup="locale.value = this.value" value="{{ $_GET['locale'] ?? '' }}">
    </div>

    <div class="filter-company row mx-md-4 mt-3">
        <div class="col-6 col-md-3">
            <label class="d-none d-md-block">حوزه فعالیت</label>
            <select class="form-select" aria-label="Default select example" name="category">
                <option selected class="ms-4" value="">همه</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if(isset($_GET['category']) && $_GET['category']==$category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3 ">
            <label class="d-none d-md-block ">شهرک صنعتی</label>
            <select class="form-select" aria-label="Default select example option">
                <option selected class="ms-4">همه</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <label class="d-none d-md-block">تاریخ عضویت</label>
            <div class="dateJoined d-flex justify-content-between mt-3 mt-md-0">
                <label for="dateJoined-start" class="ps-3 pt-2">از تاریخ :</label>
                <input autocomplete="off" id="dateJoined-start" class="input-date-joined" data-jdp
                       placeholder="1379/02/12">

                <label for="dateJoined-end" class="pt-2">تا تاریخ :</label>
                <input autocomplete="off" id="dateJoined-end" class="input-date-joined" data-jdp
                       placeholder="1379/02/12">
            </div>
        </div>
        <input type="number" name="perPage" id="perPage" value="{{ isset($_GET['perPage']) ? $_GET['perPage'] : 10 }}" class="d-none">
    </div>
</form>
<div class="d-flex justify-content-around main-record-boxes">
    <div class="bg-check-signup ">
        <div class="dropdown text-end mt-4 me-4">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                نمایش ({{ isset($_GET['perPage']) ? $_GET['perPage'] : 10 }})
                <svg class="ms-1" width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.5327 1.52796C11.8243 1.23376 11.8222 0.758893 11.528 0.467309C11.2338 0.175726 10.7589 0.177844 10.4673 0.472041L8.72 2.23501C8.01086 2.9505 7.52282 3.44131 7.1093 3.77341C6.7076 4.096 6.44958 4.20668 6.2185 4.23613C6.07341 4.25462 5.92659 4.25462 5.7815 4.23613C5.55042 4.20668 5.2924 4.09601 4.89071 3.77341C4.47718 3.44131 3.98914 2.95051 3.28 2.23501L1.53269 0.472042C1.24111 0.177845 0.766238 0.175726 0.472041 0.46731C0.177844 0.758894 0.175726 1.23376 0.467309 1.52796L2.24609 3.32269C2.91604 3.99866 3.46359 4.55114 3.95146 4.94294C4.45879 5.35037 4.97373 5.64531 5.59184 5.72409C5.86287 5.75864 6.13714 5.75864 6.40816 5.72409C7.02628 5.64531 7.54122 5.35037 8.04854 4.94294C8.53641 4.55114 9.08396 3.99867 9.7539 3.32269L11.5327 1.52796Z" fill="#97F7FF"/>
                </svg>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="javascript:void(0);" onclick="perPage.value = 10; searchForm.submit();">10</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);" onclick="perPage.value = 50; searchForm.submit();">50</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);" onclick="perPage.value= 100; searchForm.submit();">100</a></li>
            </ul>
        </div>

        <table >
            <tr class="head-nav">
                <th class="rounded-right"><span class="d-none d-md-block">لوگو</span></th>
                <th >نام شرکت</th>
                <th class="d-none d-md-table-cell">استان</th>
                <th class="d-none d-md-table-cell">وضعیت</th>
                <th class="d-none d-md-table-cell">تاریخ عضویت</th>
                <th class="rounded-left">عملیات</th>
            </tr>
            @foreach ($brands as $brand)
            <tr class="bodyTable">
                <td class="rounded-right">
                    @if ($brand->logo_path)
                    <img class="ms-3" src="{{ asset($brand->logo_path) }}" style="width: 48px;height: 48px;" alt="">
                    @endif
                </td>
                <td>{{ $brand->name }}</td>
                <td class="d-none d-md-table-cell">{{ $brand->province }}</td>
                <td class="d-none d-md-table-cell">{{ $brand->status }}</td>
                <td class="d-none d-md-table-cell ps-4">{{ jdate($brand->created_at)->format('Y/m/d') }}</td>
                <td class="rounded-left">

                    <a href="{{ route('admin.brands.show' , ['id'=>encrypt($brand->id)]) }}" class="btn btn-primary btn-eye">

                        <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.87451 5C4.87451 4.37868 5.37819 3.875 5.99951 3.875C6.62083 3.875 7.12451 4.37868 7.12451 5C7.12451 5.62132 6.62083 6.125 5.99951 6.125C5.37819 6.125 4.87451 5.62132 4.87451 5Z" fill="white"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.17538 1.79786C3.96114 1.1545 4.92904 0.625 5.99951 0.625C7.06999 0.625 8.03789 1.1545 8.82365 1.79786C9.6137 2.44473 10.2597 3.23932 10.6938 3.84401L10.7296 3.8938C10.9909 4.25692 11.2061 4.55583 11.2061 5C11.2061 5.44417 10.9909 5.74308 10.7296 6.10621L10.6938 6.15599C10.2597 6.76068 9.6137 7.55527 8.82365 8.20214C8.03789 8.8455 7.06999 9.375 5.99951 9.375C4.92904 9.375 3.96114 8.8455 3.17538 8.20214C2.38533 7.55527 1.73932 6.76068 1.30522 6.15599L1.26942 6.10621C1.00809 5.74308 0.792969 5.44417 0.792969 5C0.792969 4.55583 1.00809 4.25692 1.26942 3.8938L1.30522 3.84401C1.73932 3.23932 2.38533 2.44473 3.17538 1.79786ZM5.99951 3.125C4.96398 3.125 4.12451 3.96447 4.12451 5C4.12451 6.03553 4.96398 6.875 5.99951 6.875C7.03505 6.875 7.87451 6.03553 7.87451 5C7.87451 3.96447 7.03505 3.125 5.99951 3.125Z" fill="white"></path>
                        </svg>

                        <span class="text-light d-none d-md-inline-block ">مشاهده</span>
                    </a>
                </td>
            </tr>
            @endforeach
        </table>





        {{ $brands->links('vendor.pagination.admin-pagination') }}
    </div>
</div>
@endsection
