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
{{ Form::model($qualification, ['method' => 'PATCH', 'route' => ['qualifications.update', $qualification->id], 'enctype' => 'multipart/form-data']) }}
@csrf
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
            <h5><b>{{ $qualification->employee->name }} Qualifications</b></h5>
            <hr>
            <div class="row">
                {{ Form::hidden('employee_id', $qualification->employee->id) }}
                <div class="form-group col-sm-3">
                    {{ Form::label('education', 'Education', ['class' => 'required']) }}
                    {{ Form::select('education', __('message.education'), $qualification->education,['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('major', 'Major') }}
                    {{ Form::select('major', __('message.major'), $qualification->major, ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
               <div class="form-group col-sm-3">
                    {{ Form::label('minor', 'Minor') }}
                    {{ Form::text('minor', $qualification->minor, ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('cgpa', 'CGPA out of 5.00') }}
                    {{ Form::text('cgpa', $qualification->cgpa, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="row">
               <div class="form-group col-sm-3">
                    {{ Form::label('institute', 'Institute', ['class' => 'required']) }}
                    {{ Form::text('institute', $qualification->institute, ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('country', 'Country', ['class' => 'required']) }}
                    {{ Form::select('country', __('message.nationality'), $qualification->country, ['class' => 'form-control', 'placeholder' => '[Please Select]' ]) }}
                </div>
                <div class="form-group col-sm-3">
                    {{ Form::label('graduated_date', 'Graduated Date', ['class' => 'required']) }}
                    {{ Form::date('graduated_date', $qualification->graduated_date, ['class' => 'form-control', 'max' => '2999-12-31']) }}
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
                                @if (isset($qualification))
                                    {{ Form::open(['url' => ['/uploads', $qualification->id. '/qualifications'], 'files'=> true]) }}
                                    <a href="{{ route('dl_qualification', $qualification->id) }}">{{ $qualification->filename }}</a>
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
            {{ link_to(URL::route('qualifications.index', $emp_id), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
            {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection