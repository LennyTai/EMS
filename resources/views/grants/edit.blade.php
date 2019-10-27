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
{{ Form::model($grant, ['method' => 'PATCH','route' => ['grants.update', $grant->id], 'enctype' => 'multipart/form-data']) }}
@csrf
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                {{ 'Condition 1: Salary Cap at <=4000 AND age < 40 THEN 70% claim duration of course' }}<br>
                {{ 'Condition 2: Salary Cap at <= 6000 AND age >= 40 THEN 90% claim duration of course' }}
            </div>
        </div>
        <div class="row text-center">
            <div class="card col-sm-3">
                <div class="card-body">
                    {{ Form::label('salary', 'Monthly Salary') }}
                    <div class="metric-value d-inline-block">
                        <span class="label label-green" style="font-size:15px;white-space: normal;">
                            {{ 'SGD '.number_format($grant->salaries(), 2) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card col-sm-3">
                <div class="card-body">
                    {{ Form::label('salary', 'Total Grant') }}
                    <div class="metric-value d-inline-block">
                        <span class="label label-purple" style="font-size:15px;white-space: normal;">
                            {{ 'SGD '.number_format($grant->grants() * 12, 2) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card col-sm-3">
                <div class="card-body">
                    {{ Form::label('salary', 'Grant Per Quarter') }}
                    <div class="metric-value d-inline-block">
                        <span class="label label-blue" style="font-size:15px;white-space: normal;">
                            {{ 'SGD '.number_format($grant->grantPayment(), 2) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card col-sm-3">
                <div class="card-body">
                    {{ Form::label('salary', 'Grant Balance') }}
                    <div class="metric-value d-inline-block">
                        <span class="label label-pink" style="font-size:15px;white-space: normal;">
                            {{ 'SGD '.number_format($balance, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-header">
        <b>Edit Grant</b>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('employee_id', 'Employee Name', ['class' => 'required']) }}
                {{ Form::select('employee_id', $employee, $grant->employee_id, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('program', 'Program', ['class' => 'required']) }}
                {{ Form::select('program', __('message.program'), $grant->program, ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('course', 'Duration', ['class' => 'required']) }}
                {{ Form::select('course', __('message.course'), $grant->course, ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('status', 'Status', ['class' => 'required']) }}
                {{ Form::select('status', __('message.course_status'), $grant->status, ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('date_of_application', 'Date of Application') }}
                {{ Form::date('date_of_application', $grant->date_of_application, ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('date_of_acceptance', 'Date of Acceptance') }}
                {{ Form::date('date_of_acceptance', $grant->date_of_acceptance, ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('date_of_form_submission', 'Date of Form Submission') }}
                {{ Form::date('date_of_form_submission', $grant->date_of_form_submission, ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('dos_loa', 'Date of Submission (LOA)') }}
                {{ Form::date('dos_loa', $grant->dos_loa, ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('dos_jd', 'Date of Submission (JD)') }}
                {{ Form::date('dos_jd', $grant->dos_jd, ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('start_date', 'Start Date of Program') }}
                {{ Form::date('start_date', $grant->start_date, ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('end_date', 'End Date of Program') }}
                {{ Form::date('end_date', $grant->end_date, ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('no_of_class', 'Number of Class') }}
                {{ Form::number('no_of_class', $grant->no_of_class, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('loajd', 'External Job Desciption') }}
                {{ Form::textarea('loajd', $grant->loajd, ['class' => 'form-control', 'rows' => '3']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('grant payment', 'Grant Payments') }}
                <a href="{{ route('grant_payments.index', $grant->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Click Here<span class="badge badge-primary badge-pill">{{ $grant->grant_payments->count() }}</span></a>
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
                            @if ($grant->filename)
                                {{ Form::open(['url' => ['/uploads', $grant->id. '/grants'], 'files'=> true]) }}
                                <a href="{{ route('dl_grant', $grant->id) }}">{{ $grant->filename }}</a>
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
        {{ Form::submit('Update', ['class' => 'btn btn-success', 'onclick' => 'return ConfirmSave()']) }}
        {{ link_to(URL::route('grants.index'), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection