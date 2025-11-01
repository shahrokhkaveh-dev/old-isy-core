@extends('web.layout.layout')
@section('title')
    <title>صنعت یار ایران - {{ $news->title }}</title>
@endsection
@section('content')
<main class="article">
    <div class="container">
        <div class="flex">
            <article>
                <div class="article-image">
                    <img src="{{ asset($news->box_image_path) }}" alt="">
                </div>
                <div class="article-title">
                    <h1 class="h1">{{ $news->title }}</h1>
                    <p class="article-date">{{ jdate($news->created_at) }}</p>
                </div>
                {{-- <div class="article-menu">
                    <p>لیست مطالب</p>
                    <ul>
                        <li><a href="">تست تیتر محتوا 1</a></li>
                        <li><a href="">تست تیتر محتوا 2</a></li>
                        <li><a href="">تست تیتر محتوا 3</a></li>
                    </ul>
                </div> --}}
                <div class="article-content">
                    {!! $news->content !!}
                </div>
                <div class="article-share-box">
                    <div>
                        <ul>
                            <li><i class="fab fa-instagram"></i></li>
                            <li><i class="fab fa-telegram"></i></li>
                            <li><i class="fab fa-whatsapp"></i></li>
                            <li><i class="fab fa-linkedin"></i></li>
                        </ul>
                    </div>
                    <div class="comment-count-div">
                        <span class="comment-count">3</span><i class="far fa-comment-dots"></i>
                    </div>
                </div>
                <div class="article-send-comment-wrapper">
                    <p>ارسال دیدگاه</p>
                    <form action="" class="article-comment-form">
                        <div>
                            <input type="text" placeholder="نام شما">
                            <input type="email" placeholder="ایمیل شما">
                        </div>
                        <div>
                            <textarea placeholder="متن دیدگاه"></textarea>
                        </div>
                        <button type="submit">ارسال دیدگاه</button>
                    </form>
                </div>

                {{-- <div class="article-comments">
                    <div class="article-comments-title">دیدگاه های ارسال شده</div>
                    <ul class="article-comment-list">
                        <li class="parent-comment">
                            <div class="comment-info">
                                <div class="comment-author-name">علی علی آبادی</div>
                                <div class="article-comment-date">23 اردیبهشت 1379</div>
                            </div>
                            <hr>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad ipsam iure nam quas voluptatem. Assumenda cumque cupiditate, dignissimos eligendi excepturi magni maiores, nihil officiis repellat repudiandae tempore unde veniam vero.
                            </div>
                        </li>
                        <li class="child-comment">
                            <div class="comment-info">
                                <div class="comment-author-name">علی علی آبادی</div>
                                <div class="article-comment-date">23 اردیبهشت 1379</div>
                            </div>
                            <hr>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad ipsam iure nam quas voluptatem. Assumenda cumque cupiditate, dignissimos eligendi excepturi magni maiores, nihil officiis repellat repudiandae tempore unde veniam vero.
                            </div>
                        </li>
                        <li class="child-comment">
                            <div class="comment-info">
                                <div class="comment-author-name">علی علی آبادی</div>
                                <div class="article-comment-date">23 اردیبهشت 1379</div>
                            </div>
                            <hr>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad ipsam iure nam quas voluptatem. Assumenda cumque cupiditate, dignissimos eligendi excepturi magni maiores, nihil officiis repellat repudiandae tempore unde veniam vero.
                            </div>
                        </li>
                    </ul>
                </div> --}}
            </article>
            <aside>
                <div class="new-articles-bar">
                    <p class="new-articles-bar-title">جدیدترین مطالب</p>
                    @foreach ($newNews as $post)
                    <div class="new-article-card">
                        <div class="new-article-card-image">
                            <img src="{{asset($post->box_image_path)}}" alt="">
                        </div>
                        <div class="new-article-card-info">
                            <a href="{{route('user.news.show' , ['id'=>$post->id])}}" class="new-article-card-title">{{$post->title}}</a>
                            <span class="new-article-card-date">{{jdate($news->updated_at)}}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="ad-bar">
                    <a href=""><img src="https://fakeimg.pl/410x320" alt=""></a>
                    <a href=""><img src="https://fakeimg.pl/410x320" alt=""></a>
                    <a href=""><img src="https://fakeimg.pl/410x320" alt=""></a>
                    <a href=""><img src="https://fakeimg.pl/410x320" alt=""></a>
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection
