<div class="card">
    <div class="card-header">
        <b>Employment Status:</b>
        <br>
        @if (isset($employee->id))
            @if ($employee->job_status === 'TERMINATED')
                <span class="label label-pink" style="font-size:13px;white-space: normal;">{{ $employee->job_status }} since <u>{{ $employee->joint_date->format('d/m/Y') }}</u> for {{ $employee->getYearsOfStatus() }}</span>
            @elseif ($employee->job_status === 'JOINED')
                <span class="label label-green" style="font-size:13px;white-space: normal;">{{ $employee->job_status }} since <u>{{ $employee->joint_date->format('d/m/Y') }}</u> for {{ $employee->getYearsOfStatus() }}</span>
            @elseif ($employee->job_status === 'RESIGNED')
                <span class="label label-warning" style="font-size:13px;white-space: normal;">{{ $employee->job_status }} on <u>{{ $employee->leave_date->format('d/m/Y') }}</u> for {{ $employee->getYearsOfStatus() }}</span>
            @else
                <span class="label label-blue" style="font-size:13px;white-space: normal;">{{ $employee->job_status }} since <u>{{ $employee->joint_date->format('d/m/Y') }}</u> for {{ $employee->getYearsOfStatus() }}</span>
            @endif
        @else
            <span class="label label-blue" style="font-size:13px;white-space: normal;">Congratulations for being a part of PLG</span>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                {{ Form::select('job_status', __('message.job_status'), $employee->job_status, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
</div>