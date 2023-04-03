@extends('front.master')
@section('content')

        <!--form-->
        <div class="form">
            <div class="container">
                <div class="path">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">تسجيل الدخول</li>
                        </ol>
                    </nav>
                </div>

            {{-- @include('flash::message') --}}


            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif


@include('flash::message')

                <div class="signin-form">

            @include('flash::message')

                    <form action="{{route('signin.Save')}}" method="post">
                        @csrf
                        <div class="logo">
                            <img src="{{asset('front/imgs/logo.png')}}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="exampleInputEmail1" name="phone" aria-describedby="emailHelp" placeholder="الجوال">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="كلمة المرور">
                        </div>
                        <div class="row options">
                            <div class="col-md-6 remember">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">تذكرنى</label>
                                </div>
                            </div>
                            <div class="col-md-6 forgot">
                                <img src="{{asset('front/imgs/complain.png')}}">
                                <a href="{{url(route('forget-password'))}}">هل نسيت كلمة المرور</a>
                            </div>
                        </div>
                        <div class="row buttons">
                            <div class="col-md-6 right">
                                <button type="submit">دخول</button>
                                {{-- <a href="{{route('signin.Save')}}">دخول</a> --}}
                            </div>
                            <div class="col-md-6 left">
                                <a  href="{{url('client-register')}}">انشاء حساب جديد</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @endsection
