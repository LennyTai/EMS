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
    <h4 class="text-center"><b>{{ $emp_name }} Attachments</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            <a href="{{ route('attachments.create', $emp_id) }}" style="color: white"><button class="btn btn-sm btn-success">Upload</button></a>
            &nbsp;&nbsp;
            <a href="{{ route('employees.edit', $emp_id) }}" style="color: white"><button class="btn btn-sm btn-primary">Back</button></a>
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        @if (empty($attachments->id))
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Attachment (Can Download)</th>
                <th>Updated At</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attachments as $attachment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $attachment->type }}</td>
                <td>
                    {{ Form::open(['url' => ['/uploads', $attachment->id. '/attachments'], 'files'=> true]) }}
                    <a href="{{ route('dl_attachment', $attachment->id) }}" style="color: blue;">{{ $attachment->filename }}</a>
                    {{ Form::close() }}
                </td>
                <td>{{ $attachment->updated_at->format('d-m-Y') }}</td>
                <td class="text-center">
                    <div class="btn-group">
{{--                         <a href="{{ route('attachments.edit', $attachment->id, $emp_id) }}" title="Edit" style="margin-top: 5px; color: gold;"><i class="material-icons">edit</i></a>&nbsp; --}}
                        @csrf
                        {{ Form::close() }}

                        {{ Form::model($attachment, ['method' => 'POST','route' => ['attachments.destroy', $attachment->id]]) }}
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm" title="Delete" onclick="return ConfirmDelete()" type="submit" style="color: red; background-color: transparent;"><i class="material-icons">delete</i></button>
                        {{ Form::close() }}
                    </div>
                </td>
            </tr>
            @endforeach
        @else
            {!! __('No Attachment Found...') !!}
        @endif
        @csrf
        </tbody>
    </table>
</div>
@endsection