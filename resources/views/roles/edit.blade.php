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
{{ Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id], 'enctype' => 'multipart/form-data']) }}
    <div class="card-header">
        <b>Edit Role</b>
    </div>
    <div class="card-body">
    @csrf
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('name', 'Role Name') }}
                {{ Form::label('name', $role->name, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('display_name', 'Display Name') }}
                {{ Form::text('display_name', $role->display_name, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('description', 'Description') }}
                {{ Form::textarea('description', $role->description, ['class' => 'form-control', 'rows' => '3']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('permissions', 'Permissions') }}
                <div>
                    @foreach ($permissions as $key => $permission)
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" name="permissions[]" class="custom-control-input" value="{{$permission->id}}" {{in_array($permission->id, $rolePermissions) ? "checked" : null}}>
                        <span class="custom-control-label">{{$permission->display_name}}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        {{ Form::submit('Update', ['class' => 'btn btn-sm btn-success', 'onclick' => 'return ConfirmSave()']) }}
        {{ link_to(URL::route('roles.index'), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
    </div>
{{ Form::close() }}
</div>
@endsection