@extends('admin.layouts.app')

@section('title', 'Add New Tech')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Technology</h4>

                <form class="forms-sample" action="{{ route('admin.tech.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="judul">Tech Name</label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="e.g. Laravel" required>
                    </div>

                    <div class="form-group">
                        <label>Icon / Logo (PNG/SVG recommended)</label>
                        <input type="file" name="foto" class="file-upload-default" id="fileInput" accept="image/*" required>
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('fileInput').click()">Upload</button>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success me-2">Save</button>
                    <a href="{{ route('admin.tech.index') }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script sederhana untuk handle input file browse
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.querySelector('.file-upload-info');
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileInfo.value = fileInput.files[0].name;
            }
        });
    });
</script>
@endsection
