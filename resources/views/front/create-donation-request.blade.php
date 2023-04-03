@extends('front.master')
@section('content')
    <!--form-->
    <div class="form">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">انشاء طلب تبرع </li>
                    </ol>
                </nav>
            </div>

            {{-- @include('flash::message') --}}
            <div class="account-form">

                @include('flash::message')
                {!! Form::open([
                    'action' => 'App\Http\Controllers\Front\MainController@createDonation',
                    'method' => 'post',
                    'before' => 'csrf',
                ]) !!}
{{--
                {!! Form::number('client_id',auth('client-web')->user()->id , [
                    'class' => 'form-control',
                    'type' => 'hidden',
                ]) !!}
 --}}


                {{-- <input type="hidden" name="client_id" value="{{auth('client-web')->user()->id}}"> --}}

                {!! Form::text('patient_name', null, [
                    'class' => 'form-control',
                    'placeholder' => 'الإسم',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}




                {!! Form::text('patient_phone', null, [
                    'class' => 'form-control',
                    'placeholder' => 'هاتف المريض ',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}




                {{-- @inject('governorate', 'App\Models\Governorate')
                {!! Form::select('governorate_id', $governorate->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control',
                    'id' => 'governorates',
                    'placeholder' => 'اختر محافظة',
                ]) !!} --}}

                @inject('city', 'App\Models\City')
                {!! Form::select('city_id', $city->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control',
                    'id' => 'cities',
                    'placeholder' => 'اختر مدينة',
                    // 'id' => 'exampleInputEmail1',
                    // 'aria-describedby' => 'emailHelp',
                ]) !!}


                {!! Form::text('hospital_name', null, [
                    'class' => 'form-control',
                    'placeholder' => 'اسم المستشفى',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}




                @inject('bloodType', 'App\Models\BloodType')
                {!! Form::select('blood_type_id', $bloodType->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control',
                    'placeholder' => 'اختر فصيلة دم',
                    // 'id' => 'exampleInputEmail1',
                    // 'aria-describedby' => 'emailHelp',
                ]) !!}




                {!! Form::number('patient_age', null, [
                    'class' => 'form-control',
                    'placeholder' => 'العمر',
                    // 'onfocus' => "(this.type='date')",
                    // 'id' => 'date',
                ]) !!}


                {!! Form::number('bags_num', null, [
                    'class' => 'form-control',
                    'placeholder' => 'عدد الاكياس المطلوبة',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}





                {!! Form::text('hospital_address', null, [
                    'class' => 'form-control',
                    'placeholder' => 'عنوان المستشفى',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}





                {!! Form::text('details', null, [
                    'class' => 'form-control',
                    'placeholder' => 'التفاصيل ',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}




                {!! Form::text('latitude', null, [
                    'class' => 'form-control',
                    'placeholder' => 'خط العرض',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}




                {!! Form::text('longitude', null, [
                    'class' => 'form-control',
                    'placeholder' => 'خط الطول',
                    'id' => 'exampleInputEmail1',
                    'aria-describedby' => 'emailHelp',
                ]) !!}








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
