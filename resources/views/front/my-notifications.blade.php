@extends('front.master')
@section('content')
    <!--inside-article-->
    <div class="all-requests">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الاشعارات </li>
                    </ol>
                </nav>
            </div>

            {{-- <!--requests-->
            <div class="requests">
                <div class="head-text">
                    <h2>طلبات التبرع</h2>
                </div>
                <div class="content">
                    <form class="row filter">
                        <div class="col-md-5 blood">
                            <div class="form-group">
                                <div class="inside-select"> --}}



                            @forelse ($notificationsOfUser as $notificationOfUser)

                                <div class="details">

                                    <ul>
                                        <li><span>العنوان: </span>{{ $notificationOfUser->title }}</li>
                                        <li><span>المحتوى: </span>{{ $notificationOfUser->content }} {{$notificationOfUser->donationRequest->bloodType->name}} </li>
                                        {{-- {{$notificationOfUser->$donationRequest->bloodType->name}} --}}
                                    </ul>
                                    <a href="{{ route('inside-request', $notificationOfUser->donationRequest->id) }}">التفاصيل</a>
                                </div>

                                @empty
                                <p class="text text-center mb-5">عذرا, لايوجد اشعارات</p>
                                @endforelse



                            {{-- @endforeach
                        @else
                            <p class="text text-center mb-5">عذرا, لايوجد طلبات تبرع</p>
                            @endif --}}





                        </div>

                        {{ $notificationsOfUser->links() }}



                </div>
            </div>
        </div>
    </div>
@endsection
