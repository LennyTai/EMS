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
    {{ Form::model($permissions, ['action' => 'RoleController@store']) }}
    <div class="card-header">
        <b>Add Role</b>
    </div>
    <div class="card-body">
    @csrf
        <div class="row">
            <div class="form-group col-sm-3">
                {{ Form::label('name', 'Role Name') }}
                {{ Form::text('name', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('display_name', 'Display Name') }}
                {{ Form::text('display_name', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-sm-3">
                {{ Form::label('description', 'Description') }}
                {{ Form::textarea('description', '', ['class' => 'form-control', 'rows' => '3']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('permissions', 'Permissions') }}
                <div>
                    @foreach ($permissions as $key => $permission)
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" value="{{ $key }}" name="permissions[]" class="custom-control-input"><span class="custom-control-label">{{ $permission }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
{{--             <div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
                <label for="permissions" class="col-md-3 control-label">Permissions</label>
                <div class="">
                    @foreach ($permissions as $key => $permission)
                        <input type="checkbox"  value="{{$key}}" name="permissions[]"> {{$permission}}<br>
                    @endforeach
                </div>
            </div> --}}
        </div>
        {{ Form::submit('Add', ['class' => 'btn btn-sm btn-success', 'onclick' => 'return ConfirmSave()']) }}
        {{ link_to(URL::route('roles.index'), 'Back', ['class' => 'btn btn-primary', 'style' => 'float: right']) }}
    </div>
    {{ Form::close() }}
</div>
@endsection