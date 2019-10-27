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
    <h4 class="text-center"><b>{{ $emp_name }} Family Member</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            <a href="{{ route('families.create', $emp_id) }}" style="color: white"><button class="btn btn-sm btn-success">Add</button></a>
            &nbsp;&nbsp;
            <a href="{{ route('employees.edit', $emp_id) }}" style="color: white"><button class="btn btn-sm btn-primary">Back</button></a>
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        @if (empty($families->id))
        <thead>
            <tr>
                <th>ID</th>
                <th>Family Name</th>
                <th>Relationship</th>
                <th>Age</th>
                <th>Contact</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($families as $family)
            <tr>
                <td>{{ $family->id }}</td>
                <td>{{ $family->family_name }}</td>
                <td>{{ $family->relationship }}</td>
                <td>{{ $family->getAge() }}</td>                
                <td>{{ $family->family_contact }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('families.edit', $family->id, $emp_id) }}" title="Edit" style="margin-top: 5px; color: gold;"><i class="material-icons">edit</i></a>&nbsp;
{{--                         {{ Form::model($family, ['method' => 'POST','route' => ['families.destroy', $family->id]]) }}
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm" title="Delete" onclick="return ConfirmDelete()" type="submit" style="color: red; background-color: transparent;"><i class="material-icons">delete</i></button>
                        {{ Form::close() }} --}}
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