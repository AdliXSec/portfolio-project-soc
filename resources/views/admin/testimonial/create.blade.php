@extends('admin.layouts.app')

@section('title', 'Add New Testimonial')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Testimonial</h4>

                <form class="forms-sample" action="{{ route('admin.testimonial.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
                    </div>

                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" id="position" name="position" placeholder="CEO, Company" required>
                    </div>

                    <div class="form-group">
                        <label for="testimonial">Testimonial</label>
                        <textarea class="form-control" id="testimonial" name="testimonial" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="rate">Rating (1-5)</label>
                        <input type="number" class="form-control" id="rate" name="rate" min="1" max="5" required>
                    </div>

                    <div class="form-group">
                        <label>Avatar (Optional)</label>
                        <input type="file" name="avatar" class="file-upload-default" id="fileInput" accept="image/*">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('fileInput').click()">Upload</button>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success me-2">Save</button>
                    <a href="{{ route('admin.testimonial.index') }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.querySelector('.file-upload-info');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) {
                    fileInfo.value = fileInput.files[0].name;
                }
            });
        }
    });
</script>
@endsection
