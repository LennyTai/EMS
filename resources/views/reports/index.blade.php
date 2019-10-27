@extends('layouts.app')
@section('content')
@if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}  
    </div><br/>
@endif
<div class="card" style="padding-left: 20px; padding-right: 20px; padding-top: 15px; width:100%">
    <div class="card-header">
        <h4 class="text-center"><b>Reports</b></h4>
    </div>
    <div class="row">
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Employee Lists</label>
                </div>
                <div class="card-body">
                    {{-- Import function --}}
{{--                     <form action="{{ route('reports.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-sm btn-success">Import Employee Data</button>
                    </form> --}}
                    <a class="btn btn-sm btn-success" href="{{ route('reports.employees') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div>
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Employee by Department</label>
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="{{ route('reports.employeeDepartment') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div>
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Age Report</label>
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="{{ route('reports.EmployeesAge') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div>
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Confirmation Report</label>
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="{{ route('reports.employeesConfirm') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div>        
    </div>
    <div class="row"> 
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Termination Report</label>
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="{{ route('reports.employeesTermination') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div>              
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Long Service Report</label>
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="{{ route('reports.LongServices') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div> 
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Local Foreign report</label>
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="{{ route('reports.LocalForeigners') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div>           
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Passport Expired Report</label>
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="{{ route('reports.PassportExpires') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div>                                               
    </div>
    <div class="row"> 
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Grand Payment</label>
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="{{ route('reports.employeesGrant') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div>              
        <div class="card-body col-md-3">
            <div class="card bg-light">
                <div class="card-header">
                    <label>Work Permit Report</label>
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="{{ route('reports.employees') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
            </div>
        </div> 

</div>
@endsection