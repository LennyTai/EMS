<div class="card">
    <div class="card-header">
        <div><b>Related Information</b></div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div>
                    <a href="{{ route('families.index', $employee->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Family <span class="badge badge-primary badge-pill">{{ $employee->families->count() }}</span></a>
                </div>
                <div>
                    <a href="{{ route('allowances.index', $employee->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Allowance <span class="badge badge-primary badge-pill">{{ $employee->allowances->count() }}</span></a>
                </div>
                <div>
                    @role ('admin')
                    <a href="{{ route('salaries.index', $employee->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Job & Salary<span class="badge badge-primary badge-pill">{{ $employee->salaries->count() }}</span></a>
                    @endrole
                </div>
            </div>
            <div class="col-sm-6">
                <div>
                    <a href="{{ route('disciplinaries.index', $employee->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Disciplinary <span class="badge badge-primary badge-pill">{{ $employee->disciplinaries->count() }}</span></a>
                </div>
                <div>
                    <a href="{{ route('equipments.index', $employee->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Equipment (PPE)<span class="badge badge-primary badge-pill">{{ $employee->equipments->count() }}</span></a>
                </div>
                <div>
                    <a href="{{ route('qualifications.index', $employee->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Qualification <span class="badge badge-primary badge-pill">{{ $employee->qualifications->count() }}</span></a>
                </div>
            </div>
            <div class="col-sm-6">
                <div>
                    <a href="{{ route('attachments.index', $employee->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Attachment <span class="badge badge-primary badge-pill">{{ $employee->attachments->count() }}</span></a>
                </div>
            </div>
        </div>
    </div>
</div>