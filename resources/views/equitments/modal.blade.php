<!-- Delete Family Member -->
<div id="deleteFamily" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        {{ Form::open() }}
            <div class="modal-header">            
                <h4 class="modal-title">Delete Family Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">          
                <p>Are you sure you want to delete this Family Member?</p>
                <p class="text-danger">This action cannot be undone!</p>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
{{--                 {{ Form::model($employee, ['method' => 'POST','route' => ['employees.destroy', $employee->id]]) }}
                @csrf
                @method('DELETE')
                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                {{ Form::close() }} --}}
                <input type="submit" class="btn btn-danger" value="Delete">
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>