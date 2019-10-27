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
            <h5><b>{{ $equipment->employee->name }} Equipments</b></h5>
            <hr>
                {{ Form::model($equipment, ['action' => ['EquipmentController@store'], 'enctype' => 'multipart/form-data']) }}
                @csrf
            <div class="row">
                {{ Form::hidden('employee_id', $equipment->employee->id) }}
               <div class="form-group col-sm-3">
                    {{ Form::label('TOE', 'Type of Equipment', ['class' => 'required']) }}
                    {{ Form::select('TOE', __('message.TOE'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
               <div class="form-group col-sm-3">
                    {{ Form::label('size', 'Size', ['class' => 'required']) }}
                    {{ Form::select('size', __('message.size'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('issued_date', 'Issued Date', ['class' => 'required']) }}
                    {{ Form::date('issued_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{ Form::label('remarks', 'Remarks') }}
                    {{ Form::textarea('remarks', '', ['class' => 'form-control', 'rows' => '3']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('return_status', 'Return Status') }}
                    {{ Form::select('return_status', __('message.return_status'), '', ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('return_date', 'Return Date') }}
                    {{ Form::date('return_date', '', ['class' => 'form-control', 'max' => '2999-12-31']) }}
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
                                @if ($equipment->filename)
                                    {{ Form::open(['url' => ['/uploads', $equipment->id. '/equipments'], 'files'=> true]) }}
                                    <a href="{{ route('dl_equipment', $equipment->id) }}">{{ $equipment->filename }}</a>
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
            {{ link_to(URL::route('equipments.index', $employee->id), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
            {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection