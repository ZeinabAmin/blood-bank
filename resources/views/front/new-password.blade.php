@extends('front.master')
@section('content')
    <!--form-->
    <div class="form">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تسجيل الدخول </li>
                    </ol>
                </nav>
            </div>

            <div class="account-form">


                @include('flash::message')

                {!! Form::open([
                    'action' => 'App\Http\Controllers\Front\AuthController@newPasswordConfirm',
                    'method' => 'post',
                    'before' => 'csrf',
                ]) !!}


                {!! Form::number('pin_code', null, [
                    'class' => 'form-control',
                    'placeholder' => 'رمز استرجاع الحساب',
                ]) !!}

                {!! Form::text('phone', null, [
                    'class' => 'form-control',
                    'placeholder' => 'رقم الهاتف',
                  
                ]) !!}


                {!! Form::password('new_password', [
                    'class' => 'form-control',
                    'placeholder' => ' كلمة المرور الجديده',
                    'id' => 'exampleInputPassword1',
                ]) !!}


                {!! Form::password('new_password_confirmation', [
                    'class' => 'form-control',
                    'placeholder' => 'تأكيد كلمة المرور',
                    'id' => 'exampleInputPassword1',
                ]) !!}






                <div class="create-btn">
                    {{-- <input type="submit" value="إنشاء"> --}}
                    <button type="submit">دخول</button>

                </div>
                {!! Form::close() !!}
                {{-- </form> --}}
            </div>
        </div>
    </div>
@endsection
