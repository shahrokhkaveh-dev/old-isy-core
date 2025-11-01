@extends('admin.panel.layout.master')
@section('content')
<div style="padding-top: 32px">
    <div class="d-flex justify-content-around main-record-boxes">
        <div class="bg-check-signup ">
            <div class="row m-0 mob-column-reverse">
                <div class="col-12 col-lg-7">
                    <form class="form-signup form-margin" action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data" id="createAdminFrom">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <div>
                                <label>نام: </label>
                                <input type="text" name="fname" class="form-control disabled @error('fname') is-invalid @enderror" placeholder="نام کاربر" value="{{ old('fname') }}" maxlength="40">
                                @error('fname')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label>نام خانوادگی:</label>
                                <input type="text" name="lname" class="form-control disabled @error('lname') is-invalid @enderror" placeholder="نام خانوادگی کاربر" value="{{ old('lname') }}" maxlength="40">
                                @error('lname')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <label>ایمیل:</label>
                                <input type="text" name="email" class="form-control disabled @error('email') is-invalid @enderror" placeholder="email@sanatyariran.com" value="{{ old('email') }}" maxlength="50">
                                @error('email')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label>شماره همراه</label>
                                <input type="text" name="phone" class="form-control disabled @error('phone') is-invalid @enderror" placeholder="09129999999" value="{{ old('phone') }}" maxlength="11">
                                @error('phone')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <label>شرکت</label>
                                <select class="form-control" id="company_search" placeholder=" نام شرکت"
                                        name="brand_id">
                                </select>
                            </div>
                            <div>
                                <label>وضعیت</label>
                                <select class="form-control " name="status" id="">
                                    <option value="1" selected>ثبت نام شده</option>
                                    <option value="2">پرداخت کرده</option>
                                    <option value="3">مدارک بارگزاری شده</option>
                                    <option value="4">تکمیل ثبت نام</option>
                                </select>
                                @error('status')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <label>تعیین رمز عبور</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" minlength="8">
                                @error('password')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label>تکرار رمز</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" minlength="8">
                                @error('password_confirmation')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </form>
                </div>
                <div class="col-12 col-lg-5 left-index3-2" style="padding-top: 40px;">
                    <div class="top-acc d-flex align-items-center align-content-center justify-content-around">
                        <button class="btn btn-primary" form="createAdminFrom" type="submit">
                            <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.12534 2.63932C0.25 3.84412 0.25 5.56275 0.25 9C0.25 12.4373 0.25 14.1559 1.12534 15.3607C1.40804 15.7498 1.75022 16.092 2.13932 16.3747C3.34412 17.25 5.06275 17.25 8.5 17.25C11.9373 17.25 13.6559 17.25 14.8607 16.3747C15.2498 16.092 15.592 15.7498 15.8747 15.3607C16.75 14.1559 16.75 12.4373 16.75 9C16.75 5.56275 16.75 3.84412 15.8747 2.63932C15.592 2.25022 15.2498 1.90804 14.8607 1.62534C13.6559 0.75 11.9373 0.75 8.5 0.75C5.06275 0.75 3.34412 0.75 2.13932 1.62534C1.75022 1.90804 1.40804 2.25022 1.12534 2.63932ZM13.5955 6.70858C13.8488 6.4257 13.8248 5.99106 13.5419 5.73779C13.259 5.48452 12.8244 5.50853 12.5711 5.79142L9.48271 9.241C8.85691 9.93999 8.43546 10.4083 8.07514 10.7111C7.73189 10.9996 7.53029 11.0625 7.35417 11.0625C7.17805 11.0625 6.97644 10.9996 6.63319 10.7111C6.27287 10.4082 5.85142 9.93999 5.22562 9.241L4.42888 8.35108C4.17561 8.0682 3.74097 8.04419 3.45808 8.29746C3.1752 8.55072 3.15119 8.98536 3.40446 9.26825L4.23523 10.1962C4.81809 10.8472 5.30427 11.3903 5.74849 11.7637C6.21841 12.1587 6.72527 12.4375 7.35417 12.4375C7.98307 12.4375 8.48993 12.1587 8.95984 11.7637C9.40407 11.3903 9.89023 10.8473 10.4731 10.1962L13.5955 6.70858Z" fill="white"/>
                            </svg>

                            ذخیره
                        </button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-danger">
                            <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.12534 2.63932C0.25 3.84412 0.25 5.56275 0.25 9C0.25 12.4373 0.25 14.1559 1.12534 15.3607C1.40804 15.7498 1.75022 16.092 2.13932 16.3747C3.34412 17.25 5.06275 17.25 8.5 17.25C11.9373 17.25 13.6559 17.25 14.8607 16.3747C15.2498 16.092 15.592 15.7498 15.8747 15.3607C16.75 14.1559 16.75 12.4373 16.75 9C16.75 5.56275 16.75 3.84412 15.8747 2.63932C15.592 2.25022 15.2498 1.90804 14.8607 1.62534C13.6559 0.75 11.9373 0.75 8.5 0.75C5.06275 0.75 3.34412 0.75 2.13932 1.62534C1.75022 1.90804 1.40804 2.25022 1.12534 2.63932ZM7.04158 6.79174C6.77309 6.52326 6.33779 6.52326 6.0693 6.79174C5.80082 7.06023 5.80082 7.49553 6.0693 7.76402L7.52771 9.22242L6.0693 10.6808C5.80082 10.9493 5.80082 11.3846 6.0693 11.6531C6.33779 11.9216 6.77309 11.9216 7.04158 11.6531L8.49998 10.1947L9.95839 11.6531C10.2269 11.9216 10.6622 11.9216 10.9307 11.6531C11.1991 11.3846 11.1991 10.9493 10.9307 10.6808L9.47226 9.22242L10.9307 7.76402C11.1991 7.49553 11.1991 7.06023 10.9307 6.79174C10.6622 6.52326 10.2269 6.52326 9.95839 6.79174L8.49998 8.25015L7.04158 6.79174Z" fill="white"/>
                            </svg>

                            انصراف

                        </a>
                    </div>
                    <div class="bg-secondarys text-center">
                        <label form="form">
                            <img class="p-2" src="{{ asset('admin-assets/panel-assets/img/avatar.png') }}" alt="" id="imageOutout">
                            <input type="file" class="d-none" form="createAdminFrom" name="image" accept="image/*" onchange="loadFile(event)">
                            @error('image')
                                    <span class="text-danger text-small">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var loadFile = function(event) {
    var output = document.getElementById('imageOutout');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>
@endsection
