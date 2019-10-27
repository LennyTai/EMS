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
            <h5><b>{{ $allowance->employee->name }} Allowances</b></h5>
            <hr>
                {{ Form::model($employee, ['action' => ['AllowanceController@store'], 'enctype' => 'multipart/form-data']) }}
                @csrf
            <div class="row">
                {{ Form::hidden('employee_id', $allowance->employee->id) }}
                <div class="form-group col-sm-3">
                    {{ Form::label('TOA', 'Type of Allowance', ['class' => 'required']) }}
                    {{ Form::select('TOA', __('message.TOA'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('allowance_amt', 'Allowance Amount', ['class' => 'required']) }}
                    {{ Form::number('allowance_amt', '', ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('issued_date', 'Issued Date', ['class' => 'required']) }}
                    {{ Form::date('issued_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('received_date', 'Received Date') }}
                    {{ Form::date('received_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('remarks', 'Remarks') }}
                    {{ Form::textarea('remarks', '', ['class' => 'form-control', 'rows' => '3']) }}
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
                                @if ($allowance->filename)
                                    {{ Form::open(['url' => ['/uploads', $allowance->id. '/allowances'], 'files'=> true]) }}
                                    <a href="{{ route('dl_allowance', $allowance->id) }}">{{ $allowance->filename }}</a>
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
            {{ link_to(URL::route('allowances.index', $employee->id), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
            {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection