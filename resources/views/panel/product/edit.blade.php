@extends('panel.layout.master')
@section('head')
    <title>ویرایش محصول یا خدمت</title>
    <link href="{{ asset('assets/plugins/select2@4.1.0/select2min.css') }}" rel="stylesheet"/>
    <style>
        .select2-selection {
            height: 38px !important;
            padding-top: 4px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 5px !important;
            display: block;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 6px !important;
        }

        .ck.ck-word-count {
            display: none;
        }
    </style>
@endsection
@section('content')
    <header class="d-flex justify-content-between">
        <h3 class="text-start mt-5">ویرایش محصول یا خدمت</h3>
        <button href="{{ route('panel.products.create') }}" class="btn btn-add mt-5" form="addProduct">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.8332 10.8317H10.8332V15.8317H9.1665V10.8317H4.1665V9.16499H9.1665V4.16499H10.8332V9.16499H15.8332V10.8317Z"
                    fill="#0FA958"></path>
            </svg>
            ثبت
        </button>
    </header>
    <section class="content">
        <div class="container">
            <form action="{{ route('panel.products.update', $product->id) }}" id="addProduct" method="post"
                enctype="multipart/form-data" class="addProductForm">
                @csrf
                @method('put')
                <div class="row mt-4">
                    <div class="col-12 col-md-7 mt-3">
                        <div>
                            <label class="form-label " for="name">نام محصول :</label>
                            <input type="text" class="form-control" placeholder="نام محصول را وارد کنید" id="name"
                                name="name" value="{{ old('name', $product->name) }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-5 mt-3">
                        <div>
                            <label class="form-label " for="isExportable">وضعیت صادرات</label>
                            <select class="form-select" id="isExportable" name="isExportable">
                                <option @if (old('isExportable', $product->isExportable) == false) selected @endif value="false">قابلیت صادرات ندارد
                                </option>
                                <option @if (old('isExportable', $product->isExportable) == true) selected @endif value="true">قابلیت صادرات دارد
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12 col-md-7 mt-3">
                        <div class="mt-3">
                            <label class="form-label " for="category_id">دسته بندی</label>
                            <select class="form-select" id="category_id" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if (old('category_id', $product->category_id) && old('category_id', $product->category_id) == $category->id) selected @endif>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-12 col-md-5 mt-3">
                        <div class="mt-3">
                            <label class="form-label " for="HSCode">شناسه HS :</label>
                            <input type="text" class="form-control" placeholder="شناسه HS را وارد کنید" id="HSCode"
                                name="HSCode" value="{{ old('HSCode') }}">
                        </div>
                    </div> --}}
                </div>
                <div class="row input-row" style="margin-top:40px; font-size:14px;">
                    <div class="col-12">
                        <p>توضیح محصول یا خدمت :</p>
                        <div id="editorWrapper">
                            <textarea class="form-control" name="description" id="description" maxlength="15">{!! $product->description !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row input-row" style="margin-top:20px;">
                    <div class="col-6">
                        <div class="d-flex" style="justify-content: space-between">
                            <p style="width: calc(100% - 195px);padding-top: 10px">ویژگی ها :</p>
                            <button type="button" class="btn btn-add" id="addProductAttributeBtn">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.8332 10.8317H10.8332V15.8317H9.1665V10.8317H4.1665V9.16499H9.1665V4.16499H10.8332V9.16499H15.8332V10.8317Z"
                                        fill="#0FA958"></path>
                                </svg>
                                افزودن
                                ویژگی
                            </button>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control d-inline-block" id="attributeKey"
                                style="width: 49% !important;" placeholder="نام ویژگی : (مثلا رنگ)" />
                            <input type="text" class="form-control d-inline-block" id="attributeValue"
                                style="width: 49% !important;" placeholder="مقدار ویژگی : (مثلا قرمز)" />
                        </div>
                        <div class="attributeContainer mt-3">
                            @foreach ($attributes as $key => $attr)
                                <span class='attrTag " + attrId + "'
                                    onClick='deleteAttr("{{ $key + 1 }}")'>{{ "{$attr->name} : {$attr->value}" }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-5">
                        <label for="image">
                            <div class="form-label btn btn-add">
                                <i class="bi bi-upload" style="color: #1dae61;"></i>
                                آپلود عکس محصول
                            </div>
                        </label>
                        <input type="file" class="d-none" placeholder="عکس" name="image" id="image"
                            accept="image/*" style="padding-top: 20px">
                        <div id="img-preview">
                            <img src="{{ asset($product->image) }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="row input-row">
                </div>
                @foreach ($attributes as $key => $attr)
                    <input class='{{ 'd-none ' . ($key + 1) }}' name='{{ 'key[' . ($key + 1) . ']' }}'
                        value='{{ $attr->name }}'>
                    <input class='{{ 'd-none ' . ($key + 1) }}' name='{{ 'value[' . ($key + 1) . ']' }}'
                        value='{{ $attr->value }}'>
                @endforeach
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/select2@4.1.0/select2.min.js') }}"></script>
    <script>
        $(function() {
            $("select").select2({
                dir: 'rtl',
                dropdownCssClass: 'form-control'
            });
        });
    </script>
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

    <script src="{{ asset('assets/plugins/ckeditor5/about/build/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description', {}))
            .catch(error => {
                console.error(error);
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
        var attrId = {{ count($attributes) + 1 }};
        $('#addProductAttributeBtn').click(function() {
            var key = $('#attributeKey').val();
            var value = $('#attributeValue').val();
            if (!key || !value) {
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
                $('#attributeValue').val('');
            }
        });
    </script>
    <script>
        deleteAttr = function(id) {
            $('.' + id).remove();
        }
    </script>
    <script src="{{ asset('assets/plugins/jquery-validate@1.15.0/validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validate@1.15.0/additional-methods.min.js') }}"></script>
    <script>
        $("#addProduct").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 5,
                    maxlength: 255,
                },
                isExportable: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
                description: {
                    required: function() {
                        CKEDITOR.instances.cktext.updateElement();
                    },
                },
                image: {
                    extension: "png|jpg|jpeg"
                }
            },
            messages: {
                name: {
                    required: "نام محصول را وارد کنید",
                    minlength: "حداقل 5 کارکتر الزامی است",
                    maxlength: "بیشتر از 255 کارکتر مجاز نیست",
                },
                isExportable: {
                    required: "وضعیت صادرات محصول را مشخص کنید.",
                },
                category_id: {
                    required: "دسته محصول را مشخص کنید.",
                },
                description: {
                    required: "توضیحات الزامی است.",
                },
                image: {
                    extension: "لطفا فایل غیر تصویر وارد نکنید.",
                }
            },
            ignore: ".ignore",
            submitHandler: function(form) {
                // do other things for a valid form
                form.submit();
            },
            invalidHandler: function(event, validator) {}
        });
    </script>
@endsection
