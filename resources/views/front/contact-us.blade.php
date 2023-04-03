@extends('front.master')
@section('content')
    <!--contact-us-->
    <div class="contact-now">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تواصل معنا</li>
                    </ol>
                </nav>
            </div>
            <div class="row methods">
                <div class="col-md-6">
                    <div class="call">
                        <div class="title">
                            <h4>اتصل بنا</h4>
                        </div>
                        <div class="content">
                            <div class="logo">
                                <img src="{{ asset('front/imgs/logo.png') }}">
                            </div>
                            <div class="details">
                                <ul>
                                    <li><span>الجوال:</span>{{ $settings->phone }}</li>
                                    <li><span>فاكس:</span> 234234234</li>
                                    <li><span>البريد الإلكترونى:</span>{{ $settings->email }}</li>
                                </ul>
                            </div>
                            <div class="social">
                                <h4>تواصل معنا</h4>
                                <div class="icons" dir="ltr">
                                    <div class="out-icon">
                                        <a href="{{ $settings->fb_link }}"><img
                                                src="{{ asset('front/imgs/001-facebook.svg') }}"></a>
                                    </div>
                                    <div class="out-icon">
                                        <a href="{{ $settings->tw_link }}"><img
                                                src="{{ asset('front/imgs/002-twitter.svg') }}"></a>
                                    </div>
                                    <div class="out-icon">
                                        <a href="{{ $settings->youtube_link }}"><img
                                                src="{{ asset('front/imgs/003-youtube.svg') }}"></a>
                                    </div>
                                    <div class="out-icon">
                                        <a href="{{ $settings->insta_link }}"><img
                                                src="{{ asset('front/imgs/004-instagram.svg') }}"></a>
                                    </div>
                                    <div class="out-icon">
                                        <a href="{{ $settings->phone }}"><img
                                                src="{{ asset('front/imgs/005-whatsapp.svg') }}"></a>
                                    </div>
                                    <div class="out-icon">
                                        <a href="{{ $settings->email }}"><img
                                                src="{{ asset('front/imgs/006-google-plus.svg') }}"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-form">
                        <div class="title">
                            <h4>تواصل معنا</h4>
                        </div>
                        <div class="fields">
                            @include('flash::message')

                            <form action="{{ url(route('contact-Send')) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{auth('client-web')->user()->id}}">
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="الإسم"
                                    name="name" >
                                <input type="email" class="form-control" id="exampleFormControlInput1"
                                    placeholder="البريد الإلكترونى" name="email" >
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="الجوال" name="phone" >
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="عنوان الرسالة" name="subject">
                                <textarea placeholder="نص الرسالة" class="form-control" id="exampleFormControlTextarea1" rows="3" name="msg"></textarea>
                                <button type="submit">ارسال</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
