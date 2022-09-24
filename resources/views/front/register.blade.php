@extends('front.master')
@section('content')

        <!--form-->
        <div class="form">
            <div class="container">
                <div class="path">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">انشاء حساب جديد</li>
                        </ol>
                    </nav>
                </div>
                <div class="account-form">
                    <form>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="الإسم">

                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="البريد الإلكترونى">

                        <input placeholder="تاريخ الميلاد" class="form-control" type="text" onfocus="(this.type='date')" id="date">

                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="فصيلة الدم">


                        @inject('governorate','App\Models\Governorate')
                        {!! Form::select('governorate_id',$governorate->pluck('name','id')->toArray(),null,[
                            'class' => 'form-control',
                            'id' => 'governorates',
                            'placeholder' => 'اختر محافظة'
                        ]) !!}

                        {!! Form::select('city_id',[],null,[
                            'class' => 'form-control',
                            'id' => 'cities',
                            'placeholder' => 'اختر مدينة'
                        ]) !!}
                        {{-- <select class="form-control" id="governorates" name="governorate">
                            <option selected disabled hidden value="">المحافظة</option>
                            <option value="1">الدقهلية</option>
                            <option value="2">الغربية</option>
                        </select> --}}

                        {{-- <select class="form-control" id="cities" name="city">
                            <option  selected disabled hidden value="">المدينة</option>
                        </select> --}}

                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="رقم الهاتف">

                        <input placeholder="آخر تاريخ تبرع" class="form-control" type="text" onfocus="(this.type='date')" id="date">

                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="كلمة المرور">

                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="تأكيد كلمة المرور">

                        <div class="create-btn">
                            <input type="submit" value="إنشاء"></input>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        @push('scripts')
        <script>
            $("#governorates").change(function (e) {
                e.preventDefault();
                // get gov
                // send ajax
                // append cities
                var governorate_id = $("#governorates").val();
                if (governorate_id)
                {
                    $.ajax({
                        url : '{{url('api/v1/cities?governorate_id=')}}'+governorate_id,
                        type: 'get',
                        success: function (data) {
                            if (data.status == 1)
                            {
                                $("#cities").empty();
                                $("#cities").append('<option value="">اختر مدينة</option>');
                                $.each(data.data, function (index, city) {
                                    $("#cities").append('<option value="'+city.id+'">'+city.name+'</option>');
                                });
                            }
                        },
                        error: function (jqXhr, textStatus, errorMessage) { // error callback
                            alert(errorMessage);
                        }
                    });
                }else{
                    $("#cities").empty();
                    $("#cities").append('<option value="">اختر مدينة</option>');
                }
            });
        </script>
    @endpush


        @endsection
