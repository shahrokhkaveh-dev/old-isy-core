@extends('panel.layout.master')
@section('head')
    <title> محصولات و خدمات</title>
@endsection
@section('content')
        <header class="d-flex justify-content-between">
            <h3 class="text-start mt-5">محصولات</h3>
            <a href="{{ route('panel.products.create') }}" class="btn btn-add mt-5">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.8332 10.8317H10.8332V15.8317H9.1665V10.8317H4.1665V9.16499H9.1665V4.16499H10.8332V9.16499H15.8332V10.8317Z" fill="#0FA958"></path>
                </svg>
                افزودن محصول جدید
            </a>
        </header>
    <section class="content">
        <div class="table-responsive tableWrapper profileImageWrapper mt-3">
            <table class="table prodductTable">
                <thead>
                    <tr>
                        <th style="width: 40px">#</th>
                        <th style="width: 85px">تصویر</th>
                        <th style="min-width: 240px">نام محصول</th>
                        <th style="width: 240px">دسته بندی</th>
                        <th style="width: 180px">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <th style="width: 40px">{{ $key + 1 }}</th>
                            <td style="width: 85px"><img style="border-radius: 15px;"
                                    src="{{ asset($product->image ? $product->image : 'images/banner1.png') }}"
                                    alt="" class="img-fluid"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category ? $product->category->name : '' }}</td>
                            <th>
                                <a href="{{ route('panel.products.edit', $product->id) }}"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none">
                                        <g clip-path="url(#clip0_170_309)">
                                            <path
                                                d="M16.914 8.16406L11.8359 3.08594L2.06247 12.8633C1.80466 13.1211 1.61325 13.4414 1.51169 13.793L0.0390359 18.7969C-0.0586203 19.1289 0.0312234 19.4844 0.273411 19.7266C0.515598 19.9688 0.871067 20.0586 1.19919 19.9648L6.207 18.4922C6.55857 18.3906 6.87888 18.1992 7.13669 17.9414L16.914 8.16406Z"
                                                fill="#0A0E29" />
                                            <path opacity="0.4"
                                                d="M14.168 0.753906C15.1445 -0.222656 16.7266 -0.222656 17.7031 0.753906L19.2422 2.29297C20.2188 3.26953 20.2188 4.85156 19.2422 5.82812L16.9141 8.16406L11.8359 3.08594L14.168 0.753906Z"
                                                fill="#0A0E29" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_170_309">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg></a>
                                <form action="{{ route('panel.products.destroy', $product->id) }}" style="display: inline"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn deleteBtn"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="18" height="20" viewBox="0 0 18 20" fill="none">
                                            <g clip-path="url(#clip0_170_306)">
                                                <path
                                                    d="M6.39844 0C5.92578 0 5.49219 0.265625 5.28125 0.691406L5 1.25H1.25C0.558594 1.25 0 1.80859 0 2.5C0 3.19141 0.558594 3.75 1.25 3.75H16.25C16.9414 3.75 17.5 3.19141 17.5 2.5C17.5 1.80859 16.9414 1.25 16.25 1.25H12.5L12.2188 0.691406C12.0078 0.265625 11.5742 0 11.1016 0H6.39844Z"
                                                    fill="#0A0E29" />
                                                <path opacity="0.4"
                                                    d="M16.25 3.75H1.25V17.5C1.25 18.8789 2.37109 20 3.75 20H13.75C15.1289 20 16.25 18.8789 16.25 17.5V3.75ZM5.625 6.875V15.625C5.625 15.9688 5.34375 16.25 5 16.25C4.65625 16.25 4.375 15.9688 4.375 15.625V6.875C4.375 6.53125 4.65625 6.25 5 6.25C5.34375 6.25 5.625 6.53125 5.625 6.875ZM9.375 6.875V15.625C9.375 15.9688 9.09375 16.25 8.75 16.25C8.40625 16.25 8.125 15.9688 8.125 15.625V6.875C8.125 6.53125 8.40625 6.25 8.75 6.25C9.09375 6.25 9.375 6.53125 9.375 6.875ZM13.125 6.875V15.625C13.125 15.9688 12.8438 16.25 12.5 16.25C12.1562 16.25 11.875 15.9688 11.875 15.625V6.875C11.875 6.53125 12.1562 6.25 12.5 6.25C12.8438 6.25 13.125 6.53125 13.125 6.875Z"
                                                    fill="#0A0E29" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_170_306">
                                                    <rect width="17.5" height="20" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg></button>
                                </form>
                                <a target="_blank" href="{{url("fa/product/{$product->slug}")}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="23" viewBox="0 0 25 23"
                                         fill="none">
                                        <g clip-path="url(#clip0_170_312)">
                                            <path
                                                d="M9.72222 11.1111C11.2543 11.1111 12.5 9.86545 12.5 8.33333C12.5 8.02517 12.4479 7.73003 12.3568 7.45226C12.2786 7.21354 12.4262 6.93576 12.6779 6.94444C14.4488 7.01823 16.0417 8.22917 16.5234 10.0304C17.118 12.2526 15.7986 14.5399 13.5764 15.1345C11.3542 15.7292 9.06683 14.4097 8.47222 12.1875C8.38975 11.888 8.34635 11.5842 8.33333 11.2891C8.32031 11.0373 8.59808 10.8898 8.84114 10.9679C9.11892 11.059 9.41406 11.1111 9.72222 11.1111Z"
                                                fill="#0A0E29" />
                                            <path opacity="0.4"
                                                  d="M4.14064 4.88715C6.18491 2.98611 8.99307 1.38889 12.5 1.38889C16.007 1.38889 18.8151 2.98611 20.8594 4.88715C22.8906 6.77517 24.2491 9.02777 24.8958 10.5773C25.0391 10.9201 25.0391 11.3021 24.8958 11.645C24.2491 13.1944 22.8906 15.4514 20.8594 17.3351C18.8151 19.2361 16.007 20.8333 12.5 20.8333C8.99307 20.8333 6.18491 19.2361 4.14064 17.3351C2.10939 15.4514 0.750882 13.1944 0.108521 11.645C-0.0347087 11.3021 -0.0347087 10.9201 0.108521 10.5773C0.750882 9.02777 2.10939 6.77083 4.14064 4.88715ZM12.5 17.3611C14.1576 17.3611 15.7473 16.7026 16.9194 15.5305C18.0915 14.3584 18.75 12.7687 18.75 11.1111C18.75 9.4535 18.0915 7.86379 16.9194 6.69169C15.7473 5.51959 14.1576 4.86111 12.5 4.86111C10.8424 4.86111 9.2527 5.51959 8.0806 6.69169C6.90849 7.86379 6.25001 9.4535 6.25001 11.1111C6.25001 12.7687 6.90849 14.3584 8.0806 15.5305C9.2527 16.7026 10.8424 17.3611 12.5 17.3611Z"
                                                  fill="#0A0E29" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_170_312">
                                                <rect width="25" height="22.2222" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </th>
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
