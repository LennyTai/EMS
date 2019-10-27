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
    <h4 class="text-center"><b>PCP SCALA List</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            <a href="{{ route('grants.create') }}" style="color: white"><button class="btn btn-sm btn-success">Add</button></a>
{{--             &nbsp;&nbsp;
            {{ link_to(URL::previous(), 'Back', ['class' => 'btn btn-sm btn-primary', 'style' => 'float: right']) }} --}}
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        <thead>
            <tr>
                <td><b>No.</b></td>
                <td><b>Employee Name</b></td>
                <td><b>Duration</b></td>
                <td><b>Status</b></td>
                <td><b>Age</b></td>
                <td><b>Monthly Salary</b></td>
                <td><b>Monthly Grant</b></td>
                <td class="text-center"><b>Action</b></td>
            </tr>
        </thead>
        <tbody>
            @foreach($grants as $grant)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ route('employees.edit',$grant->employee_id) }}" title="Edit" style="color: blue;">{{ $grant->emp_name() }}</a>
                </td>
                <td>{{ $grant->course }}</td>
                <td>{{ $grant->status }}</td>
                <td>{{ $grant->employee->getAge() }}</td>
                <td>{{ number_format($grant->salaries(), 2) }}</td>
                <td>{{ number_format($grant->grants(), 2) }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('grants.edit',$grant->id) }}" title="Edit" style="margin-top: 5px; color: gold;"><i class="material-icons">edit</i></a>&nbsp;
{{--                         {{ Form::model($grant, ['method' => 'POST','route' => ['grants.destroy', $grant->id]]) }}
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm" title="Delete" onclick="return ConfirmDelete()" type="submit" style="color: red; background-color: transparent;"><i class="material-icons">delete</i></button> --}}
                        {{ Form::close() }}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection