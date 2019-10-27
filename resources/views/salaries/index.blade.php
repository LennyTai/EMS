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
    <h4 class="text-center"><b>{{ $emp_name }} Salary & Job Progression</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            <a href="{{ route('salaries.create', $emp_id) }}" style="color: white"><button class="btn btn-sm btn-success">Add</button></a>
            &nbsp;&nbsp;
            <a href="{{ route('employees.edit', $emp_id) }}" style="color: white"><button class="btn btn-sm btn-primary">Back</button></a>
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        @if (empty($salaries->id))
        <thead>
            <tr>
                <th>No</th>
                <th>Internal Job Title</th>
                <th>Department</th>
                <th>Changes</th>
                <th>Salary (SGD)</th>
                <th>Salary Adjustment</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaries as $salary)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $salary->int_job_title }}</td>
                <td>{{ $salary->dpt_name }}</td>
                <td>{{ $salary->promotion }}</td>
                <td>{{ $salary->salary }}</td>
                <td>{{ $salary->salary_adjust }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('salaries.edit', $salary->id, $emp_id) }}" title="Edit" style="margin-top: 5px; color: gold;"><i class="material-icons">edit</i></a>&nbsp;
                        @csrf
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