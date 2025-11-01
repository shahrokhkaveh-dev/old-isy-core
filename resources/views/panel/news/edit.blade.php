@extends('dashboard.layout.master')
@section('head')
    <title>افزودن محصول یا خدمت</title>
    <link href="{{ asset('assets/plugins/select2@4.1.0/select2min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <header class="d-flex" style="justify-content: space-between">
        <h1>
            ویرایش {{ $product->name }}
        </h1>
        <button class="actionBtn" form="addProduct">
            ثبت
        </button>
    </header>
    <section class="content">
        <div class="container">
            <form action="{{ route('panel.product.store') }}" id="addProduct" method="post" enctype="multipart/form-data"
                class="addProductForm">
                @csrf
                <div class="row input-row">
                    <div class="col-12">
                        <input type="text" class="isy-input" placeholder="نام محصول یا خدمت :" name="name"
                            value="{{ old('name', $product->name) }}">
                    </div>
                </div>
                <div class="row input-row">
                    <div class="col-12">
                        <input type="text" class="isy-input"
                            placeholder="توضیح اجمالی برای نمایش بهتر در گوگل (در سایت نمایش داده نمی‌شود)  : "
                            name="excerpt" value="{{ old('excerpt', $product->excerpt) }}">
                    </div>
                </div>
                <div class="row input-row" style="margin-top:40px; font-size:14px;">
                    <div class="col-6">
                        <p>توضیح محصول یا خدمت :</p>
                    </div>
                    <div class="col-6">
                        <label class="form-check-label" for="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 80 80"
                                fill="none" style="margin-left: 10px">
                                <g filter="url(#filter0_d_172_14)">
                                    <path
                                        d="M40 18L43.7082 26.5873L51.7557 21.8197L49.7082 30.9466L59.0211 31.8197L52 38L59.0211 44.1803L49.7082 45.0534L51.7557 54.1803L43.7082 49.4127L40 58L36.2918 49.4127L28.2443 54.1803L30.2918 45.0534L20.9789 44.1803L28 38L20.9789 31.8197L30.2918 30.9466L28.2443 21.8197L36.2918 26.5873L40 18Z"
                                        fill="url(#paint0_radial_172_14)" shape-rendering="crispEdges" />
                                    <path
                                        d="M43.2492 26.7855L43.9631 27.0175L51.0144 22.84L49.2203 30.8371L49.6615 31.4444L57.8216 32.2094L51.6696 37.6247V38.3753L57.8216 43.7906L49.6615 44.5556L49.2203 45.1629L51.0144 53.16L43.9631 48.9825L43.2492 49.2145L40 56.7388L36.7508 49.2145L36.0369 48.9825L28.9856 53.16L30.7797 45.1629L30.3385 44.5556L22.1784 43.7906L28.3304 38.3753V37.6247L22.1784 32.2094L30.3385 31.4444L30.7797 30.8371L28.9856 22.84L36.0369 27.0175L36.7508 26.7855L40 19.2612L43.2492 26.7855Z"
                                        stroke="url(#paint1_linear_172_14)" stroke-linejoin="bevel"
                                        shape-rendering="crispEdges" />
                                </g>
                                <defs>
                                    <filter id="filter0_d_172_14" x="0.978882" y="0" width="78.0422" height="80"
                                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                        <feColorMatrix in="SourceAlpha" type="matrix"
                                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                        <feOffset dy="2" />
                                        <feGaussianBlur stdDeviation="10" />
                                        <feComposite in2="hardAlpha" operator="out" />
                                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
                                        <feBlend mode="normal" in2="BackgroundImageFix"
                                            result="effect1_dropShadow_172_14" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_172_14"
                                            result="shape" />
                                    </filter>
                                    <radialGradient id="paint0_radial_172_14" cx="0" cy="0" r="1"
                                        gradientUnits="userSpaceOnUse"
                                        gradientTransform="translate(40 38) rotate(90) scale(20)">
                                        <stop stop-color="#FAFF00" stop-opacity="0.76" />
                                        <stop offset="1" stop-color="#FF7502" />
                                    </radialGradient>
                                    <linearGradient id="paint1_linear_172_14" x1="40" y1="19.1429" x2="40"
                                        y2="37.4286" gradientUnits="userSpaceOnUse">
                                        <stop offset="0.204757" stop-color="#FAFF00" stop-opacity="0.64" />
                                        <stop offset="1" stop-color="#FF7502" stop-opacity="0.37" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            آیا محصول صادراتی است؟
                        </label>
                        <input class="" type="checkbox" value="" id="" name="isExportable"
                            style="
                        vertical-align: middle;
