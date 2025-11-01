@extends('dashboard.layout.master')
@section('head')
    <title>افزودن خبر</title>
    <link href="{{ asset('assets/plugins/select2@4.1.0/select2min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <header class="d-flex" style="justify-content: space-between">
        <h1>
            افزودن خبر
        </h1>
        <button class="actionBtn" form="addProduct">
            ثبت
        </button>
    </header>
    <section class="content">
        <div class="container">
            <form action="{{ route('panel.news.store') }}" id="addProduct" method="post" enctype="multipart/form-data"
                class="addProductForm">
                @csrf
                <div class="row">
                    <div class="col-9">
                        <div class="row input-row">
                            <div class="col-12">
                                <input type="text" class="isy-input" placeholder="تیتر خبر :" name="title"
                                    value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="row input-row" style="margin-top:40px; font-size:14px;">
                            <div class="col-6">
                                <p>توضیح محصول یا خدمت :</p>
                            </div>
                            <div class="col-12">
                                <textarea name="content" id="content" cols="30" rows="10">{{ old('content') ? old('content') : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 pt-4">
                        <div class="row input-row">
                            <select name="category_id">
                                <option value="">دسته بندی</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <input type="file" placeholder="عکس" name="image" id="image" accept="image/*"
                                style="padding-top: 20px">
                            <div id="img-preview"></div>
                        </div>
                    </div>
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

    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
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
@endsection
