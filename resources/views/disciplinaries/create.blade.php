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
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
            <h5><b>{{ $disciplinary->employee->name }} Disciplinaries</b></h5>
            <hr>
                {{ Form::model($employee, ['action' => ['DisciplinaryController@store'], 'enctype' => 'multipart/form-data']) }}
                @csrf
            <div class="row">
                {{ Form::hidden('employee_id', $disciplinary->employee->id) }}
                <div class="form-group col-sm-3">
                    {{ Form::label('incident', 'Incident', ['class' => 'required']) }}
                    {{ Form::text('incident', '', ['class' => 'form-control']) }}
                </div>
               <div class="form-group col-sm-3">
                    {{ Form::label('TOD', 'Type of Discipline', ['class' => 'required']) }}
                    {{ Form::select('TOD', __('message.TOD'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('issued_date', 'Issued Date', ['class' => 'required']) }}
                    {{ Form::date('issued_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('review_date', 'Review Date') }}
                    {{ Form::date('review_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('correction', 'Correction') }}
                    {{ Form::textarea('correction', '', ['class' => 'form-control', 'rows' => '3']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('remarks', 'Remarks', ['class' => 'required']) }}
                    {{ Form::textarea('remarks', '', ['class' => 'form-control', 'rows' => '3']) }}
                </div>
               <div class="form-group col-sm-3">
                    {{ Form::label('v_warning', 'Verbal Warning') }}
                    {{ Form::select('v_warning', __('message.v_warning'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('w_warning', 'Written Warning') }}
                    {{ Form::select('w_warning', __('message.w_warning'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('attachment', 'Attachment') }}
                </div>
                <div class="form-group col-sm-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input" data-trigger="fileinput">
                                @if ($disciplinary->filename)
                                    {{ Form::open(['url' => ['/uploads', $disciplinary->id. '/disciplinaries'], 'files'=> true]) }}
                                    <a href="{{ route('dl_disciplinary', $disciplinary->id) }}">{{ $disciplinary->filename }}</a>
                                    {{ Form::close() }}
                                @else
                                    <span>No attachment found...</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-5">
                    <input type="file" name="uploaded">
                </div>
            </div>
            <hr>
            {{ Form::submit('Add', ['class' => 'btn btn-success', 'onclick' => 'return ConfirmSave()']) }}
            {{ link_to(URL::route('disciplinaries.index', $employee->id), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
            {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection