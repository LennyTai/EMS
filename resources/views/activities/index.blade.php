@extends('layouts.app')
@section('content')

{{-- DataTable --}}
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
    <h4 class="text-center"><b>User Activity Logs ( 1 Year Only )</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            {{ link_to(URL::previous(), 'Back', ['class' => 'btn btn-sm btn-primary', 'style' => 'float: right']) }}
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        <thead>
            <tr>
                <td><b>No</b></td>
                <td><b>Subject</b></td>
                <td><b>Module</b></td>
                <td><b>Description</b></td>
                <td><b>By User</b></td>
                <td><b>Time</b></td>
                <td><b>Updated at</b></td>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $activity->getName() }}</td>
                <td>{{ $activity->getModule() }}</td>
                <td>{{ $activity->description }}</td>
                <td>{{ $activity->log_name }}</td>
                <td>{{ $activity->created_at->diffForHumans() }}</td>
                <td>{{ $activity->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection