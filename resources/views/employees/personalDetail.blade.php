<!-- Personal Details -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    window.reset = function(e) {
        e.wrap('<form>').closest('form').get(0).reset();
        e.unwrap();
    }
    
    function preview_image(event) {
        var reader = new FileReader();
        reader.onload = function()
        {
        var output = document.getElementById('output_image');
        output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<style>
body
    #wrapper {
        text-align: center;
        margin: 0 auto;
        padding: 0px;
        width: 800px;
    }

    #output_image {
        max-height: 180px;
        max-width: 220px;
    }
</style>
<div class="card">
    <div class="card-header">
        <div><b>Personal Details</b></div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 text-center">
                <div class="form-group col-md-11 offset-md-1">
                    @if($employee->filename)
                        <img src="{{url('images/'.$employee->filename)}}" alt="{{ $employee->name }} photo" class="img-fluid">
                    @else
                        <form onsubmit="return validate()">
                            <img id="output_image"/ class="img-fluid">
                        </form>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                {{ Form::hidden('id', $employee->id) }}
                <div class="form-group">
                    {{ Form::label('emp_id', 'Employee ID') }}
                    {{ Form::text('emp_id', "$employee->emp_id", ['class' => 'form-control', 'maxlength' => 4]) }}
                </div>
                <div class="form-group">
                    {{ Form::label('name', 'Employee Name', ['class' => 'required']) }}
                    {{ Form::text('name', "$employee->name", ['class' => 'form-control', 'style' => 'text-transform: uppercase']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('nric', 'NRIC (Last 4 Digit)') }}
                    {{ Form::text('nric', "$employee->nric", ['class' => 'form-control', 'maxlength' => 4]) }}
                </div>
            </div>
        </div>
        <div class="row form-group col-sm-12">
            <label style="margin-top: 2px;">Select Image :</label>
            <input name="image" id="file" type="file" accept="image/*" onchange="preview_image(event)">
        </div>
        <hr>
        @if (isset($employee->id))
        <div class="row">
            <div class="col-sm-6">
                <b>Job Title:</b><br>
                <b>Department:</b>
            </div>
            @if (isset($salaries->id))
            <div class="col-sm-6">
                {{ $salaries->int_job_title }}<br>
                {{ $salaries->dpt_name }}
            </div>
            @endif
        </div>
        @endif
    </div>
</div>