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
            <h5><b>{{ $family->employee->name }} Families Particular</b></h5>
            <hr>
                {{ Form::model($employee, ['action' => ['FamilyController@store'], 'enctype' => 'multipart/form-data']) }}
                @csrf
            <div class="row">
                {{ Form::hidden('employee_id', $family->employee->id) }}
                <div class="form-group col-sm-3">
                    {{ Form::label('family_name', 'Name', ['class' => 'required']) }}
                    {{ Form::text('family_name', '', ['class' => 'form-control']) }}
                </div>
               <div class="form-group col-sm-3">
                    {{ Form::label('relationship', 'Relationship', ['class' => 'required']) }}
                    {{ Form::select('relationship', __('message.relationship'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('family_dob', 'Date of Birth', ['class' => 'required']) }}
                    {{ Form::date('family_dob', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('family_contact', 'Contact Number', ['class' => 'required']) }}
                    {{ Form::number('family_contact', '', ['class' => 'form-control']) }}
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
                                @if ($family->filename)
                                    {{ Form::open(['url' => ['/uploads', $family->id. '/families'], 'files'=> true]) }}
                                    <a href="{{ route('dl_family', $family->id) }}">{{ $family->filename }}</a>
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
            {{ link_to(URL::route('families.index', $employee->id), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
            {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection