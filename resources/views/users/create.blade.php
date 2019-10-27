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
    {{ Form::model($roles, ['action' => 'UserController@store']) }}
    <div class="card-header">
        <b>Add User</b>
    </div>
    <div class="card-body">
    @csrf
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', '', ['class' => 'form-control', 'value' => old('name') ]) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('email', 'E-mail Address') }}
                {{ Form::text('email', '', ['class' => 'form-control', 'value' => old('email') ]) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('password', 'Password') }}
                <input id="password" type="password" class="form-control" name="password">
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('password', 'Confirm Password') }}
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
            </div>
        </div>
        @role('admin')
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('roles', 'Roles') }}
                <div class="">
                    @foreach ($roles as $key => $role)
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" value="{{ $key }}" name="roles[]" class="custom-control-input">
                        <span class="custom-control-label">{{ $role }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endrole
        {{ Form::submit('Add', ['class' => 'btn btn-sm btn-success', 'onclick' => 'return ConfirmSave()']) }}
        {{ link_to(URL::route('users.index'), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
    </div>
    {{ Form::close() }}
</div>
@endsection