<div>
    @if ($status == 'phone')
        <img src="{{ asset('images/logo.png') }}" class="auth-logo" alt="">
        <h1 class="authTitle">ورود</h1>
        <p>شماره همراه خود را به صورت کامل وارد کنید.</p>
        <form wire:submit="save" id="phoneForm" autocomplete="off">
            <div class="mt-5 isy-form-group isy-form-country">
                <input class="isy-input" id="country" type="text" placeholder="ایران" disabled>
                <label class="isy-float-label" for="country">کشور</label>
                <span class="isy-select-arrow"><i class="bi bi-chevron-down"></i></span>
            </div>
            <div class="input-group isy-form-group mt-3">
                <span class="areaCode">+98</span>
                <input wire:model="phone" type="number" class="isy-input" @error('phone') style="border:2px solid red;" @enderror
                    id="phone" maxLength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="912 999 9999">
                <label class="isy-float-label @error('phone') text-danger @enderror" for="phone">
                    @if ($errors->has('phone'))
                        {{ $errors->first('phone') }}
                    @else
                        شماره همراه
                    @endif
                </label>
            </div>
            <div class="mt-3">
                <button type="submit" style="max-width: 360px; background: #032049; color: #fff;"
                    class="w-100 btn btn-lg">
                    <span wire:loading class="spinner-border spinner-border-sm" style="display: none;"
                        aria-hidden="true"></span>
                    دریافت رمز
                </button>
            </div>
        </form>
    @elseif($status == 'code')
        <img src="{{ asset('images/logo.png') }}" class="auth-logo" alt="">
        <h1 class="authTitle" style="direction: ltr;">{!! substr($phone, 0, 4) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7, 4) !!}
            <a href="" class="isy-phone-edit">
                <i class="bi bi-pencil" style="font-size: 20px;"></i>
            </a>
        </h1>
        <p> پیامکی حاوی رمز عبور برای شما پیامک شد.</p>
        <form wire:submit="checkCode" id="getCode" autocomplete="off">
            <div class="input-group isy-form-group mt-3">
                <input wire:model="userCode" onkeyup="codeCheck()" name="code" type="text text-center"
                    style="text-align: center;" class="isy-input" id="code" maxlength="6" required autofocus>
                <label class="isy-float-label" for="code">کد پیامک شده</label>
                <div class="mt-3 w-100" x-data="appFooterComponent()" x-init="init()">
                    <p class="text-center" id="timerWrapper">زمان باقی‌مانده : <span x-text="getTime()"></span> ثانیه
                    </p>
                    <p class="text-primary" id="resetCodeBtn" x-on:click="[$wire.triedHandler() , resetTimer()]"
                        style="display:none;cursor: pointer;">ارسال مجدد رمز عبور</p>
                    <button style="max-width: 360px; background: #032049; color: #fff;" class="w-100 btn btn-lg"
                        id="codeBtn">
                        <span wire:loading class="spinner-border spinner-border-sm" style="display: none;"
                            aria-hidden="true"></span>
                        ورود
                    </button>
                </div>
            </div>
        </form>
    @elseif($status == 'register')
        <img src="{{ asset('images/logo.png') }}" class="auth-logo" alt="">
        <h1 class="authTitle" style="direction: ltr;">
            ثبت نام
        </h1>
        <p>برای تکمیل ثبت نام، مشخصات فردی خود را وارد کنید.</p>
        <form wire:submit="register" id="register" autocomplete="off">
            <div class="input-group isy-form-group mt-3">
                <input wire:model="firstName" name="first_name" id="first_name" type="text text-center"
                    class="isy-input" maxlength="50" autofocus required>
                <label class="isy-float-label" for="first_name">نام</label>
            </div>
            <div class="input-group isy-form-group mt-3">
                <input wire:model="lastName" name="last_name" id="last_name" type="text text-center" class="isy-input"
                    maxlength="50" required>
                <label class="isy-float-label" for="last_name">نام خانوادگی</label>
            </div>
            <div class="input-group isy-form-group mt-3">
                <input wire:model="identificationCode" name="identificationCode" id="identificationCode"
                    type="text text-center" class="isy-input" maxlength="50">
                <label class="isy-float-label" for="last_name">کد معرف (اختیاری) :</label>
            </div>
            <div class="mt-3">
                <button type="submit" style="max-width: 360px; background: #032049; color: #fff;"
                    class="w-100 btn btn-lg">
                    <span wire:loading class="spinner-border spinner-border-sm" style="display: none;"
                        aria-hidden="true"></span>
                    تکمیل ثبت نام
                </button>
            </div>
        </form>
    @endif

    @if ($errorMsg)
        <p class="text-danger">{{ $errorMsg }}</p>
    @endif
</div>

<script>
    function appFooterComponent() {
        return {
            time: 120,
            init() {
                setInterval(() => {
                    if (this.time > 0) {
                        this.time = this.time - 0.5;
                    } else {
                        document.getElementById('timerWrapper').style.display = 'none';
                        document.getElementById('resetCodeBtn').style.display = 'block';
                    }
                }, 1000);
            },
            getTime() {
                return this.time;
            },
            resetTimer() {
                this.time = 120;
                document.getElementById('timerWrapper').style.display = 'block';
                document.getElementById('resetCodeBtn').style.display = 'none';
            },
        }
    }
</script>
