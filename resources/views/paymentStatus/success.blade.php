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
            background-color: #21BE79;
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
            <rect width="210" height="210" rx="105" fill="#E8F9F1" />
            <rect x="15" y="15" width="180" height="180" rx="90" fill="#D3F3E4" />
            <rect x="30" y="30" width="150" height="150" rx="75" fill="#C2EFDA" />
            <rect x="45" y="45" width="120" height="120" rx="60" fill="#21BE79" />
            <path
                d="M127.521 97.7559L102.443 122.834C101.857 123.42 101.062 123.749 100.234 123.749C99.4055 123.749 98.6109 123.42 98.0249 122.834L84.0366 108.772C83.4516 108.186 83.123 107.391 83.123 106.563C83.123 105.736 83.4516 104.941 84.0366 104.355L87.9429 100.449C88.5286 99.866 89.3214 99.5386 90.148 99.5386C90.9745 99.5386 91.7674 99.866 92.353 100.449L100.312 108.168L119.21 89.502C119.796 88.9182 120.59 88.5903 121.417 88.5903C122.244 88.5903 123.037 88.9182 123.623 89.502L127.519 93.3184C127.812 93.6088 128.045 93.9543 128.204 94.335C128.362 94.7158 128.444 95.1242 128.444 95.5367C128.445 95.9493 128.363 96.3578 128.205 96.7386C128.046 97.1195 127.814 97.4652 127.521 97.7559Z"
                fill="#FBFBFB" />
        </svg>
    </div>
    <div class="statusTextWrapper">
        <p class="statusHeader">پرداخت شما با موفقیت انجام شد.</p>
        <p class="statusDescription">از اعتماد شما مچکریم</p>
    </div>
    <div class="statusBtnWrapper">
        <a class="statusBtn" href="https://sanatyariran.com">بازگشت به صفحه اصلی</a>
    </div>
</body>
<script></script>

</html>
