@extends('user.layout.master')
@section('head')
    <title>صنعت یار ایران - {{ $page->name }}</title>
    <style>
        .productDescription {
            background: rgba(217, 217, 217, 0.31);
            border-radius: 10px;
            width: 100%;
            min-height: 248px;
            padding: 16px;
        }
        .productDescription ul{
            display: unset;
        }
    </style>
@endsection
@section('content')
                    {{-- @foreach ($otherProducts as $product) --}}
    <main class="customPage mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <section class="pageWrapper">
                        <div class="pageHeader">
                            {!! $page->icon !!}
                            {{ $page->name }}
                        </div>
                        <div class="pageImage">
                            <img data-src="{{ asset($page->image_path) }}" alt="" class="img-fluid">
                        </div>
                        <div class="pageContent">
                            {!! $page->content !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
@endsection
