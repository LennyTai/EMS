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
{{ Form::model($grant_payment, ['method' => 'PATCH','route' => ['grant_payments.update', $grant_payment->id], 'enctype' => 'multipart/form-data']) }}
@csrf
<div class="card">
    <div class="card-header">
        <b>Edit Grant</b>
    </div>
    <div class="card-body">
        <div class="row">
            {{ Form::hidden('grant_id', $grant_payment->grant_id) }}
            <div class="form-group col-sm-3">
                {{ Form::label('payment_no', 'Payment Number', ['class' => 'required']) }}
                {{ Form::select('payment_no', __('message.payment_no'), $grant_payment->payment_no, ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
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
            <div class="form-group col-sm-3">
                {{ Form::label('grant_payment_amt', 'Payment Amount') }}
                {{ Form::label('', 'SGD '.number_format($grant_payment->grantPayment(), 2), ['class' => 'form-control', 'disabled' => '']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('grant_payment_bal', 'Payment Balance') }}
                {{ Form::label('', 'SGD '.number_format($grant_payment->grantBalance(), 2), ['class' => 'form-control', 'disabled' => '']) }}
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
                            @if ($grant_payment->filename)
                                {{ Form::open(['url' => ['/uploads', $grant_payment->id. '/grant_payments'], 'files'=> true]) }}
                                <a href="{{ route('dl_grant_payment', $grant_payment->id) }}">{{ $grant_payment->filename }}</a>
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
            {{ link_to(URL::route('grant_payments.index', $grant_id), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
        {{ Form::close() }}
        <hr>
    </div>
</div>
@endsection