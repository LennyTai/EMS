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
    {{ Form::model($grant_payment, ['action' => 'GrantPaymentController@store', 'enctype' => 'multipart/form-data']) }}
    @csrf
        <div class="row">
            {{ Form::hidden('grant_id', $grant->id) }}
            <div class="form-group col-sm-3">
                {{ Form::label('payment_no', 'Payment Number', ['class' => 'required']) }}
                {{ Form::select('payment_no', __('message.payment_no'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('payment_due_date', 'Payment Due Date', ['class' => 'required']) }}
                {{ Form::date('payment_due_date', $grant_payment->payment_due_date, ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('payment_date', 'Payment Date') }}
                {{ Form::date('payment_date', $grant_payment->payment_date, ['class' => 'form-control', 'max' => '2999-12-31']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('cheque_no', 'Cheque Number') }}
                {{ Form::text('cheque_no', $grant_payment->cheque_no, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('ojt_submit', 'OJT Submited') }}
                {{ Form::number('ojt_submit', $grant_payment->ojt_submit, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('payment_status', 'Payment Status') }}
                {{ Form::select('payment_status', __('message.payment_status'), $grant_payment->payment_status, ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('payment_amt', 'Amount Paid (SGD)') }}
                {{ Form::number('payment_amt', $grant_payment->payment_amt, ['class' => 'form-control']) }}
            </div>
        </div>
        <hr>
        {{ Form::submit('Add', ['class' => 'btn btn-success', 'onclick' => 'return ConfirmSave()']) }}
        {{ link_to(URL::route('grant_payments.index', $grant->id), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection