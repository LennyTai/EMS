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
<div class="card" style="padding-left: 20px; padding-right: 20px; padding-top: 15px; padding-bottom: 15px; wrole_idth:100%">
    <h4 class="text-center"><b>Role Management</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            <a href="{{ route('roles.create') }}" style="color: white"><button class="btn btn-sm btn-success">Add</button></a>
            &nbsp;&nbsp;
            {{ link_to(URL::previous(), 'Back', ['class' => 'btn btn-sm btn-primary']) }}
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        @if (empty($roles->id))
        <thead>
            <tr>
                <th>No</th>
                <th>Role Name</th>
                <th>Description</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->description }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('roles.edit', $role->id) }}" title="Edit" style="margin-top: 5px; color: gold;"><i class="material-icons">edit</i></a>&nbsp;
{{--                         {{ Form::model($role, ['method' => 'POST','route' => ['roles.destroy', $role->id]]) }} --}}
                        @csrf
                        @method('DELETE')
{{--                         <button class="btn btn-sm" title="Delete" onclick="return ConfirmDelete()" type="submit" style="color: red; background-color: transparent;"><i class="material-icons">delete</i></button> --}}
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