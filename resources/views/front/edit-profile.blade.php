@extends('front.master')
@inject('model', 'App\Models\Client')
@section('content')
    <!--form-->
    <div class="form">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تعديل حسابي</li>
                    </ol>
                </nav>
            </div>


            @include('flash::message')

            <div class="account-form">



                {!! Form::model($model, [
                    'action' => 'App\Http\Controllers\Front\AuthController@editProfile',
                    'method' => 'post',
                    'before' => 'csrf',
                ]) !!}


                {{-- <form method="POST" action="{{ route('client-profile')}}">
                    @csrf --}}


                <div class="form-group">
                    {!! Form::text('name', $client->name, [
                        'class' => 'form-control',
                        'placeholder' => 'الإسم',
                        'id' => 'exampleInputEmail1',
                        'aria-describedby' => 'emailHelp',
                    ]) !!}

                    {!! Form::text('email', $client->email, [
                        'class' => 'form-control',
                        'placeholder' => 'البريد الإلكترونى',
                        'id' => 'exampleInputEmail1',
                        'aria-describedby' => 'emailHelp',
                    ]) !!}


                    {!! Form::text('date_of_birth', $client->date_of_birth, [
                        'class' => 'form-control',
                        'placeholder' => 'تاريخ الميلاد',
                        'onfocus' => "(this.type='date')",
                        'id' => 'date',
                    ]) !!}





                    {{--
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="الإسم "name="name" value="{{ $client->name }}">

                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="البريد الإلكترونى "name="email" value="{{ $client->email }}"> --}}

                    {{-- <input placeholder="تاريخ الميلاد" class="form-control" type="text" onfocus="(this.type='date')"
                        id="date" name="date_of_birth" value="{{ $client->date_of_birth }}"> --}}

                    {{-- <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="فصيلة الدم "name="blood_type_id" value="{{$client->blood_type_id}}"> --}}

                    @inject('bloodType', 'App\Models\BloodType')
                    {!! Form::select('blood_type_id', $bloodType->pluck('name', 'id')->toArray(), $client->blood_type_id, [
                        'class' => 'form-control',
                        'placeholder' => 'اختر فصيلة دم',
                    ]) !!}

                    @inject('city', 'App\Models\City')
                    @inject('governorate', 'App\Models\Governorate')
                    {!! Form::select('governorate_id', $governorate->pluck('name', 'id')->toArray(), $client->city->governorate_id, [
                        'class' => 'form-control',
                        'id' => 'governorates',
                        'placeholder' => 'اختر محافظة',
                    ]) !!}
                    {{-- @inject('city', 'App\Models\City') --}}
                    {!! Form::select('city_id', $city->pluck('name', 'id')->toArray(), $client->city_id, [
                        'class' => 'form-control',
                        'id' => 'cities',
                        'placeholder' => 'اختر مدينة',
                    ]) !!}
                    {{-- <select class="form-control" id="governorates" name="governorate">
                            <option selected disabled hidden value="">المحافظة</option>
                            <option value="1">الدقهلية</option>
                            <option value="2">الغربية</option>
                        </select> --}}

                    {{-- <select class="form-control" id="cities" name="city">
                            <option  selected disabled hidden value="">المدينة</option>
                        </select> --}}


                    {!! Form::text('phone', $client->phone, [
                        'class' => 'form-control',
                        'placeholder' => 'رقم الهاتف',
                        'id' => 'exampleInputEmail1',
                        'aria-describedby' => 'emailHelp',
                    ]) !!}

                    {!! Form::text('last_donation_date', $client->last_donation_date, [
                        'class' => 'form-control',
                        'placeholder' => 'آخر تاريخ تبرع',
                        'onfocus' => "(this.type='date')",
                        'id' => 'date',
                    ]) !!}

                    {!! Form::password('password', [
                        'class' => 'form-control',
                        'placeholder' => 'كلمة المرور',
                        'id' => 'exampleInputPassword1',
                    ]) !!}


                    {!! Form::password('password_confirmation', [
                        'class' => 'form-control',
                        'placeholder' => 'تأكيد كلمة المرور',
                        'id' => 'exampleInputPassword1',
                    ]) !!}



                    {{-- <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="رقم الهاتف" name="phone" value="{{ $client->phone }}"> --}}

                    {{-- <input placeholder="آخر تاريخ تبرع" class="form-control" type="text" onfocus="(this.type='date')"
                        id="date" name="last_donation_date" value="{{ $client->last_donation_date }}"> --}}
                    {{--
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="كلمة المرور"
                        name="password">

                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="تأكيد كلمة المرور"
                        name="password_confirmation"> --}}

                    <div class="create-btn">
                        {{-- <input type="submit" value="تعديل"> --}}
                        <button type="submit">تعديل</button>

                    </div>
                    {!! Form::close() !!}
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
