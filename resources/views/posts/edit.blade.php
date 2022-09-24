@extends('layouts.app')
@section('page_title')
Create Posts
@endsection
 @section('small_title')
 list of posts
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

        {!! Form::model($model,[
            'action' => ['App\Http\Controllers\PostController@update', $model->id],
            'method' => 'put',
            'files' =>true
        ]) !!}
@include('partials.validation_errors')

{{-- @include('posts.form') --}}

<div class="form_group">

    <label for="title">Title</label>
    {!! Form::text('title',null,[
        'class'=>'form_control'

    ]) !!}

    </div>




    <div class="form_group">

        <label for="content">Content</label>
        {!! Form::textarea('content',null,[
            'class'=>'form_control'

        ]) !!}

        </div>




        <div class="form_group">

            <label for="image">Image</label>
            {!! Form::file('image',null,[
                'class'=>'form_control'

            ]) !!}

            </div>





            <div class="form_group">

                <label for="category_id">Category_Id</label>
                {!! Form::textarea('category_id',null,[
                    'class'=>'form_control'

                ]) !!}

                </div>







    <div class="form_group">
    <button class="btn btn-primary" type="submit">Create</button>

    </div>















        {!! Form::close() !!}




      <!-- /.card-body -->

    </div>
    <!-- /.card -->
</div>
  </section>
  <!-- /.content -->
@endsection

















