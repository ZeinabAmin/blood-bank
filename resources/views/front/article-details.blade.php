@extends('front.master')
@section('content')
    <!--inside-article-->
    <div class="inside-article">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="#">المقالات</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الوقاية من الأمراض</li>
                    </ol>
                </nav>
            </div>

            @foreach ($posts as $post)
                <div class="article-image">
                    <img src="{{ asset('uploads/images/posts/' . $post->image) }}">
                </div>
                <div class="article-title col-12">
                    <div class="h-text col-6">
                        <h4>{{ $post->title }}</h4>
                    </div>
                    <div class="icon col-6">
                        {{-- <button type="button"><i class="far fa-heart"></i></button> --}}
                        <button type="button"> <i id="{{ $post->id }}" onclick="toggleFavourite(this)"
                            class="fab fa-gratipay
            {{ $post->is_favourite ? 'second-heart' : 'first-heart' }}"></i></button>
                    </div>
                </div>

                <!--text-->
                <div class="text">
                    <p>
                        {{ $post->content }}
                    </p>
                </div>
            @endforeach

            <!--articles-->
            <div class="articles">
                <div class="title">
                    <div class="head-text">
                        <h2>مقالات ذات صلة</h2>
                    </div>
                </div>


                <div class="view">
                    <div class="row">
                        <!-- Set up your HTML -->


                        <div class="owl-carousel articles-carousel">
                            @foreach ($posts as $post)
                                <div class="card">
                                    <div class="photo">
                                        <img src="{{ asset('uploads/images/posts/' . $post->image) }}">
                                        {{-- <img src="{{asset($post->image)}}" class="card-img-top" alt="..."> --}}
                                        <a href="{{ url('post/' . $post->id) }}" class="click">المزيد</a>
                                    </div>


                                    <i id="{{ $post->id }}" onclick="toggleFavourite(this)"
                                        class="fab fa-gratipay
                {{ $post->is_favourite ? 'second-heart' : 'first-heart' }}"></i>


                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text">{{ $post->content }}</p>
                                    </div>
                                </div>
                            @endforeach



                            {{-- <div class="owl-carousel articles-carousel">
                                <div class="card">
                                    <div class="photo">
                                        <img src="{{asset('front/imgs/p2.jpg')}}" class="card-img-top" alt="...">
                                        <a href="article-details.html" class="click">المزيد</a>
                                    </div>
                                    <a href="#" class="favourite">
                                        <i class="far fa-heart"></i>
                                    </a> --}}


                            {{-- <div class="card-body">
                                        <h5 class="card-title">طريقة الوقاية من الأمراض</h5>
                                        <p class="card-text">
                                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،
                                        </p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="photo">
                                        <img src="imgs/p2.jpg" class="card-img-top" alt="...">
                                        <a href="article-details.html" class="click">المزيد</a>
                                    </div>
                                    <a href="#" class="favourite">
                                        <i class="far fa-heart"></i>
                                    </a>

                                    <div class="card-body">
                                        <h5 class="card-title">طريقة الوقاية من الأمراض</h5>
                                        <p class="card-text">
                                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،
                                        </p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="photo">
                                        <img src="imgs/p2.jpg" class="card-img-top" alt="...">
                                        <a href="article-details.html" class="click">المزيد</a>
                                    </div>
                                    <a href="#" class="favourite">
                                        <i class="far fa-heart"></i>
                                    </a>

                                    <div class="card-body">
                                        <h5 class="card-title">طريقة الوقاية من الأمراض</h5>
                                        <p class="card-text">
                                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،
                                        </p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="photo">
                                        <img src="imgs/p2.jpg" class="card-img-top" alt="...">
                                        <a href="article-details.html" class="click">المزيد</a>
                                    </div>
                                    <a href="#" class="favourite">
                                        <i class="far fa-heart"></i>
                                    </a>

                                    <div class="card-body">
                                        <h5 class="card-title">طريقة الوقاية من الأمراض</h5>
                                        <p class="card-text">
                                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،
                                        </p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="photo">
                                        <img src="imgs/p2.jpg" class="card-img-top" alt="...">
                                        <a href="article-details.html" class="click">المزيد</a>
                                    </div>
                                    <a href="#" class="favourite">
                                        <i class="far fa-heart"></i>
                                    </a>

                                    <div class="card-body">
                                        <h5 class="card-title">طريقة الوقاية من الأمراض</h5>
                                        <p class="card-text">
                                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،
                                        </p>
                                    </div>
                                </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


   


@endsection
