@extends('layouts.app')
@section('content')
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br/>
@endif
{{ Form::model($attachment, ['method' => 'PATCH', 'route' => ['attachments.update', $attachment->id], 'enctype' => 'multipart/form-data']) }}
@csrf
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
            <h5><b>{{ $attachment->employee->name }} Attachments</b></h5>
            <hr>
            <div class="row">
                {{ Form::hidden('employee_id', $attachment->employee->id) }}
                <div class="form-group col-sm-3">
                    {{ Form::label('type', 'Type of Attachment', ['class' => 'required']) }}
                    {{ Form::select('type', __('message.attach_type'), $attachment->type, ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-9">
                    {{ Form::label('attachment', 'Attachment', ['class' => 'required']) }}
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input" data-trigger="fileinput">
                                {{ Form::open(['url' => ['/uploads', $attachment->id. '/attachments'], 'files'=> true]) }}
                                <a href="{{ route('dl_attachment', $attachment->id) }}" style="color: blue;">{{ $attachment->filename }}</a>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            {{ Form::submit('Update', ['class' => 'btn btn-success', 'onclick' => 'return ConfirmSave()']) }}
            {{ link_to(URL::route('attachments.index', $employee->id), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
            {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection