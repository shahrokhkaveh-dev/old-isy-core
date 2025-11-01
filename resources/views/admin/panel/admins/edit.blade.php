@extends('admin.panel.layout.master')
@section('content')
<div style="padding-top: 32px">
    <div class="d-flex justify-content-around main-record-boxes">
        <div class="bg-check-signup ">
            <div class="row m-0 mob-column-reverse">
                <div class="col-12 col-lg-7">
                    <form class="form-signup form-margin" action="{{ route('admin.admin.update' , ['id'=> encrypt($admin->id)]) }}" method="post" enctype="multipart/form-data" id="createAdminFrom">
                        @csrf
                        @method('put')
                        <div class="d-flex justify-content-between">
                            <div>
                                <label>نام: </label>
                                <input type="text" name="fname" class="form-control disabled @error('fname') is-invalid @enderror" placeholder="نام ادمین" value="{{ old('fname' , $admin->fname) }}" maxlength="40">
                                @error('fname')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label>نام خانوادگی:</label>
                                <input type="text" name="lname" class="form-control disabled @error('lname') is-invalid @enderror" placeholder="نام خانوادگی مدیر" value="{{ old('lname', $admin->lname) }}" maxlength="40">
                                @error('lname')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <label>ایمیل:</label>
                                <input type="text" name="email" class="form-control disabled @error('email') is-invalid @enderror" placeholder="email@sanatyariran.com" value="{{ old('email', $admin->email) }}" maxlength="50">
                                @error('email')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label>شماره همراه</label>
                                <input type="text" name="phone" class="form-control disabled @error('phone') is-invalid @enderror" placeholder="09129999999" value="{{ old('phone', $admin->phone) }}" maxlength="11">
                                @error('phone')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <label>نام کاربری</label>
                                <input type="text" name="username" class="form-control disabled @error('username') is-invalid @enderror" placeholder="نام کاربری مدیر" value="{{ old('username' , $admin->username) }}" maxlength="20">
                                @error('username')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label>سطح دسترسی</label>
                                <select name="role" class="form-control " name="" id="">
                                    <option value="admin" @if(old('role' , $admin->role) == 'admin') selected @endif>ادمین</option>
                                </select>
                                @error('role')
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
                        <a href="{{ route('admin.admin.index') }}" class="btn btn-danger">
                            <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.12534 2.63932C0.25 3.84412 0.25 5.56275 0.25 9C0.25 12.4373 0.25 14.1559 1.12534 15.3607C1.40804 15.7498 1.75022 16.092 2.13932 16.3747C3.34412 17.25 5.06275 17.25 8.5 17.25C11.9373 17.25 13.6559 17.25 14.8607 16.3747C15.2498 16.092 15.592 15.7498 15.8747 15.3607C16.75 14.1559 16.75 12.4373 16.75 9C16.75 5.56275 16.75 3.84412 15.8747 2.63932C15.592 2.25022 15.2498 1.90804 14.8607 1.62534C13.6559 0.75 11.9373 0.75 8.5 0.75C5.06275 0.75 3.34412 0.75 2.13932 1.62534C1.75022 1.90804 1.40804 2.25022 1.12534 2.63932ZM7.04158 6.79174C6.77309 6.52326 6.33779 6.52326 6.0693 6.79174C5.80082 7.06023 5.80082 7.49553 6.0693 7.76402L7.52771 9.22242L6.0693 10.6808C5.80082 10.9493 5.80082 11.3846 6.0693 11.6531C6.33779 11.9216 6.77309 11.9216 7.04158 11.6531L8.49998 10.1947L9.95839 11.6531C10.2269 11.9216 10.6622 11.9216 10.9307 11.6531C11.1991 11.3846 11.1991 10.9493 10.9307 10.6808L9.47226 9.22242L10.9307 7.76402C11.1991 7.49553 11.1991 7.06023 10.9307 6.79174C10.6622 6.52326 10.2269 6.52326 9.95839 6.79174L8.49998 8.25015L7.04158 6.79174Z" fill="white"/>
                            </svg>

                            انصراف

                        </a>
                    </div>
                    <div class="bg-secondarys text-center">
                        <label form="form">
                            <img class="p-2" src="{{ asset($admin->image_url ?? 'admin-assets/panel-assets/img/avatar.png') }}" alt="" id="imageOutout">
                            <input type="file" class="d-none" form="createAdminFrom" name="image" accept="image/*" onchange="loadFile(event)">
                            @error('image')
                                    <span class="text-danger text-small">{{ $message }}</span>
                            @enderror
                        </label>
                        <div class="mt-3 btn-width ff p-2">
                            <div class="d-grid gap-2 col-12 ">
                                <button class="btn btn-primary" type="button">
                                    <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.18336 17L5.58336 17.6857C7.38336 20.7714 10.9834 20.7714 12.7834 17.6857L13.1834 17M1.36619 14.5496L1.46954 14.7627C2.13331 16.1311 3.52054 17 5.04144 17H13.2623C14.5656 17 15.7785 16.3342 16.4783 15.2347C17.4661 13.6826 17.2045 11.6465 15.8564 10.3945L15.8125 10.3538C14.8972 9.50376 14.4466 8.26543 14.6015 7.02598L14.6662 6.50905C15.0318 3.58379 12.7509 1 9.80286 1H8.09995C5.15552 1 2.87737 3.58064 3.24258 6.50234L3.32194 7.13719C3.46808 8.30631 3.04102 9.4741 2.17514 10.2731C0.99242 11.3645 0.663827 13.1016 1.36619 14.5496Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>

                                    ارسال اعلان به کاربر
                                </button>
                            </div>

                            <div class="d-grid gap-2 col-12 ">
                                <button class="btn btn-primary mt-3 w-100">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.5 0.25C13.0858 0.25 12.75 0.585786 12.75 1C12.75 1.41421 13.0858 1.75 13.5 1.75H14.5C16.8472 1.75 18.75 3.65279 18.75 6V7C18.75 7.41421 19.0858 7.75 19.5 7.75C19.9142 7.75 20.25 7.41421 20.25 7V6C20.25 2.82436 17.6756 0.25 14.5 0.25H13.5Z" fill="white"></path>
                                        <path d="M6.5 0.25C3.32436 0.25 0.75 2.82436 0.75 6V7C0.75 7.41421 1.08579 7.75 1.5 7.75C1.91421 7.75 2.25 7.41421 2.25 7V6C2.25 3.65279 4.15279 1.75 6.5 1.75H7.5C7.91421 1.75 8.25 1.41421 8.25 1C8.25 0.585787 7.91421 0.25 7.5 0.25H6.5Z" fill="white"></path>
                                        <path d="M10.5 7.25C8.98122 7.25 7.75 8.48122 7.75 10C7.75 11.5188 8.98122 12.75 10.5 12.75C12.0188 12.75 13.25 11.5188 13.25 10C13.25 8.48122 12.0188 7.25 10.5 7.25Z" fill="white"></path>
                                        <path d="M2.25 13C2.25 12.5858 1.91421 12.25 1.5 12.25C1.08579 12.25 0.75 12.5858 0.75 13V14C0.75 17.1756 3.32436 19.75 6.5 19.75H7.5C7.91422 19.75 8.25 19.4142 8.25 19C8.25 18.5858 7.91422 18.25 7.5 18.25H6.5C4.15279 18.25 2.25 16.3472 2.25 14V13Z" fill="white"></path>
                                        <path d="M20.25 13C20.25 12.5858 19.9142 12.25 19.5 12.25C19.0858 12.25 18.75 12.5858 18.75 13V14C18.75 16.3472 16.8472 18.25 14.5 18.25H13.5C13.0858 18.25 12.75 18.5858 12.75 19C12.75 19.4142 13.0858 19.75 13.5 19.75H14.5C17.6756 19.75 20.25 17.1756 20.25 14V13Z" fill="white"></path>
                                    </svg>

                                    ارسال لینک بازنشانی رمز
                                </button>

                            </div>
                            <div class="d-grid gap-2 col-12 ">
                                <button href="{{route('admin.admin.changeActivation' , ['id'=> $id ])}}" onclick="window.location = this.getAttribute('href')" class="btn btn-danger mt-3 w-100">
                                    <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.25 1C12.25 0.585786 11.9142 0.25 11.5 0.25C11.0858 0.25 10.75 0.585786 10.75 1V8C10.75 8.41421 11.0858 8.75 11.5 8.75C11.9142 8.75 12.25 8.41421 12.25 8V1Z" fill="white"></path>
                                        <path d="M5.95046 3.59966C6.28164 3.35087 6.34844 2.88072 6.09966 2.54954C5.85087 2.21836 5.38072 2.15156 5.04954 2.40034C2.44046 4.36028 0.75 7.48258 0.75 11C0.75 16.9371 5.56294 21.75 11.5 21.75C17.4371 21.75 22.25 16.9371 22.25 11C22.25 7.50873 20.5178 4.363 17.9555 2.40417C17.6264 2.1526 17.1557 2.21543 16.9042 2.5445C16.6526 2.87357 16.7154 3.34427 17.0445 3.59583C19.2627 5.29161 20.75 8.00913 20.75 11C20.75 16.1086 16.6086 20.25 11.5 20.25C6.39137 20.25 2.25 16.1086 2.25 11C2.25 7.97446 3.70215 5.28858 5.95046 3.59966Z" fill="white"></path>
                                    </svg>

                                    @if ($admin->is_active)
                                    مسدود کردن
                                    @else
                                    فعال کردن
                                    @endif
                                    </button>

                            </div>
                        </div>
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
