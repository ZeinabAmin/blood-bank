@extends('front.master')
@section('content')
    <!--form-->
    <div class="form">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> اعدادات الاشعارات</li>
                    </ol>
                </nav>
            </div>

            <div class="account-form">
                @include('flash::message')

                {!! Form::open([
                    'action' => 'App\Http\Controllers\Front\MainController@notificationsSettingsSave',
                    'method' => 'post',
                    'before' => 'csrf',
                ]) !!}



                @inject('bloodType', 'App\Models\BloodType')
                {!! Form::select('blood_type_id[]', $bloodType->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control',
                    'placeholder' => 'اختر فصيلة دم',
                    'multiple'=>'multiple',
                ]) !!}



                @inject('governorate', 'App\Models\Governorate')
                {!! Form::select('governorate_id[]', $governorate->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control',
                    'id' => 'governorates',
                    'placeholder' => 'اختر محافظة',
                    'multiple'=>'multiple',
                ]) !!}

                {{-- {!! Form::select('city_id', [], null, [
                    'class' => 'form-control',
                    'id' => 'cities',
                    'placeholder' => 'اختر مدينة',
                ]) !!}

 --}}



 {{-- {!!Form::submit('Click Me!'); !!} --}}

                <div class="create-btn">
                    {{-- <input type="submit" value="إنشاء"> --}}
                    <button type="submit">حفظ</button>

                </div>
                {!! Form::close() !!}
                {{-- </form> --}}
            </div>
        </div>
    </div>



    {{-- @push('scripts')
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
    @endpush --}}
@endsection
