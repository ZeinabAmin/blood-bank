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
                <h3 class="card-title"> list of Donation Requests</h3>

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



                @include('flash::message')

                @if (count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>patient name</th>
                                    <th>patient phone</th>
                                    <th>client_id</th>
                                    <th>city_id</th>
                                    <th>hospital_name</th>
                                    <th>blood_type_id</th>
                                    <th>patient_age</th>
                                    <th>bags_num</th>
                                    <th>hospital_address</th>
                                    <th>details</th>
                                     <th>latitude</th>
                                       <th>longitude</th>

                                    <th class="text-center">Delete</th>



                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $record->patient_name }}</td>
                                        <td>{{ $record->patient_phone }}</td>
                                        <td>{{ $record->client_id }}</td>
                                        <td>{{ $record->city_id }}</td>
                                        <td>{{ $record->hospital_name }}</td>
                                        <td>{{ $record->blood_type_id }}</td>
                                        <td>{{ $record->patient_age }}</td>
                                        <td>{{ $record->bags_num }}</td>
                                        <td>{{ $record->hospital_address }}</td>
                                        <td>{{ $record->details }}</td>
                                        <td>{{ $record->latitude }}</td>
                                        <td>{{ $record->longitude }}</td>






                                        <td class="text-center">
                                            {!! Form::open([
                                                'action' => ['App\Http\Controllers\DonationRequestController@destroy', $record->id],
                                                'method' => 'delete',
                                            ]) !!}
                                            <button type="submit" class="btn btn-danger btn-xs"><i
                                                    class="fa fa-trash"></i></button>

                                            {!! Form::close() !!}

                                        </td>





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
