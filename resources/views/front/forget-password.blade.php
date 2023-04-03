@extends('front.master')
@section('content')

  <!--form-->

    <div class="container">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تسجيل الدخول</li>
                </ol>
            </nav>


            @include('flash::message')


            {!! Form::open([
                'action' => 'App\Http\Controllers\Front\AuthController@resetPassword',
                'method' => 'post',
                'before' => 'csrf',
            ]) !!}



            {!! Form::text('phone', null, [
                'class' => 'form-control',
                'placeholder' => 'رقم الهاتف',
                'id' => 'exampleInputEmail1',
                'aria-describedby' => 'emailHelp',
            ]) !!}


            <div class="create-btn">
                <button type="submit">ارسال</button>

            </div>
            {!! Form::close() !!}


{{--
            <div class="form-row my-4">
                <div class="col">
                    <button type="submit" class="form-control py-3 bg-success text-white">ارسال</button>
                </div>

            </div> --}}

        </section>
    </div>
@endsection
