@extends('admin.panel.layout.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <form action="" class="pt-5 search-company-form">
        <div class="search-company">
            <svg class="d-inline-block me-1" width="27" height="27" viewBox="0 0 27 27" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M21.6967 20.4701C21.4039 20.1772 20.929 20.1772 20.6361 20.4701C20.3432 20.763 20.3432 21.2379 20.6361 21.5308L21.6967 20.4701ZM25.3026 26.1974C25.5955 26.4903 26.0704 26.4903 26.3633 26.1974C26.6562 25.9045 26.6562 25.4296 26.3633 25.1367L25.3026 26.1974ZM9.87109 5.47957C10.2802 5.41477 10.5593 5.03059 10.4945 4.62148C10.4297 4.21237 10.0456 3.93324 9.63644 3.99804L9.87109 5.47957ZM4.16402 9.47046C4.09922 9.87957 4.37835 10.2638 4.78746 10.3286C5.19657 10.3933 5.58075 10.1142 5.64555 9.70511L4.16402 9.47046ZM20.6361 21.5308L25.3026 26.1974L26.3633 25.1367L21.6967 20.4701L20.6361 21.5308ZM11.833 21.417C6.44823 21.417 2.08301 17.0518 2.08301 11.667H0.583008C0.583008 17.8802 5.6198 22.917 11.833 22.917V21.417ZM21.583 11.667C21.583 17.0518 17.2178 21.417 11.833 21.417V22.917C18.0462 22.917 23.083 17.8802 23.083 11.667H21.583ZM11.833 1.91699C17.2178 1.91699 21.583 6.28222 21.583 11.667H23.083C23.083 5.45379 18.0462 0.416992 11.833 0.416992V1.91699ZM11.833 0.416992C5.6198 0.416992 0.583008 5.45379 0.583008 11.667H2.08301C2.08301 6.28222 6.44823 1.91699 11.833 1.91699V0.416992ZM9.63644 3.99804C6.81948 4.4442 4.61018 6.6535 4.16402 9.47046L5.64555 9.70511C5.99006 7.52999 7.69597 5.82408 9.87109 5.47957L9.63644 3.99804Z"
                    fill="#C8CCD0"/>
            </svg>
            <input type="text" class="input-search-company d-inline-block" placeholder="نام یا شناسه محصول"
                   name="name_or_id">
            <div class="divider-searcher d-inline-block"></div>
            <svg class="mx-2" width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M14.2083 0.666016C11.7921 0.666016 9.83333 2.62477 9.83333 5.04102C9.83333 7.45726 11.7921 9.41602 14.2083 9.41602C16.6246 9.41602 18.5833 7.45726 18.5833 5.04102C18.5833 2.62477 16.6246 0.666016 14.2083 0.666016ZM11.5833 5.04102C11.5833 3.59127 12.7586 2.41602 14.2083 2.41602C15.6581 2.41602 16.8333 3.59127 16.8333 5.04102C16.8333 6.49076 15.6581 7.66602 14.2083 7.66602C12.7586 7.66602 11.5833 6.49076 11.5833 5.04102Z"
                      fill="#DFE2E5"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M10.7083 11.166C8.29209 11.166 6.33333 13.1248 6.33333 15.541C6.33333 17.9573 8.29209 19.916 10.7083 19.916H17.7083C20.1246 19.916 22.0833 17.9573 22.0833 15.541C22.0833 13.1248 20.1246 11.166 17.7083 11.166H10.7083ZM8.08333 15.541C8.08333 14.0913 9.25859 12.916 10.7083 12.916H17.7083C19.1581 12.916 20.3333 14.0913 20.3333 15.541C20.3333 16.9908 19.1581 18.166 17.7083 18.166H10.7083C9.25859 18.166 8.08333 16.9908 8.08333 15.541Z"
                      fill="#DFE2E5"/>
                <path
                    d="M9.2525 8.11944C9.06848 7.82383 8.72321 7.66602 8.375 7.66602C6.92525 7.66602 5.75 6.49076 5.75 5.04102C5.75 3.59127 6.92525 2.41602 8.375 2.41602C8.72321 2.41602 9.06848 2.2582 9.2525 1.96259C9.26064 1.94951 9.26882 1.93647 9.27706 1.92347C9.58343 1.43987 9.4282 0.75515 8.85917 0.692503C8.70019 0.675 8.53864 0.666016 8.375 0.666016C5.95875 0.666016 4 2.62477 4 5.04102C4 7.45726 5.95875 9.41602 8.375 9.41602C8.53864 9.41602 8.70019 9.40703 8.85917 9.38953C9.4282 9.32688 9.58343 8.64216 9.27706 8.15856C9.26883 8.14556 9.26064 8.13252 9.2525 8.11944Z"
                    fill="#DFE2E5"/>
                <path
                    d="M5.70134 17.369C5.5689 17.1481 5.33513 16.9993 5.07752 16.9993H4.875C3.42525 16.9993 2.25 15.8241 2.25 14.3743C2.25 12.9246 3.42525 11.7493 4.875 11.7493H5.07752C5.33513 11.7493 5.5689 11.6006 5.70134 11.3797C6.02462 10.8403 5.6738 9.99935 5.04497 9.99935H4.875C2.45875 9.99935 0.5 11.9581 0.5 14.3743C0.5 16.7906 2.45875 18.7493 4.875 18.7493H5.04497C5.6738 18.7493 6.02462 17.9084 5.70134 17.369Z"
                    fill="#DFE2E5"/>
            </svg>

            <select class=" d-inline-block input-search-company" id="company_search" placeholder=" نام شرکت"
                    name="company_id">
            </select>
            <button class="btn btn-primary d-inline-block">جست و جو</button>
        </div>


        <div class="filter-company row mx-md-4 mt-3">
            <div class="col-6 col-md-3">
                <label class="d-none d-md-block">دسته بندی</label>
                <select class="form-select" aria-label="Default select example" name="sub_category_id">
                    <option selected class="ms-4" disabled>همه</option>
                    @foreach($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3">
                <label class="d-none d-md-block ">وضعیت</label>
                <select class="form-select" aria-label="Default select example option" name="status">
                    <option selected class="ms-4" disabled>همه</option>
                    <option value="1">منتظر</option>
                    <option value="2">تایید شده</option>
                    <option value="3">رد شده</option>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label class="d-none d-md-block">تاریخ درج محصول</label>
                <div class="dateJoined d-flex justify-content-between mt-3 mt-md-0">
                    <label for="dateJoined-start" class="ps-3 pt-2">از تاریخ :</label>
                    <input autocomplete="off" id="dateJoined-start" class="input-date-joined" data-jdp
                           placeholder="1400/02/12" name="from_date">

                    <label for="dateJoined-end" class="pt-2">تا تاریخ :</label>
                    <input autocomplete="off" id="dateJoined-end" class="input-date-joined" data-jdp
                           placeholder="{{ jdate()->format('Y/m/d')}}" name="to_date">
                </div>
            </div>
        </div>
    </form>
    <div class="d-flex justify-content-around main-record-boxes">
        <div class="bg-check-signup">
            <div class="list-industrial-zone check-product pt-4">
                <table>
                    <tr>
                        <th class="rounded-right" style="text-align: right; padding-right: 40px">نام و شناسه محصول</th>
                        <th class="d-none d-md-table-cell">نام شرکت</th>
                        <th class="d-none d-md-table-cell">وضعیت</th>
                        <th class="d-none d-md-table-cell">شناسه HS</th>
                        <th class="d-none d-md-table-cell">زمان ثبت</th>
                        <th class="rounded-left">عملیات</th>
                    </tr>
                    @foreach($products as $product)
                        <tr>
                            <td class="rounded-right">
                                <div class="d-flex">
                                    <img src="{{ asset($product->image) }}" alt="">
                                    <div>
                                        <h6 class="ps-2 pt-2">{{ $product->name }}</h6>
                                        <p class="ps-2 text-start">ID: {{ $product->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell"><p>{{ $product->brand?$product->brand->name:'' }}</p>
                            </td>
                            <td class="d-none d-md-table-cell"><p>{{ $product->status}}</p></td>
                            <td class="d-none d-md-table-cell"><p>{{ $product->HSCode }}</p></td>
                            <td class="d-none d-md-table-cell mt-2">
                                <p>{{ jdate($product->created_at)->format('Y/m/d') }}</p>
                                <p>{{jdate($product->created_at)->format('H:i:s')}}</p></td>
                            <td class="rounded-left">
                                <a href="{{ route('admin.check.products.show' , ['id' => encrypt($product->id)])  }}"
                                   class="btn btn-primary">

                                    <svg width="12" height="10" viewBox="0 0 12 10" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.87451 5C4.87451 4.37868 5.37819 3.875 5.99951 3.875C6.62083 3.875 7.12451 4.37868 7.12451 5C7.12451 5.62132 6.62083 6.125 5.99951 6.125C5.37819 6.125 4.87451 5.62132 4.87451 5Z"
                                            fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M3.17538 1.79786C3.96114 1.1545 4.92904 0.625 5.99951 0.625C7.06999 0.625 8.03789 1.1545 8.82365 1.79786C9.6137 2.44473 10.2597 3.23932 10.6938 3.84401L10.7296 3.8938C10.9909 4.25692 11.2061 4.55583 11.2061 5C11.2061 5.44417 10.9909 5.74308 10.7296 6.10621L10.6938 6.15599C10.2597 6.76068 9.6137 7.55527 8.82365 8.20214C8.03789 8.8455 7.06999 9.375 5.99951 9.375C4.92904 9.375 3.96114 8.8455 3.17538 8.20214C2.38533 7.55527 1.73932 6.76068 1.30522 6.15599L1.26942 6.10621C1.00809 5.74308 0.792969 5.44417 0.792969 5C0.792969 4.55583 1.00809 4.25692 1.26942 3.8938L1.30522 3.84401C1.73932 3.23932 2.38533 2.44473 3.17538 1.79786ZM5.99951 3.125C4.96398 3.125 4.12451 3.96447 4.12451 5C4.12451 6.03553 4.96398 6.875 5.99951 6.875C7.03505 6.875 7.87451 6.03553 7.87451 5C7.87451 3.96447 7.03505 3.125 5.99951 3.125Z"
                                              fill="white"/>
                                    </svg>

                                    <span class="text-light d-none d-md-inline-block ">مشاهده</span>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </table>

                <nav aria-label="Page navigation example" class="mt-3">
                    <ul class="pagination justify-content-center">
                        {{ $products->links('vendor.pagination.admin-pagination') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        jalaliDatepicker.startWatch({
            maxDate: 'today',
            persianDigits: true,
        });
    </script>
@endsection
