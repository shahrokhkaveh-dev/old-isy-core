@extends('admin.panel.layout.master')
@section('content')
    <form action="{{ route('admin.i-park.store') }}" method="post" class="pt-5 search-company-form2">
        @csrf
        <h5 class="ps-4 ms-2">اضافه کردن منطقه صنعتی</h5>
        <div class=" row add-industrial-zone mt-3">
            <div class="col-12 col-md-4 mt-3">
                <select class="form-select" aria-label="Default select example" name="province_id">
                        <option selected class="ms-4" disabled>استان</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-8 mt-3">
                <input type="text" class="form-control" placeholder="شهرک صنعتی" name="name">
            </div>
            <div class="col-12 col-md-8 mt-3">
                <input type="text" class="form-control" placeholder=" توضیحات (اختیاری)" name="description">
            </div>
            <div class="col-12 col-md-4 mt-3">
                <button class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19"
                         fill="none">
                        <path
                            d="M9.75 1.5C9.75 1.08579 9.41421 0.75 9 0.75C8.58579 0.75 8.25 1.08579 8.25 1.5L8.25 8.75H1C0.585786 8.75 0.25 9.08579 0.25 9.5C0.25 9.91421 0.585786 10.25 1 10.25H8.25V17.5C8.25 17.9142 8.58579 18.25 9 18.25C9.41421 18.25 9.75 17.9142 9.75 17.5V10.25H17C17.4142 10.25 17.75 9.91421 17.75 9.5C17.75 9.08579 17.4142 8.75 17 8.75H9.75L9.75 1.5Z"
                            fill="white"/>
                    </svg>
                    افزودن
                </button>
            </div>
        </div>

        <h5 class="ps-4 ms-2 mt-5">لیست مناطق صنعتی</h5>
    </form>
    <div class="d-flex justify-content-around main-record-boxes">
        <div class="bg-check-signup mt-1">
            <form action="{{ route('admin.i-parks') }}">
                <div class="filter-geography">
                    <p class="ms-4 mt-3">فیلتر بر اساس : </p>
                    <div class="row mx-md-4 mx-auto">
                        <div class="col-12 col-md-8 mt-3">
                            <select class="form-select" aria-label="Default select example" name="province">
                                @if(!$provinceId)
                                <option selected class="ms-4" disabled>استان</option>
                                @endif
                                @foreach($provinces as $province)
                                <option value="{{ $province->id }}"
                                @if($provinceId == $province->id) selected @endif>{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-8 mt-3">
                            <input type="text" class="form-control" placeholder="شهرک صنعتی" name="s" value="{{$search}}">
                        </div>
                        <div class="col-12 col-md-4 mt-3">
                            <button class="btn btn-primary">اعمال فیلتر</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="dropdown text-end mt-4 me-4">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    نمایش ({{ $perPage }})
                    <svg class="ms-1" width="12" height="6" viewBox="0 0 12 6" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.5327 1.52796C11.8243 1.23376 11.8222 0.758893 11.528 0.467309C11.2338 0.175726 10.7589 0.177844 10.4673 0.472041L8.72 2.23501C8.01086 2.9505 7.52282 3.44131 7.1093 3.77341C6.7076 4.096 6.44958 4.20668 6.2185 4.23613C6.07341 4.25462 5.92659 4.25462 5.7815 4.23613C5.55042 4.20668 5.2924 4.09601 4.89071 3.77341C4.47718 3.44131 3.98914 2.95051 3.28 2.23501L1.53269 0.472042C1.24111 0.177845 0.766238 0.175726 0.472041 0.46731C0.177844 0.758894 0.175726 1.23376 0.467309 1.52796L2.24609 3.32269C2.91604 3.99866 3.46359 4.55114 3.95146 4.94294C4.45879 5.35037 4.97373 5.64531 5.59184 5.72409C5.86287 5.75864 6.13714 5.75864 6.40816 5.72409C7.02628 5.64531 7.54122 5.35037 8.04854 4.94294C8.53641 4.55114 9.08396 3.99867 9.7539 3.32269L11.5327 1.52796Z"
                            fill="#97F7FF"/>
                    </svg>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('admin.i-parks', ['perPage' => 10]) }}">10</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.i-parks', ['perPage' => 25]) }}">25</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.i-parks', ['perPage' => 50]) }}">50</a></li>
                </ul>
            </div>
            <div class="list-industrial-zone">
                <table>
                    <tr>
                        <th style="border-radius: 0 12px  12px  0">نام شهرک صنعتی</th>
                        <th class="d-none d-md-table-cell">استان</th>
                        <th style="border-radius: 12px 0 0 12px">تعداد شرکت</th>
                    </tr>
                    @foreach($iParks as $iPark)
                        <tr>
                            <td class="rounded-right">{{ $iPark->name }}</td>
                            <td class="d-none d-md-table-cell">{{ $iPark->province->name }}</td>
                            <td class="rounded-left">{{ $iPark->brands?$iPark->brands->count():0 }} شرکت</td>
                        </tr>
                    @endforeach
                </table>
                <nav aria-label="Page navigation example" class="mt-3">
                    <ul class="pagination justify-content-center">
                        {{ $iParks->links('vendor.pagination.admin-pagination') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
