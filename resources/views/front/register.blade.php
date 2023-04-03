@extends('front.master')
@section('content')
    <!--form-->
    <div class="form">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">انشاء حساب جديد</li>
                    </ol>
                </nav>
            </div>




            <div class="account-form">

                @include('flash::message')

                {!! Form::open([
                    'action' => 'App\Http\Controllers\Front\AuthController@registerSave',
                    'method' => 'post',
                    'before' => 'csrf',
                ]) !!}


                {{--
                <form action="{{ route('signin-account') }}" method="POST">
                    @csrf --}}


                {!! Form::text('name', null, [
                    'class' => 'form-control',
                    'placeholder' => 'الإسم',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}

                {!! Form::text('email', null, [
                    'class' => 'form-control',
                    'placeholder' => 'البريد الإلكترونى',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}


                {!! Form::text('date_of_birth', null, [
                    'class' => 'form-control',
                    'placeholder' => 'تاريخ الميلاد',
                    'onfocus' => "(this.type='date')",
                    'id' => 'date',
                ]) !!}


                {{--
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="الإسم "name="name">

                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="البريد الإلكترونى "name="email">

                    <input placeholder="تاريخ الميلاد" class="form-control" type="text" onfocus="(this.type='date')"
                        id="date" name="date_of_birth"> --}}

                {{-- <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="فصيلة الدم "name="blood_type_id"> --}}

                @inject('bloodType', 'App\Models\BloodType')
                {!! Form::select('blood_type_id', $bloodType->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control',
                    'placeholder' => 'اختر فصيلة دم',
                ]) !!}


                {{-- @inject('city', 'App\Models\City')
                    @inject('governorate', 'App\Models\Governorate')
                    {!! Form::select('governorate_id', $city->clients->pluck('governorate_id')->toArray(),null, [
                        'class' => 'form-control',
                        'id' => 'governorates',
                        'placeholder' => 'اختر محافظة',
                    ]) !!}

                    {!! Form::select('city_id', $city->pluck('name', 'id')->toArray(),null, [
                        'class' => 'form-control',
                        'id' => 'cities',
                        'placeholder' => 'اختر مدينة',
                    ]) !!} --}}


                @inject('governorate', 'App\Models\Governorate')
                {!! Form::select('governorate_id', $governorate->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control',
                    'id' => 'governorates',
                    'placeholder' => 'اختر محافظة',
                ]) !!}

                {!! Form::select('city_id', [], null, [
                    'class' => 'form-control',
                    'id' => 'cities',
                    'placeholder' => 'اختر مدينة',
                ]) !!}



                {!! Form::text('phone',null, [
                    'class' => 'form-control',
                    'placeholder' => 'رقم الهاتف',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}

                {!! Form::text('last_donation_date',null, [
                    'class' => 'form-control',
                    'placeholder' => 'آخر تاريخ تبرع',
                    'onfocus' => "(this.type='date')",
                    'id' => 'date',
                ]) !!}

                {!! Form::password('password',[
                    'class' => 'form-control',
                    'placeholder' => 'كلمة المرور',
                    'id' => 'exampleInputPassword1',
                ]) !!}


                {!! Form::password('password_confirmation',[
                    'class' => 'form-control',
                    'placeholder' => 'تأكيد كلمة المرور',
                    'id' => 'exampleInputPassword1',
                ]) !!}



                {{-- <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="رقم الهاتف" name="phone">

                <input placeholder="آخر تاريخ تبرع" class="form-control" type="text" onfocus="(this.type='date')"
                    id="date" name="last_donation_date">

                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="كلمة المرور"
                    name="password">

                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="تأكيد كلمة المرور"
                    name=""> --}}

                <div class="create-btn">
                    {{-- <input type="submit" value="إنشاء"> --}}
                    <button type="submit">إنشاء</button>

                </div>
                {!! Form::close() !!}
                {{-- </form> --}}
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            $("#governorates").change(function(e) {
                e.preventDefault();
                // get gov
                // send ajax
                // append cities
                var governorate_id = $("#governorates").val();
                if (governorate_id) {
                    $.ajax({
                        url: '{{ url('api/v1/cities?governorate_id=') }}' + governorate_id,
                        type: 'get',
                        success: function(data) {
                            if (data.status == 1) {
                                $("#cities").empty();
                                $("#cities").append('<option value="">اختر مدينة</option>');
                                $.each(data.data, function(index, city) {
                                    $("#cities").append('<option value="' + city.id + '">' + city
                                        .name + '</option>');
                                });
                            }
                        },
                        error: function(jqXhr, textStatus, errorMessage) { // error callback
                            alert(errorMessage);
                        }
                    });
                } else {
                    $("#cities").empty();
                    $("#cities").append('<option value="">اختر مدينة</option>');
                }
            });
        </script>
    @endpush
@endsection
