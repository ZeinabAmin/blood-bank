@extends('layouts.app')
@inject('model','App\Models\Post')
@section('page_title')
Create Posts
@endsection

@section('content')



  <!-- Main content -->
  <section class="content">

<!-- <div class="row"> -->
    {{-- <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="far fa-user"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Clients</span>
         <span class="info-box-number">{{$client->count()}}</span>
        </div>

        </div>

        </div>



        



        <div class="col-md-3 col-sm-6 col-12">
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
        <h3 class="card-title"> Create Posts</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
        @include('partials.validation_errors')



                {!! Form::model($model,[
                    'action' => 'App\Http\Controllers\PostController@store',
                        'files'=>   true,
                        'method' => 'post',

                ]) !!}





        <div class="form-group">
            <label for="name">Title:</label>
            {!! Form::text('title',null,[
            'class' => 'form-control'
         ]) !!}
            <label for="name">Content:</label>
            {!! Form::text('content',null,[
            'class' => 'form-control'
         ]) !!}
            <label for="image">Image:</label>
            <br>
            {!! Form::file('image', [
           'class'=>'mb-2'

           ]) !!}

        <br>
            <label  for="select">Category Name:</label>
            {!! Form::select('category_id',$categories,null,[
                'class' => 'form-control'
             ]) !!}

        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">create</button>
        </div>


                {!! Form::close() !!}




              <!-- /.card-body -->

            </div>
            <!-- /.card -->
        </div>
          </section>
          <!-- /.content -->
        @endsection


















