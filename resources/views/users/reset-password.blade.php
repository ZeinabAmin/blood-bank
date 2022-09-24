@extends('layouts.app')
@section('page_title')
    Change Password
@endsection

@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">

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

                {!! Form::open([
                    'action' => 'App\Http\Controllers\UserController@changePasswordSave',
                    'method' => 'POST',
                ]) !!}


@include('partials.validation_errors')
@include('flash::message')

                <div class="form-group">
                    <label for="name">Name:</label>
                    {!! Form::text('name',null, [
                        'class' => 'form-control',
                    ]) !!}

                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    {!! Form::text('email',null, [
                        'class' => 'form-control',
                    ]) !!}

                </div>

                <div class="form-group">
                    <label for="old-password">Old-Password:</label>
                    {!! Form::password('old-password', null, [
                        'class' => 'form-control',
                    ]) !!}

                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    {!! Form::password('password',null, [
                        'class' => 'form-control',
                    ]) !!}

                </div>
                <div class="form-group">
                    <label for="password_confirmation">Password_Confirmation:</label>
                    {!! Form::password('password_confirmation',null, [
                        'class' => 'form-control',
                    ]) !!}
                </div>


                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>


                {!! Form::close() !!}

            </div>
        </div>

    </section>
@endsection
