@extends('front.master')
@section('content')
    <!--intro-->
    <div class="intro">
        <div id="slider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#slider" data-slide-to="0" class="active"></li>
                <li data-target="#slider" data-slide-to="1"></li>
                <li data-target="#slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item carousel-1 active">
                    <div class="container info">
                        <div class="col-lg-5">
                            <h3>بنك الدم نمضى قدما لصحة أفضل</h3>
                            <p>
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على
                                الشكل الخارجي للنص.
                            </p>
                            <a href="#">المزيد</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item carousel-2">
                    <div class="container info">
                        <div class="col-lg-5">
                            <h3>بنك الدم نمضى قدما لصحة أفضل</h3>
                            <p>
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على
                                الشكل الخارجي للنص.
                            </p>
                            <a href="#">المزيد</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item carousel-3">
                    <div class="container info">
                        <div class="col-lg-5">
                            <h3>بنك الدم نمضى قدما لصحة أفضل</h3>
                            <p>
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على
                                الشكل الخارجي.
                            </p>
                            <a href="#">المزيد</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--about-->

    <div class="about">
        <div class="container">
            <div class="col-lg-6 text-center">
                <p>
                    <span>بنك الدم</span> {{ $settings->intro }}
                </p>
            </div>
        </div>
    </div>



    <!--articles-->
    <div class="articles">
        <div class="container title">
            <div class="head-text">
                <h2>المقالات</h2>
            </div>
        </div>
        <div class="view">
            <div class="container">
                <div class="row">
                    <!-- Set up your HTML -->
                    <div class="owl-carousel articles-carousel">
                        @foreach ($posts as $post)
                            <div class="card">
                                <div class="photo">
                                    <img src="{{ asset('uploads/images/posts/' . $post->image) }}">
                                    <a  href="{{url('article-details',$post->id)}}" class="click">المزيد</a>

                                </div>
                                {{-- {{-- <a href="#" class="favourite"> --}}



                                <i id="{{ $post->id }}" onclick="toggleFavourite(this)"
                                    class="fab fa-gratipay
                               {{ $post->is_favourite ? 'second-heart' : 'first-heart' }}"></i>

                                <!---<i  class="fab fa-gratipay second-heart"></i>-->

                                {{-- <i class="far fa-heart"></i>
                                </a> --}}


                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">{{ $post->content }}</p>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--requests-->
    <div class="requests">
        <div class="container">
            <div class="head-text">
                <h2>طلبات التبرع</h2>
            </div>
        </div>
        <div class="content">
            <div class="container">
                {{-- <form class="row filter"> --}}

                    {!! Form::open([
                        'method' => 'get',
                        'class'=>"row filter",
                    ]) !!}

                    <div class="col-md-5 blood">
                        <div class="form-group">
                            <div class="inside-select">



                                {!! Form::open([
                                    'action'=>'App\Http\Controllers\Front\MainController@home',
                                    'method' => 'get',
                                ]) !!}


                                @inject('bloodType', 'App\Models\BloodType')

                                {!! Form::select('blood_type_id', $bloodType->pluck('name', 'id')->toArray(), null, [
                                    'class' => 'form-control',
                                    'id' => 'exampleFormControlSelect1',
                                    'placeholder' => 'اختر فصيلة الدم',
                                ]) !!}





                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 city">
                        <div class="form-group">
                            <div class="inside-select">

                                {{-- @inject('city', 'App\Models\DonationRequest') --}}
                                <?php $city = app('App\Models\city'); ?>

                                {!! Form::select('city_id', $city->pluck('name', 'id')->toArray(), null, [
                                    'class' => 'form-control',
                                    'id' => 'exampleFormControlSelect1',
                                    'placeholder' => 'اختر مدينة',
                                ]) !!}



                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 search">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                {{-- </form> --}}
                {!! Form::close() !!}

                <div class="patients">
                    @if ($donationRequests->count())
                    @foreach ($donationRequests as $donationRequest)
                        <div class="details">
                            <div class="blood-type">
                                <h2 dir="ltr">{{ $donationRequest->bloodType->name }}</h2>
                            </div>
                            <ul>
                                <li><span>اسم الحالة:</span>{{ $donationRequest->patient_name }}</li>
                                <li><span>مستشفى:</span>{{ $donationRequest->hospital_name }}</li>
                                <li><span>المدينة:</span>{{ $donationRequest->city->name }}</li>
                            </ul>
                            <a href="{{route('inside-request',$donationRequest->id)}}">التفاصيل</a>
                            {{-- <a href="inside-request.html">التفاصيل</a> --}}
                        </div>
                    @endforeach

                    <div class="more">
                        <a  href="{{url(route('donations'))}}">المزيد</a>
                    </div>


                    @else
                            <p class="text text-center mb-5" >عذرا, لايوجد طلبات تبرع</p>
                            @endif

                </div>

            </div>
        </div>
    </div>

    <!--contact-->
    <div class="contact">
        <div class="container">
            <div class="col-md-7">
                <div class="title">
                    <h3>اتصل بنا</h3>
                </div>
                <p class="text">{{ $settings->contact_us_text }}</p>
                <div class="row whatsapp">
                    <a href="#">
                        <img src="{{ asset('front/imgs/whats.png') }}">
                        <p dir="ltr">{{ $settings->phone }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--app-->
    <div class="app">
        <div class="container">
            <div class="row">
                <div class="info col-md-6">
                    <h3>تطبيق بنك الدم</h3>
                    <p>
                        {{ $settings->mobile_app_text }}
                    </p>
                    <div class="download">
                        <h4>متوفر على</h4>
                        <div class="row stores">
                            <div class="col-sm-6">
                                <a href="{{ $settings->mobile_app_android_link }}">
                                    <img src="{{ asset('front/imgs/google.png') }}">
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ $settings->mobile_app_ios_link }}">
                                    <img src="{{ asset('front/imgs/ios.png') }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="screens col-md-6">
                    <img src="{{ asset('front/imgs/App.png') }}">
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleFavourite(heart) {
                var post_id = heart.id;
                $.ajax({
                    url: '{{ url(route('toggle-favourite')) }}',
                    type: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        post_id: post_id
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            console.log(data);
                            var currentClass = $(heart).attr('class');
                            if (currentClass.includes('first')) {
                                $(heart).removeClass('first-heart').addClass('second-heart');
                            } else {
                                $(heart).removeClass('second-heart').addClass('first-heart');
                            }
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) { // error callback
                        alert(errorMessage);
                    }
                });
            }
        </script>
    @endpush
@endsection
