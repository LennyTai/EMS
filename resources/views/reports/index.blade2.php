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
{{--                     <form action="{{ route('reports.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-sm btn-success">Import Employee Data</button>
                    </form> --}}
                    <a class="btn btn-sm btn-success" href="{{ route('reports.export') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>
                <div class="card-header">
                    <label>Employee-Department Lists</label>
                </div>
                <div class="card-body">
{{--                     <form action="{{ route('reports.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-sm btn-success">Import Employee Data</button>
                    </form> --}}
                    <a class="btn btn-sm btn-success" href="{{ route('reports.export1') }}"><i class="fas fa-file"></i> Export to Excel</a>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection