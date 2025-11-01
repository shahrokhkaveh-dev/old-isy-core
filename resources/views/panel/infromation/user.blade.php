@extends('dashboard.layout.master')
@section('head')
    <title>مشاهده پروفایل</title>
    <link rel="stylesheet" href="{{ asset('plugins/cropper/cropper.css') }}">
    <style>
        .label {
            cursor: pointer;
        }

        .img-container img {
            max-width: 100%;
        }
    </style>
    <style>
        .flipX video::-webkit-media-text-track-display {
            transform: matrix(-1, 0, 0, 1, 0, 0) !important;
        }

        .flipXY video::-webkit-media-text-track-display {
            transform: matrix(-1, 0, 0, -1, 0, 0) !important;
        }

        .flipXYX video::-webkit-media-text-track-display {
            transform: matrix(1, 0, 0, -1, 0, 0) !important;
        }
    </style>
    <style>
        @keyframes blinkWarning {
            0% {
                color: red;
            }

            100% {
                color: white;
            }
        }

        @-webkit-keyframes blinkWarning {
            0% {
                color: red;
            }

            100% {
                color: white;
            }
        }

        .blinkWarning {
            -webkit-animation: blinkWarning 1s linear infinite;
            -moz-animation: blinkWarning 1s linear infinite;
            animation: blinkWarning 1s linear infinite;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row text-light heading-row">
            <div class="d-flex" style="justify-content: space-between; align-items: center;">
                <h1 class="">اطلاعات شما</h1>
            </div>
        </div>
        <div class="row mybox">
            <div class="col-12">
                <div class="d-flex" style="justify-content: space-between; margin-bottom: 28.5px">
                    <span style="display: inline-flex; align-items: center;">
                        <img src="{{ asset($user->avatar) }}" class="brand_logo" alt="" id="avatar_image">
                    </span>
                    <button class="btn panel_btn" id="avatar_btn">تغییر عکس</button>
                    <input type="file" class="sr-only" id="avatar" name="image" accept="image/*"
                        style="display: none">
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">تصویر را برش دهید</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="img-container">
                                        <img id="image" src="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">لغو</button>
                                    <button type="button" class="btn btn_panel" id="crop">ثبت</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-6">
                <div class="d-flex" style="justify-content: space-between;">
                    <span>نام :</span>
                    <span>{{ $user->first_name }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex" style="justify-content: space-between;">
                    <span>نام خانوادگی :</span>
                    <span>{{ $user->last_name }}</span>
                </div>
            </div>
            <hr>
            <div class="col-6">
                <div class="d-flex" style="justify-content: space-between;">
                    <span>شماره تلفن :</span>
                    <span>{{ $user->phone }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex" style="justify-content: space-between;">
                    <span>آدرس ایمیل :</span>
                    <span>{{ $user->email }}</span>
                </div>
            </div>
            <hr>
            <div class="col-6">
                <div class="d-flex" style="justify-content: space-between;">
                    <span>استان :</span>
                    <span>{{ $user->province() }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex" style="justify-content: space-between;">
                    <span>شهر :</span>
                    <span>{{ $user->city() }}</span>
                </div>
            </div>
            <hr>
            <div class="col-6">
                <div class="d-flex" style="justify-content: space-between;">
                    <span>آدرس :</span>
                    <span>{{ $user->address }}</span>
                </div>
            </div>
            @if ($user->is_branding)
                <div class="col-6">
                    <div class="d-flex" style="justify-content: space-between;">
                        <span>شرکت :</span>
                        <span>{{ $user->brand->name }}</span>
                    </div>
                </div>
            @endif
            <hr>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('plugins/cropper/cropper.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#avatar_btn').click(function(e) {
                $('#avatar').trigger('click');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var avatar = $('#avatar_image');
            var image = document.getElementById('image');
            var input = document.getElementById('avatar');
            var $modal = $('#modal');
            var cropper;
            input.addEventListener('change', function(e) {
                var files = e.target.files;
                var done = function(url) {
                    input.value = '';
                    image.src = url;
                    $modal.modal('show');
                };
                var reader;
                var file;
                var url;

                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });

            document.getElementById('crop').addEventListener('click', function() {
                var initialAvatarURL;
                var canvas;

                $modal.modal('hide');

                if (cropper) {
                    canvas = cropper.getCroppedCanvas({
                        width: 160,
                        height: 160,
                    });
                    initialAvatarURL = avatar.src;
                    avatar.src = canvas.toDataURL();
                    canvas.toBlob(function(blob) {
                        var formData = new FormData();

                        formData.append('avatar', blob, 'avatar.jpg');
                        $.ajax({
                            type: "POST",
                            url: "{{ route('panel.information.change_avatar') }}",
                            data: {
                                'image': avatar.src,
                                '_token': "{{ csrf_token() }}"
                            },
                            // mimeType: "multipart/form-data",
                            success: function(response) {
                                var url = response.url;
                                $('#avatar_image').attr('src', url);
                            },

                            error: function() {
                                avatar.src = initialAvatarURL;
                            },

                            complete: function() {},
                        });
                    });
                }
            });
        });
    </script>
@endsection
