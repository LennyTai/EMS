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
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="ecommerce-widget">
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <a href="{{ route('employees.index') }}">
                                <div class="card-body">
                                    <h5 class="text-muted">Employees</h5>
                                    <div class="metric-value d-inline-block">
                                        <span class="label label-pink" style="font-size:15px;white-space: normal;">
                                        {!! $employee->tot_emp() !!}
                                        </span>
                                    </div>
                                </div>
                                </a>
                                <div id="sparkline-revenue"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Departments</h5>
                                    <div class="metric-value d-inline-block">
                                        <span class="label label-purple" style="font-size:15px;white-space: normal;">
                                        {!! $employee->tot_dpt() !!}
                                        </span>
                                    </div>
                                </div>
                                <div id="sparkline-revenue2"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">New Hired</h5>
                                    <div class="metric-value d-inline-block">
                                        <span class="label label-blue" style="font-size:15px;white-space: normal;">
                                        {!! $employee->tot_NewHired() !!}
                                        </span>
                                    </div>
                                </div>
                                <div id="sparkline-revenue3"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Resignation</h5>
                                    <div class="metric-value d-inline-block">
                                        <span class="label label-green" style="font-size:15px;white-space: normal;">
                                        {!! $employee->tot_Resigned() !!}
                                        </span>
                                    </div>
                                </div>
                                <div id="sparkline-revenue4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                         <div class="card" style="padding-left: 20px; padding-right: 20px; padding-top: 15px; padding-bottom: 15px; width:100%">
                            <h4 class="text-center"><b>Upcoming Confirmation : {{ $employees->count() }}</b></h4>
                            <table id="example" class="stripe row-border hover display compact cell-border">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Employee Name</th>
                                        <th>Confirmed Date</th>
                                        <th>Days left</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('employees.edit',$employee->id) }}" title="Edit" style="color: blue;">{{ $employee->name }}</a>
                                        </td>
                                        <td>{{ $employee->confirmed_date->format('d-m-Y') }}</td>
                                        <td>{{ $employee->getConfirmation() }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                {!! $bar->script() !!}
                                {!! $bar->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                {!! $horizontalBar->script() !!}
                                {!! $horizontalBar->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection