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
{{ Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id], 'enctype' => 'multipart/form-data']) }}
    <div class="card-header">
        <b>Edit Role</b>
    </div>
    <div class="card-body">
    @csrf
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('name', 'User Name') }}
                {{ Form::text('name', $user->name, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('email', 'Email') }}
                {{ Form::text('email', $user->email, ['class' => 'form-control']) }}
            </div>
            @role('admin')
            <div class="form-group col-sm-3">
                {{ Form::label('roles', 'Roles') }}
                <div>
                    @foreach ($roles as $key => $role)
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" name="roles[]" class="custom-control-input" value="{{ $role->id }}" {{in_array($role->id, $userRoles) ? "checked" : null}}>
                        <span class="custom-control-label">{{ $role->display_name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endrole
        </div>
        {{ Form::submit('Update', ['class' => 'btn btn-sm btn-success', 'onclick' => 'return ConfirmSave()']) }}
        {{ link_to(URL::route('users.index'), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
    </div>
{{ Form::close() }}
</div>
@endsection