width: 25px;
height: 25px;border-radius: 5px;
                        background: rgba(10, 14, 41, 0.50);
                        box-shadow: -4px 4px 20px 0px rgba(0, 0, 0, 0.20);
                        margin:0 20px 0 0;"
                            @if ($product->isExportable) checked @endif>

                    </div>
                    <div class="col-12">
                        <textarea name="description" id="description" cols="30" rows="10">{{ old('description', $product->description) ? old('description', $product->description) : '' }}</textarea>
                    </div>
                </div>
                <div class="row input-row" style="margin-top:20px;">
                    <div class="col-6">
                        <div class="d-flex" style="justify-content: space-between">
                            <p style="width: calc(100% - 195px);padding-top: 10px">ویژگی ها :</p>
                            <button type="button" class="btn text-light addProductAttributeBtn"
                                id="addProductAttributeBtn">
                                <i class="bi bi-plus">
                                    <span">افزودن
                                        ویژگی</span>
                                </i>
                            </button>
                        </div>
                        <input type="text" id="attributeKey" placeholder="نام ویژگی : (مثلا رنگ)">
                        <textarea id="attributeValue">مقدار ویژگی : (مثلا قرمز)</textarea>
                    </div>
                    <div class="col-3">
                        <div class="attributeContainer">

                            @php
                                $attrCount = 0;
                                foreach ($product->attributes as $key => $attributes) {
                                    echo '<input class="d-none ' .
                                        $attributes->id .
                                        '" name="key[' .
                                        $attributes->id .
                                        ']" value=' .
                                        $attributes->name .
                                        '>';
                                    echo '<input class="d-none ' .
                                        $attributes->id .
                                        '" name="value[' .
                                        $attributes->id .
                                        ']" value=' .
                                        $attributes->value .
                                        '>';
                                    echo '<span class="attrTag ' .
                                        $attributes->id .
                                        '" onClick="deleteAttr(' .
                                        $attributes->id .
                                        ')">' .
                                        $attributes->name .
                                        ' : ' .
                                        $attributes->value .
                                        '</span>';
                                    $attrCount++;
                                }
                            @endphp
                        </div>
                    </div>
                    <div class="col-3">
                        <select value="{{ old('category_id') }}">
                            <option value="">دسته بندی</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($product->category_id == $category->id) selected @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        <input type="file" placeholder="عکس" name="image" id="image" accept="image/*"
                            style="padding-top: 20px">
                        <div id="img-preview">
                            <img src="{{ asset($product->image) }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="row input-row">
                </div>
        </div>
        </form>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/select2@4.1.0/select2.min.js') }}"></script>
    <script>
        getImgData = function() {
            const files = chooseFile.files[0];
            if (files) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(files);
                fileReader.addEventListener("load", function() {
                    imgPreview.style.display = "block";
                    imgPreview.innerHTML = '<img src="' + this.result + '" class="img-fluid"/>';
                });
            }
        }
        const chooseFile = document.getElementById("image");
        const imgPreview = document.getElementById("img-preview");
        chooseFile.addEventListener("change", function() {
            getImgData();
        });
    </script>

    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description', {
            uiColor: '#EBEBEB',
            removeButtons: 'PasteFromWord'
        });
    </script>
    <script>
        $('form input').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });
    </script>
    <script>
        var attrId = {{ $attrCount + 1 }};
        $('#addProductAttributeBtn').click(function() {
            var key = $('#attributeKey').val();
            var value = $('#attributeValue').val();
            if (!key || !value || value == "مقدار ویژگی : (مثلا قرمز)") {
                Swal.fire('مقادیر خواسته شده را وارد نمایید', '', 'error');
            } else {
                htmlString = "<input class='d-none " + attrId + "' name='key[" + attrId + "]' value='" + key +
                    "'>" +
                    "<input class='d-none " + attrId + "' name='value[" + attrId + "]' value='" + value + "'>";
                $('#addProduct').append(htmlString);
                tagString = "<span class='attrTag " + attrId + "' onClick='deleteAttr(" + attrId + ")'>" + key +
                    " : " + value + "</span>"
                $('.attributeContainer').append(tagString);
                attrId++;
                $('#attributeKey').val('');
                $('#attributeValue').val('مقدار ویژگی : (مثلا قرمز)');
            }
        });
    </script>
    <script>
        deleteAttr = function(id) {
            $('.' + id).remove();
        }
    </script>
@endsection
