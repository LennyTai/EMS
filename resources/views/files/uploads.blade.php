<!-- Uploads files -->
<div class="card col-sm-3">
    <div class="card-body">
{{--     @include('flash::message') --}}
        <!-- Start Page Content -->
        <div class="sms_heading">
            <h5><b>Resume</b></h5>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="upload-contacts">
                <form action="{{ route('upload-file', $employee) }}" class="form-horizontal form-bordered" id="upload-files" method="post" enctype="multipart/form-data">
                @csrf
                    @if (!$employee->uploadFile('filename'))
                    <div class="form-group">
                        <div class="row">
                            <input type="file" class="filestyle" id="filename" name="filename" data-buttonText="Browse">
                        </div>
                    </div>
                    <div class="row">
                        <div class="">
                            <button class="btn btn-info" type="submit">Upload Files</button>
                        </div>
                    </div>
                    @else
                    <div class="form-group">
                        <div class="row">
                            {{-- <span>{{ $employee->downloadFile($employee->id) }}</span> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="">
                            <button class="btn btn-success" type="submit">Download Files</button>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong>There were some problems with your input.
                    <br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>