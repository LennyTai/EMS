@extends('layouts.app')
@section('content')
<style>
    .uper {
      margin-top: 40px;
    }
</style>
<div class="card uper">
    <div class="card-header">
        Employee Particular
    </div>
    <div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif

    @csrf
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('name', 'Employee Name') }}
                {{ Form::text('name', "$employee->name", ['class' => 'form-control', 'disabled' => '']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('nric', 'NRIC (Last 4 Character)') }}
                {{ Form::text('nric', "$employee->nric", ['class' => 'form-control', 'maxlength' => 4, 'disabled' => '']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('dob', 'Date of Birth') }}
                {{ Form::date('dob', $employee->dob, ['class' => 'form-control', 'disabled' => '', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('age', 'Age') }}
                {{ Form::text('age', $employee->getAge(), ['class' => 'form-control', 'disabled' => '', 'disabled' => '']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('contact', 'Contact') }}
                {{ Form::number('contact', "$employee->contact", ['class' => 'form-control', 'disabled' => '']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('email', 'Email') }}
                {{ Form::email('email', "$employee->email", ['class' => 'form-control', 'disabled' => '']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('gender', 'Gender') }}
                {{ Form::select('gender', __('message.gender'), $employee->gender, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('race', 'Race') }}
                {{ Form::select('race', __('message.race'), $employee->race, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('marital_status', 'Marital Status') }}
                {{ Form::select('marital_status', __('message.marital_status'), $employee->marital_status, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('religion', 'Religion') }}
                {{ Form::select('religion', __('message.religion'), $employee->religion, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('nationality', 'Nationality') }}
                {{ Form::select('nationality', __('message.nationality'), $employee->nationality, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('pr_status', 'SG PR Status') }}
                {{ Form::select('pr_status', __('message.pr_status'), $employee->pr_status, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('passport_no', 'Passport Number (Last 4 Character)') }}
                {{ Form::text('passport_no', "$employee->passport_no", ['class' => 'form-control', 'maxlength' => 4, 'disabled' => '']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('passport_exp_date', 'Passport Expired Date') }}
                {{ Form::date('passport_exp_date', $employee->passport_exp_date, ['class' => 'form-control', 'disabled' => '', 'max' => '2999-12-31']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('int_job_title', 'Job Title') }}
                {{ Form::select('int_job_title', __('message.int_job_title'), $employee->int_job_title, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('salary', 'Salary') }}
                {{ Form::number('salary', "$employee->salary", ['class' => 'form-control', 'disabled' => '']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('department_id', 'Department') }}
                {{ Form::select('department_id', $department, $employee->department_id, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('hod', 'HOD') }}
                {{ Form::text('hod', $employee->department->hod, ['class' => 'form-control', 'disabled' => '', 'disabled' => '']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('type_of_emp', 'Type of Employment') }}
                {{ Form::select('type_of_emp', __('message.type_of_emp'), "$employee->type_of_emp", ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('work_pass', 'Work Pass') }}
                {{ Form::select('work_pass', __('message.work_pass'), "$employee->work_pass", ['class' => 'form-control', 'disabled' => '', 'placeholder' => '[Please Select]']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('address', 'Address') }}
                {{ Form::textarea('address', $employee->address, ['class' => 'form-control', 'disabled' => '', 'rows' => '3']) }}
            </div>
        </div>
    </div>
</div>
@endsection