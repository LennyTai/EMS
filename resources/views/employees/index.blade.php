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
<div class="card" style="padding-left: 20px; padding-right: 20px; padding-top: 15px; padding-bottom: 15px; width:100%">
    <h4 class="text-center"><b>Employee List</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            <a href="{{ route('employees.create') }}" style="color: white"><button class="btn btn-sm btn-success">Add</button></a>
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        <thead>
            <tr>
                <th>Emp ID</th>
                <th>Employee Name</th>
                <th>Internal Job Title</th>
                <th class="text-center">Status</th>
                <th class="text-center">At Work</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->emp_id }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->job_title() }}</td>
                <td class="text-center">
                    @if ($employee->job_status === 'JOINED')
                        <span class="label label-green">{{ $employee->job_status }}</span>
                    @elseif ($employee->job_status === 'PROBATION')
                        <span class="label label-blue">{{ $employee->job_status }}</span>
                    @elseif ($employee->job_status === 'RESIGNED')
                        <span class="label label-warning">{{ $employee->job_status }}</span>
                    @else
                        <span class="label label-pink">{{ $employee->job_status }}</span>
                    @endif
                </td>
                <td class="text-center">{{ $employee->getYearsOfServices() }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('employees.edit', $employee->id) }}" title="Edit" style="margin-top: 5px; color: gold;"><i class="material-icons">edit</i></a>&nbsp;
{{--                         {{ Form::model($employee, ['method' => 'POST','route' => ['employees.destroy', $employee->id]]) }}
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm" title="Delete" onclick="return ConfirmDelete()" type="submit" style="color: red; background-color: transparent;"><i class="material-icons">delete</i></button>
                        {{ Form::close() }} --}}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection