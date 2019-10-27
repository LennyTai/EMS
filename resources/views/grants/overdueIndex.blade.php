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
    <h4 class="text-center"><b>PCP SCALA Overdue Payment : {{ $grant_payments->count() }}</b></h4>
    <table id="example" class="stripe row-border hover display compact cell-border">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Payment No.</th>
                <th>Due Date</th>
                <th>Payment Status</th>
                <th>Overdue Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grant_payments as $grant_payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ route('grant_payments.edit',$grant_payment->id) }}" title="Edit" style="color: blue;">
                        {{ $grant_payment->emp_name($grant_payment->grant->employee_id) }}
                    </a>
                </td>
                <td>{{ $grant_payment->payment_no }}</td>
                <td>{{ $grant_payment->payment_due_date->format('d-m-Y') }}</td>
                <td>{{ $grant_payment->payment_status }}</td>
                <td>{{ 'SGD '. number_format($grant_payment->grantBalance(), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <div class="row text-center">
        <div class="col-sm-11">
            {{ Form::label('salary', 'Total Overdue Amount : ') }}
            <div class="metric-value d-inline-block">
                <span class="label label-pink" style="font-size:15px;white-space: normal;">
                    {{ 'SGD '. number_format($cumulative, 2) }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection