@extends('dashboard.layout.master')
@section('head')
    <title>افزودن آگهی</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/multiplaImageUploadWithPreview.css') }}">
@endsection
@section('content')
    <header class="d-flex" style="justify-content: space-between">
        <h1>
            افزودن آگهی
        </h1>
        <button class="actionBtn" form="addProduct">
            ثبت
        </button>
    </header>
    <section class="content">
        <div class="container">
            <form action="{{ route('panel.advertising.store') }}" id="addProduct" method="post"
                enctype="multipart/form-data" class="addProductForm">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="row input-row">
                            <div class="col-12">
                                <input type="text" class="isy-input" placeholder="تیتر آگهی :" name="title"
                                    value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="row input-row" style="margin-top:40px; font-size:14px;">
                            <div class="col-6">
                                <p>توضیح آگهی :</p>
                            </div>
                            <div class="col-12">
                                <textarea name="content" id="content" cols="30" rows="10">{{ old('content') ? old('content') : '' }}</textarea>
                            </div>
                        </div>
                        <div class="row input-row mt-3">
                            <div class="col-6">
                                <select name="category_id" style="background: unset; color:#818181;">
                                    <option value="">دسته بندی</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="text" style="height: 52px;" class="isy-input m-0" placeholder="مبلغ :"
                                    name="price" value="{{ old('price') }}">
                            </div>
                        </div>
                        <div class="upload__box mt-3">
                            <div class="upload__btn-box">
                                <label class="upload__btn">
                                    <p>انتخاب تصاویر</p>
                                    <input data-max_count="4" type="file" multiple="" data-max_length="4"
                                        class="upload__inputfile" name="images[]">
                                </label>
                                <span
                                    style="font-size: 12px;color: #979797;">مجموع
                                    تصاویر حدکثر 4 مگابایت شوند</span>
                            </div>
                            <div class="upload__img-wrap"></div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
        </div>
    </section>
@endsection
@section('script')
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
        CKEDITOR.replace('content', {
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
    <script src="{{ asset('js/multiplaImageUploadWithPreview.js') }}"></script>
@endsection
