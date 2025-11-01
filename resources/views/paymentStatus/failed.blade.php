<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Status Page</title>
    <link rel="stylesheet" href="{{ asset('assets/fonts/styles-fa-num/iran-sans.css') }}">
    <style>
        body {
            direction: rtl;
        }

        button {
            font-size: 18px;
            padding: 15px 30px;
            cursor: pointer;
        }

        * {
            font-family: "main-font";
        }

        .statusHeader {
            font-weight: 500;
            font-style: Medium;
            font-size: 16px;
            line-height: 100%;
            letter-spacing: 0%;
            text-align: center;
        }

        .statusImageWrapper {
            text-align: center;
            margin-top: 45px;
        }

        .statusTextWrapper {
            margin-top: 20px;
        }

        .statusDescription {
            font-weight: 400;
            font-size: 12px;
            line-height: 100%;
            letter-spacing: 0%;
            text-align: center;
            margin-top: 16px;
        }

        .statusBtnWrapper {
            margin-top: 100px;
            text-align: center;
        }

        .statusBtn {
            width: 288;
            height: 44;
            opacity: 1;
            border-radius: 8px;
            padding-top: 2px;
            padding-bottom: 2px;
            gap: 10px;
            background-color: #BE2124;
            padding: 11px 82.5px;
            font-weight: 500;
            font-style: Medium;
            font-size: 13px;
            line-height: 100%;
            letter-spacing: 0%;
            text-align: center;
            color: #fbfbfb;
            text-decoration: none;
        }


        @media screen and (min-width: 768px) {
            .statusImageWrapper {
                margin-top: 178px;
            }

            .statusTextWrapper {
                margin-top: 80px;
            }

            .statusHeader {
                font-size: 32px;
            }

            .statusDescription {
                font-size: 24px;
                margin-top: 37px;
            }

            .statusBtnWrapper {
                margin-top: 148px;
            }

            .statusBtn {
                width: 472;
                height: 55;
                padding-top: 8px;
                padding-bottom: 8px;
                font-weight: 700;
                font-style: Bold;
                font-size: 23px;
            }
        }
    </style>
</head>

<body>
    <div class="statusImageWrapper">
        <svg width="210" height="210" viewBox="0 0 210 210" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="210" height="210" rx="105" fill="#F9E8E8" />
            <rect x="15" y="15" width="180" height="180" rx="90" fill="#F3D3D4" />
            <rect x="30" y="30" width="150" height="150" rx="75" fill="#EFC2C3" />
            <rect x="45" y="45" width="120" height="120" rx="60" fill="#BE2124" />
            <path
                d="M120.721 117.404C121.161 117.845 121.409 118.442 121.409 119.064C121.409 119.687 121.161 120.284 120.721 120.725C120.281 121.165 119.683 121.412 119.061 121.412C118.438 121.412 117.841 121.165 117.401 120.725L105 108.32L92.5959 120.721C92.1556 121.161 91.5584 121.408 90.9357 121.408C90.313 121.408 89.7159 121.161 89.2756 120.721C88.8352 120.28 88.5879 119.683 88.5879 119.06C88.5879 118.438 88.8352 117.841 89.2756 117.4L101.68 105L89.2795 92.5956C88.8392 92.1553 88.5918 91.5581 88.5918 90.9355C88.5918 90.3128 88.8392 89.7156 89.2795 89.2753C89.7198 88.835 90.3169 88.5876 90.9396 88.5876C91.5623 88.5876 92.1595 88.835 92.5998 89.2753L105 101.68L117.404 89.2734C117.845 88.8331 118.442 88.5857 119.065 88.5857C119.687 88.5857 120.284 88.8331 120.725 89.2734C121.165 89.7137 121.412 90.3108 121.412 90.9335C121.412 91.5562 121.165 92.1534 120.725 92.5937L108.32 105L120.721 117.404Z"
                fill="#FBFBFB" />
        </svg>
    </div>
    <div class="statusTextWrapper">
        <p class="statusHeader">پرداخت شما با مشکل مواجه شد !</p>
        <p class="statusDescription">در صورتی که مبلغی از حساب شما کسر شده باشد تا 24 ساعت آینده به حساب شما برگشت داده خواهد شد.</p>
    </div>
    <div class="statusBtnWrapper">
        <a class="statusBtn" href="https://sanatyariran.com">بازگشت به صفحه اصلی</a>
    </div>
</body>
<script></script>

</html>
