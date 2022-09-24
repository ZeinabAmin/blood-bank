@extends('layouts.app')
@section('page_title')
Edit Settings
@endsection

@section('content')



  <!-- Main content -->
  <section class="content">

{{-- <!-- <div class="row"> -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="far fa-user"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Clients</span>
         <span class="info-box-number">{{$client->count()}}</span>
        </div>

        </div>

        </div>



{{-- --}}
        {{-- <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
            <span class="info-box-icon bg-green"><i class="far fa-user"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Donation Request</span>
             <span class="info-box-number">{{$donation->count()}}</span>
            </div>

            </div>

            </div>







    </div> --}}





    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"> list of settings</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">

            {!! Form::model($model,[
            'action' => ['App\Http\Controllers\SettingController@update',$model->id],
            'method' => 'put'
            ]) !!}
            @include('partials.validation_errors')
            @include('flash::message')
            <div class="form-group">


                <label for="notification_settings_text">notification_settings_text</label>
                {!! Form::text('notification_settings_text',null,[
                'class' => 'form-control'
             ]) !!}


                <label for="about_app">about_app</label>
                {!! Form::textarea('about_app',null,[
                'class' => 'form-control'
             ]) !!}


<label for="intro">intro</label>
{!! Form::textarea('intro',null,[
'class' => 'form-control'
]) !!}
                <label for="fb_link">fb_link</label>
                {!! Form::text('fb_link',null,[
                'class' => 'form-control'
             ]) !!}

                <label for="tw_link">tw_link</label>
                {!! Form::text('tw_link',null,[
                'class' => 'form-control'
             ]) !!}

                <label for="youtube_link">youtube_link</label>
                {!! Form::text('youtube_link',null,[
                'class' => 'form-control'
             ]) !!}

                <label for="insta_link">insta_link</label>
                {!! Form::text('insta_link',null,[
                'class' => 'form-control'
             ]) !!}

                <label for="phone">phone</label>
                {!! Form::text('phone',null,[
                'class' => 'form-control'
             ]) !!}

                <label for="email">email</label>
                {!! Form::text('email',null,[
                'class' => 'form-control'
             ]) !!}


<label for="contact_us_text">contact_us_text</label>
{!! Form::text('contact_us_text',null,[
'class' => 'form-control'
]) !!}

<label for="mobile_app_text">mobile_app_text</label>
{!! Form::text('mobile_app_text',null,[
'class' => 'form-control'
]) !!}


<label for="mobile_app_android_link">mobile_app_android_link</label>
{!! Form::text('mobile_app_android_link',null,[
'class' => 'form-control'
]) !!}

<label for="mobile_app_ios_link">mobile_app_ios_link</label>
{!! Form::text('mobile_app_ios_link',null,[
'class' => 'form-control'
]) !!}

            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">تعديل</button>
            </div>

            {!! Form::close () !!}
        </div>

                            </tbody>
                        </table>

      </div>

      <!-- /.card-body -->

    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
@endsection

















