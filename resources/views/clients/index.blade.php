@extends('layouts.app')
@section('page_title')
    list of clients
@endsection
@section('content')



    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> list of clients</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">




                <div class="filter">
                    {!! Form::open([
                        'method' => 'get',
                    ]) !!}

  
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::text('keyword', request('keyword'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'search with name, phone, email and city',
                                ]) !!}
                            </div>
                        </div>
                        @inject('bloodType', 'App\Models\BloodType')
                        <div class="col-sm-3">
                            {!! Form::select('blood_type_id', $bloodType->pluck('name', 'id')->toArray(), request('blood_type_id'), [
                                'class' => 'form-control',
                                'placeholder' => 'search with blood type',
                            ]) !!}
                        </div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">search</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>


                {{-- <a href="{{url(route('clients.create'))}}" class="btn btn-primary"><i class="fa fa-plus"> </i>New clients</a> --}}
                @include('flash::message')

                @if (count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>blood_type_id</th>
                                    <th>date_of_birth</th>
                                    <th>city_id</th>
                                    <th>last_donation_date</th>

                                    {{-- <th class="text-center">Edit</th> --}}
                                    <th class="text-center">Delete</th>

                                    <th class="text-center">activate/deactivate</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $record->name }}</td>
                                        <td>{{ $record->phone }}</td>
                                        <td>{{ $record->email }}</td>
                                        <td>{{ $record->blood_type_id }}</td>
                                        <td>{{ $record->date_of_birth }}</td>
                                        <td>{{ $record->city_id }}</td>
                                        <td>{{ $record->last_donation_date }}</td>
                                        {{-- <td class="text-center">
                                        <a href="{{url(route('clients.edit',$record->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"> </i></a>
                                    </td> --}}





                                        <td class="text-center">
                                            {!! Form::open([
                                                'action' => ['App\Http\Controllers\ClientController@destroy', $record->id],
                                                'method' => 'delete',
                                            ]) !!}
                                            <button type="submit" class="btn btn-danger btn-xs"><i
                                                    class="fa fa-trash"></i></button>

                                            {!! Form::close() !!}

                                        </td>




                                        <td class="text-center">
                                           @if ($record->is_active == 0)
                                            <a href="{{ url(route('clients.activate', $record->id)) }}"
                                                class="btn btn-success btn-xs">
                                                activate</a>

                                        @else

                                            <a href="{{ url(route('clients.deactivate', $record->id)) }}"
                                                class="btn btn-danger btn-xs">deactivate
                                            </a>
                                        </td>

                                        @endif


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                @else
                    <p class='text-center h3'>No Data</p>
                @endif
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
