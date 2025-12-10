@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Testimonial</h4>

                <form class="forms-sample" action="{{ route('admin.testimonial.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $testimonial->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" id="position" name="position" value="{{ $testimonial->position }}" required>
                    </div>

                    <div class="form-group">
                        <label for="testimonial">Testimonial</label>
                        <textarea class="form-control" id="testimonial" name="testimonial" rows="4" required>{{ $testimonial->testimonial }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="rate">Rating (1-5)</label>
                        <input type="number" class="form-control" id="rate" name="rate" min="1" max="5" value="{{ $testimonial->rate }}" required>
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
                        @if($testimonial->avatar)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->name }}" style="width: 100px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success me-2">Update</button>
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
