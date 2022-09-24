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
        <h3 class="card-title"> list of posts</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">

      <a href="{{url(route('posts.create'))}}" class="btn btn-primary mb-3"><i class="fa fa-plus"> </i>New Post</a>
@include('flash::message')

      @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                    <th class="text-center">Content</th>

                                    <th class="text-center">Image</th>
                                    <th class="text-center">Category Name</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->title}}</td>
                                    <td class="text-center">{{$record->content}}</td>

                                    <td>
                                        <img src="{{asset('uploads/images/posts/'.$record->image)}}" >
                                    </td>

                                    <td class="text-center">{{$record->category->name}}</td>



                                    <td class="text-center">
                                        <a href="{{url(route('posts.edit',$record->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"> </i></a>
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open([

'action' => ['App\Http\Controllers\PostController@destroy', $record->id],
            'method' => 'delete'
                                        ]) !!}
                                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"> </i></button>
                                        {!!Form::close() !!}

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

      </div>

      @else
      <p class="text-center">No Posts</p>

      @endif
      <!-- /.card-body -->

    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
@endsection

















