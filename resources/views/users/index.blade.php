@extends('layouts.app')

@section('content')


<div class='row'>
<div class='col-lg-12 '>
    <div class="card">
        <div class="card-header">
    <h3 class="card-title">Users Management</h3>
</div>
<div class="card-body">
<div class='pull-right'>
<a class='btn btn-success mb-3' href='{{ route('users.create') }}'> Create New User</a>
</div>


@if ($message = Session::get('success'))
<div class='alert alert-success'>
<p>{{ $message }}</p>
</div>
@endif

<table class='table table-bordered'>
<tr>
<th>No</th>
<th>Name</th>
<th>Email</th>
<th>Roles</th>
<th width='280px'>Action</th>
</tr>
@foreach ($data as $key => $user)
<tr>
<td>{{ ++$i }}</td>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>

@if($user->roles()->count())
@foreach($user->roles()->get() as $v)
{{-- @if(!empty($user->roles()))
@foreach($user->roles() as $v) --}}
<label class='badge badge-success'>{{ $v->name }}</label>
@endforeach
@endif

</td>
<td>
<a class='btn btn-info' href='{{ route('users.show',$user->id) }}'>Show</a>
<a class='btn btn-primary' href='{{ route('users.edit',$user->id) }}'>Edit</a>
{!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}
</td>
</tr>
@endforeach
</table>




{{-- <div class="card-tools">
    <ul class="pagination pagination-sm float-right">
    <li class="page-item"><a class="page-link" href='users.index'>«</a></li>
    <li class="page-item"><a class="page-link" href='users.index'>1</a></li>
    <li class="page-item"><a class="page-link" href='users.index'>2</a></li>
    <li class="page-item"><a class="page-link" href='users.index'>3</a></li>
    <li class="page-item"><a class="page-link" href='users.index'>»</a></li>
    </ul>
    </div>
 --}}




{!! $data->render() !!}

</div>
</div>
</div>
</div>


{{-- <p class='text-center text-primary'><small>Tutorial by http://rajtechnologies.com</small></p> --}}
@endsection

