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
    {{ Form::model($department, ['action' => 'DepartmentController@store']) }}
    @csrf
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('dpt_name', 'Department Name') }}
                {{ Form::text('dpt_name', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('hod', 'Head of Department') }}
                {{ Form::select('hod', $employee, $department->hod, ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('company', 'Company') }}
                {{ Form::select('company', __('message.company') , '', ['class' => 'form-control', 'placeholder' => '[Please Select]']) }}
            </div>
        </div>
        {{ Form::submit('Add', ['class' => 'btn btn-success', 'onclick' => 'return ConfirmSave()']) }}
        {{ link_to(URL::previous(), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection