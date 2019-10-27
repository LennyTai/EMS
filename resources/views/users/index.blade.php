@extends('layouts.app')
@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
@if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}  
    </div><br/>
@endif
<div class="card" style="padding-left: 20px; padding-right: 20px; padding-top: 15px; padding-bottom: 15px; wuser_idth:100%">
    <h4 class="text-center"><b>User Management</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            <a href="{{ route('users.create') }}" style="color: white"><button class="btn btn-sm btn-success">Add</button></a>
            &nbsp;&nbsp;
            {{ link_to(URL::previous(), 'Back', ['class' => 'btn btn-sm btn-primary']) }}
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        @if (empty($users->id))
        <thead>
            <tr>
                <th>No</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if(!empty($user->roles))
                        @foreach($user->roles as $role)
                            <label class="label label-success" style="font-size: 12px">{{ $role->display_name }}</label>
                        @endforeach
                    @endif
                </td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('users.edit', $user->id) }}" title="Edit" style="margin-top: 5px; color: gold;"><i class="material-icons">edit</i></a>&nbsp;
{{--                         {{ Form::model($user, ['method' => 'POST','route' => ['users.destroy', $user->id]]) }} --}}
                        @csrf
{{--                         @method('DELETE')
                        <button class="btn btn-sm" title="Delete" onclick="return ConfirmDelete()" type="submit" style="color: red; background-color: transparent;"><i class="material-icons">delete</i></button> --}}
                        {{ Form::close() }}
                    </div>
                </td>
            </tr>
            @endforeach
        @else
            {!! __('No Record Found...') !!}
        @endif
        @csrf
        </tbody>
    </table>
</div>
@endsection