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
    <h4 class="text-center"><b>{{ $emp_name }} Disciplinaries</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            <a href="{{ route('disciplinaries.create', $emp_id) }}" style="color: white"><button class="btn btn-sm btn-success">Add</button></a>
            &nbsp;&nbsp;
            <a href="{{ route('employees.edit', $emp_id) }}" style="color: white"><button class="btn btn-sm btn-primary">Back</button></a>
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        @if (empty($disciplinaries->id))
        <thead>
            <tr>
                <th>ID</th>
                <th>Incident</th>
                <th>Type of Discipline</th>
                <th>Issued Date</th>
                <th>Written Warning</th>
                <th>Correction</th>
                <th>Remarks</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($disciplinaries as $disciplinary)
            <tr>
                <td>{{ $disciplinary->id }}</td>
                <td>{{ $disciplinary->incident }}</td>
                <td>{{ $disciplinary->TOD }}</td>
                <td>{{ $disciplinary->issued_date }}</td>
                <td>{{ $disciplinary->w_warning }}</td>
                <td>{{ $disciplinary->correction }}</td>
                <td>{{ $disciplinary->remarks }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('disciplinaries.edit', $disciplinary->id, $emp_id) }}" title="Edit" style="margin-top: 5px; color: gold;"><i class="material-icons">edit</i></a>&nbsp;
                        @csrf
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