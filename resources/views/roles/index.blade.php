@extends('layouts.app')

@section('content')
<div class='row'>
<div class='col-lg-12'>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Role Management</h3>
    </div>

    <div class="card-body">
        <div class='pull-right'>
            {{-- @can('role-create') --}}
            <a class='btn btn-success mb-3' href='{{ route('roles.create')}}'> Create New Role</a>
            {{-- @endcan --}}
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
<th>Display_Name</th>
<th>Description</th>
<th width='280px'>Action</th>
</tr>
@foreach ($roles as $key => $role)
<tr>
<td>{{ ++$i }}</td>
<td>{{ $role->name }}</td>
<td>{{$role->display_name}}</td>
<td>{{$role->description}}</td>



<td>
<a class='btn btn-info' href='{{ route('roles.show',$role->id) }}'>Show</a>
{{-- @can('role-edit') --}}
<a class='btn btn-primary' href='{{ route('roles.edit',$role->id) }}'>Edit</a>
{{-- @endcan --}}
{{-- @can('role-delete') --}}
{!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}
{{-- @endcan --}}
</td>
</tr>
@endforeach
</table>

{!! $roles->render() !!}
    </div>
</div>
</div>
</div>



{{-- <p class='text-center text-primary'><small>project by Zeinab Amin</small></p> --}}
@endsection
