@extends('layouts.app')
@section('content')
{{ Form::model($employee, ['action' => 'EmployeeController@store', 'enctype' => 'multipart/form-data']) }}
@csrf
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
    </div>
@endif
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    @include('employees/personalDetail')
                </div>
                <div class="col-sm-6">
                    @include('employees/statusBar')
                </div>
            </div>
            <br>
            <h5><b>Personal Particular</b></h5>
            <hr>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('dob', 'Date of Birth', ['class' => 'required']) }}
                    {{ Form::date('dob', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('age', 'Age') }}
                    {{ Form::text('age', '', ['class' => 'form-control', 'disabled' => '']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('contact', 'Mobile Contact') }}
                    {{ Form::number('contact', '', ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::email('email', '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('nationality', 'Nationality') }}
                    {{ Form::select('nationality', __('message.nationality'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('gender', 'Gender') }}
                    {{ Form::select('gender', __('message.gender'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('race', 'Race') }}
                    {{ Form::select('race', __('message.race'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('marital_status', 'Marital Status') }}
                    {{ Form::select('marital_status', __('message.marital_status'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('pr_status', 'SG PR Status (Optional)') }}
                    {{ Form::select('pr_status', __('message.pr_status'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('pr_date', 'SG PR Date') }}
                    {{ Form::date('pr_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('passport_no', 'Passport Number (Last 4 Digit)') }}
                    {{ Form::text('passport_no', '', ['class' => 'form-control', 'maxlength' => 4]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('passport_exp_date', 'Passport Expired Date') }}
                    {{ Form::date('passport_exp_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('address', 'Address') }}
                    {{ Form::textarea('address', '', ['class' => 'form-control', 'rows' => '3']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('remarks', 'Remarks (Optional)') }}
                    {{ Form::textarea('remarks', '', ['class' => 'form-control', 'rows' => '3']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('bank_name', 'Bank Name') }}
                    {{ Form::select('bank_name', __('message.bank_name'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('bank_acc_no', 'Bank Account No.') }}
                    {{ Form::text('bank_acc_no', '', ['class' => 'form-control']) }}
                </div>
            </div>
            <br><h5><b>Job Details</b></h5>
            <hr>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('emp_status', 'Employment Status') }}
                    {{ Form::select('emp_status', __('message.emp_status'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('joint_date', 'Joined Date', ['class' => 'required']) }}
                    {{ Form::date('joint_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('confirmed_date', 'Confirmed Date', ['class' => 'required']) }}
                    {{ Form::date('confirmed_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('leave_date', 'Leaved Date') }}
                    {{ Form::date('leave_date', '', ['class' => 'form-control', 'max' => '2999-12-31', 'disabled' => '']) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('work_pass', 'Work Pass (Optional)') }}
                    {{ Form::select('work_pass', __('message.work_pass'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('fin_no', 'FIN Number (Last 4 Digit)') }}
                    {{ Form::text('fin_no', '', ['class' => 'form-control', 'maxlength' => 4]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('wp_app_date', 'Work Pass Application Date') }}
                    {{ Form::date('wp_app_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('wp_exp_date', 'Work Pass Expired Date') }}
                    {{ Form::date('wp_exp_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
            </div>
            <hr>
            @permission ('create')
            {{ Form::submit('Add', ['class' => 'btn btn-success', 'onclick' => 'return ConfirmSave()']) }}
            {{ Form::close() }}
            @endpermission
            {{ link_to(URL::route('employees.index'), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
            </div>
        </div>
    </div>
</div>
@endsection