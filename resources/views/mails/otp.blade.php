<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>OTP Code</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet"/>
</head>
<body style="
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      font-size: 14px;
      {{ in_array(app()->getLocale(), ['fa-IR', 'ar-SA']) ? 'direction: rtl;' : 'direction: ltr;' }}
    ">
<div style="
        max-width: 680px;
        margin: 0 auto;
        padding: 45px 30px 60px;
        background-size: 800px 452px;
        background: #f4f7ff url(https://app.sanatyariran.com/images/email/email-banner.png) no-repeat top center;
        font-size: 14px;
        color: #434343;
      ">
    <header>
        <table style="width: 100%;">
            <tbody>
            <tr style="height: 0;">
                <td>
                    <a href="https://sanatyariran.com" target="_blank"
                       style="text-decoration: none; font-weight: bold; color: #ffffff; font-size: 32px;">
                        @if($freezone)
                            {{ __('email.freezone-title') }}
                        @else
                            {{ __('email.main-title') }}
                        @endif
                    </a>
                </td>
                <td style="text-align: end;">
                    <span style="font-size: 16px; line-height: 30px; color: #ffffff;">
                        @if(app()->getLocale() === 'fa-IR')
                            {{ \Morilog\Jalali\CalendarUtils::convertNumbers(jdate()->format('d F Y')) }}
                        @else
                            {{ now()->format('d F Y') }}
                        @endif
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
    </header>

    <main>
        <div style="
            margin: 70px 0 0;
            padding: 92px 30px 115px;
            background: #ffffff;
            border-radius: 30px;
            text-align: center;
          ">
            <div style="width: 100%; max-width: 489px; margin: 0 auto;">
                <h1 style="
                margin: 0;
                font-size: 24px;
                font-weight: 500;
                color: #1f1f1f;
              ">
                    {{ __('email.otp-code') }}
                </h1>
                <p style="
                margin: 17px 0 0;
                font-weight: 500;
              ">
                    @if($codeType && $codeType === 'login')
                        {{ __('email.login-msg') }}
                    @else
                        {{ __('email.register-msg') }}
                    @endif
                </p>
                <p style="
                margin: 60px 0 0;
                font-size: 40px;
                font-weight: 600;
                letter-spacing: 25px;
                color: #ba3d4f;
              ">
                    {{ $code }}
                </p>
            </div>
        </div>
    </main>
    <footer style="
          width: 100%;
          max-width: 490px;
          margin: 20px auto 0;
          text-align: center;
          border-top: 1px solid #e6ebf1;
        ">
        <p style="
            margin: 0;
            margin-top: 40px;
            font-size: 16px;
            font-weight: 600;
            color: #434343;
          ">
            {{ __('email.address') }}
        </p>
        <p style="margin: 8px 0 0;color: #434343;">
            {{ __('email.address-info') }}
        </p>
        <div style="margin: 16px 0 0;">
            <p style="
              margin: 40px 0 0;
              font-size: 16px;
              font-weight: 600;
              color: #434343;
            ">
                {{ __('email.phones') }}
            </p>
            <div>
                <a href="tel:09120220863" target="_blank" style="display: inline-block; margin-left: 8px;">
                    09120220863
                </a>
                <a href="tel:90000790" target="_blank" style="display: inline-block; margin-left: 8px;">
                    90000790
                </a>
                <a href="tel:09120220862" target="_blank" style="display: inline-block;">
                    09120220862
                </a>
            </div>
        </div>
        <div style="margin: 16px 0 0;">
            <a href="https://www.instagram.com/sanatyariran_com/" target="_blank"
               style="display: inline-block; margin-left: 8px;">
                <img width="36px" alt="Instagram" src="https://app.sanatyariran.com/images/email/instagram.png"/></a>
            <a href="https://www.linkedin.com/company/sanatyar-iran" target="_blank"
               style="display: inline-block; margin-left: 8px;">
                <img width="36px" alt="Linkedin" src="https://app.sanatyariran.com/images/email/linkedin.png"/>
            </a>
            <a href="https://t.me/+989120220863" target="_blank" style="display: inline-block; margin-left: 8px;">
                <img width="36px" alt="Telegram"
                     src="https://app.sanatyariran.com/images/email/telegram.png"/>
            </a>
        </div>
        <p style="margin: 16px 0 0;color: #434343;">
            {{ __('email.copyright') }}
        </p>
    </footer>
</div>
</body>

</html>
