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
<div class="card">
    <div class="card-header">
        <b>Add</b>
    </div>
    <div class="card-body">
    {{ Form::model($grant, ['action' => 'GrantController@store']) }}
    @csrf
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('employee_id', 'Employee Name', ['class' => 'required']) }}
                {{ Form::select('employee_id', $employee, '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('program', 'Program', ['class' => 'required']) }}
                {{ Form::select('program', __('message.program') , '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('course', 'Duration', ['class' => 'required']) }}
                {{ Form::select('course', __('message.course'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('status', 'Status', ['class' => 'required']) }}
                {{ Form::select('status', __('message.course_status'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('date_of_application', 'Date of Application') }}
                {{ Form::date('date_of_application', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('date_of_acceptance', 'Date of Acceptance') }}
                {{ Form::date('date_of_acceptance', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('date_of_form_submission', 'Date of Form Submission') }}
                {{ Form::date('date_of_form_submission', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('dos_loa', 'Date of Submission (LOA)') }}
                {{ Form::date('dos_loa', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('dos_jd', 'Date of Submission (JD)') }}
                {{ Form::date('dos_jd', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('start_date', 'Start Date of Program') }}
                {{ Form::date('start_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('end_date', 'End Date of Program') }}
                {{ Form::date('end_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('no_of_class', 'Number of Class') }}
                {{ Form::number('no_of_class', '', ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('loajd', 'External Job Desciption') }}
                {{ Form::textarea('loajd', '', ['class' => 'form-control', 'rows' => '3']) }}
            </div>
        </div>
        <hr>
        {{ Form::submit('Add', ['class' => 'btn btn-success', 'onclick' => 'return ConfirmSave()']) }}
        {{ link_to(URL::route('grants.index'), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection