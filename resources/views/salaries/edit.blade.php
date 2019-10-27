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
{{ Form::model($salary, ['method' => 'PATCH', 'route' => ['salaries.update', $salary->id], 'enctype' => 'multipart/form-data']) }}
@csrf
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

{{-- Salary Particular --}}
            <h5><b>{{ $salary->employee->name }} Salary & Job Progression</b></h5>
            <hr>
            <div class="row">
                {{ Form::hidden('employee_id', $salary->employee->id) }}
                <div class="form-group col-sm-3">
                    {{ Form::label('int_job_title', 'Internal Job Title', ['class' => 'required']) }}
                    {{ Form::select('int_job_title', __('message.int_job_title'), "$salary->int_job_title", ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('ext_job_title', 'External Job Title', ['class' => 'required']) }}
                    {{ Form::select('ext_job_title', __('message.ext_job_title'), "$salary->ext_job_title", ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('dpt_name', 'Department', ['class' => 'required']) }}
                    {{ Form::select('dpt_name', __('message.department'), $salary->dpt_name, ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('entity', 'Entity', ['class' => 'required']) }}
                    {{ Form::select('entity', __('message.entity'), "$salary->entity", ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('hod', 'Head of Department') }}
                    {{ Form::select('hod', $employees, $salary->hod, ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('salary', 'Salary') }}
                    {{ Form::number('salary', $salary->salary, ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('salary_adjust', 'Salary Adjustment') }}
                    {{ Form::select('salary_adjust', __('message.salary_adjust'), "$salary->salary_adjust", ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('promotion', 'Changes') }}
                    {{ Form::select('promotion', __('message.promotion'), "$salary->promotion", ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('appraisal', 'Appraisal') }}
                    {{ Form::textarea('appraisal', $salary->appraisal, ['class' => 'form-control', 'rows' => '3']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('remarks', 'Remarks', ['class' => 'required']) }}
                    {{ Form::textarea('remarks', $salary->remarks, ['class' => 'form-control', 'rows' => '3']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('date', 'Start Date', ['class' => 'required']) }}
                    {{ Form::date('date', $salary->date, ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
            </div>
            {{-- Documents --}}
            <hr>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('attachment', 'Attachment') }}
                </div>
                <div class="form-group col-sm-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input" data-trigger="fileinput">
                                @if ($salary->filename)
                                    {{ Form::open(['url' => ['/uploads', $salary->id. '/salaries'], 'files'=> true]) }}
                                    <a href="{{ route('dl_salary', $salary->id) }}">{{ $salary->filename }}</a>
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
            {{ Form::close() }}
            {{ link_to(URL::route('salaries.index', $emp_id), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
            </div>
        </div>
    </div>
</div>
@endsection