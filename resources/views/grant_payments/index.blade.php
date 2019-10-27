@extends('layouts.app')
@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
@if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}  
    </div><br/>
@endif
<div class="card" style="padding-left: 20px; padding-right: 20px; padding-top: 15px; padding-bottom: 15px; width:100%">
    <h4 class="text-center"><b>{{ $grant->program.' '.$grant->course }} Payment List</b></h4>
    <div class="row">
        <div class="col-md-4 btn-group">
            <a href="{{ route('grant_payments.create', $grant->id) }}" style="color: white"><button class="btn btn-sm btn-success">Add</button></a>
            &nbsp;&nbsp;
            <a href="{{ route('grants.edit', $grant->id) }}" style="color: white"><button class="btn btn-sm btn-primary">Back</button></a>
        </div>
    </div>
    <br>
    <table id="example" class="stripe row-border hover display compact cell-border">
        <thead>
            <tr>
                <td><b>No.</b></td>
                <td><b>Employee Name</b></td>
                <td><b>Payment No.</b></td>                
                <td><b>Due Date</b></td>
                <td><b>Status</b></td>
                <td><b>Amount Paid</b></td>
                <td><b>Balance</b></td>
                <td class="text-center"><b>Action</b></td>
            </tr>
        </thead>
        <tbody>
            @foreach($grant_payments as $grant_payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $grant->emp_name() }}</td>
                <td>{{ $grant_payment->payment_no }}</td>
                <td>{{ $grant_payment->payment_due_date->format('d-m-Y') }}</td>
                <td>{{ $grant_payment->payment_status }}</td>
                <td>{{ 'SGD '.number_format($grant_payment->payment_amt, 2) }}</td>
                <td>{{ 'SGD '.number_format($grant_payment->grantBalance(), 2) }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('grant_payments.edit',$grant_payment->id) }}" title="Edit" style="margin-top: 5px; color: gold;"><i class="material-icons">edit</i></a>&nbsp;
{{--                         {{ Form::model($grant, ['method' => 'POST','route' => ['grants.destroy', $grant->id]]) }}
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm" title="Delete" onclick="return ConfirmDelete()" type="submit" style="color: red; background-color: transparent;"><i class="material-icons">delete</i></button> --}}
                        {{ Form::close() }}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <div class="row text-center">
        <div class="col-sm-6">
            {{ Form::label('salary', 'Number of Payment') }}
            <div class="metric-value d-inline-block">
                <span class="label label-pink" style="font-size:15px;white-space: normal;">
                    {{ $grant_payments->count() }}
                </span>
            </div>
        </div>
        <div class="col-sm-6">
            {{ Form::label('salary', 'Total Amount Balance') }}
            <div class="metric-value d-inline-block">
                <span class="label label-pink" style="font-size:15px;white-space: normal;">
                    {{ 'SGD '.number_format($grant_balance, 2) }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection