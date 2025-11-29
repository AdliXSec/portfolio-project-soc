@extends('admin.layouts.app')
@section('title', 'Create Project')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Project</h4>

                <form class="forms-sample" action="{{ route('admin.project.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Project Title</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Category Type</label>
                            <select class="form-control text-white" name="type" required>
                                <option value="Web Development">Web Development</option>
                                <option value="IoT">IoT / Hardware</option>
                                <option value="Cyber Security">Cyber Security</option>
                                <option value="Mobile App">Mobile App</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="deskripsi" rows="5" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Client</label>
                            <input type="text" class="form-control" name="client">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Role</label>
                            <input type="text" class="form-control" name="role">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Project Date</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tech Stack Used</label>
                        <div id="tech-wrapper">
                            <div class="input-group mb-2 tech-item">
                                <input type="text" class="form-control" name="teknologi[]" placeholder="e.g. Laravel">
                                <div class="input-group-append">
                                    <button class="btn btn-danger remove-tech" type="button"><i class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-tech"><i class="mdi mdi-plus"></i> Add Tech</button>
                    </div>

                    <div class="form-group">
                        <label>Key Features</label>
                        <div id="feature-wrapper">
                            <div class="input-group mb-2 feature-item">
                                <input type="text" class="form-control" name="fitur[]" placeholder="e.g. Realtime Notification">
                                <div class="input-group-append">
                                    <button class="btn btn-danger remove-feature" type="button"><i class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-feature"><i class="mdi mdi-plus"></i> Add Feature</button>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Live Demo URL</label>
                            <input type="url" class="form-control" name="website">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Source Code URL (GitHub)</label>
                            <input type="url" class="form-control" name="source">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Project Gallery (Multiple Images)</label>
                        <input type="file" name="galery[]" class="form-control file-upload-info" multiple accept="image/*">
                        <small class="text-muted">You can select multiple images at once.</small>
                    </div>

                    <button type="submit" class="btn btn-success me-2">Save Project</button>
                    <a href="{{ route('admin.project.index') }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Helper function untuk dynamic input
        function setupDynamicInput(wrapperId, btnId, className, placeholder) {
            const wrapper = document.getElementById(wrapperId);
            const btn = document.getElementById(btnId);

            btn.addEventListener('click', function() {
                const div = document.createElement('div');
                div.className = `input-group mb-2 ${className}`;
                div.innerHTML = `
                    <input type="text" class="form-control" name="${wrapperId === 'tech-wrapper' ? 'teknologi[]' : 'fitur[]'}" placeholder="${placeholder}">
                    <div class="input-group-append">
                        <button class="btn btn-danger remove-btn" type="button"><i class="mdi mdi-minus"></i></button>
                    </div>
                `;
                wrapper.appendChild(div);
            });

            wrapper.addEventListener('click', function(e) {
                if (e.target.closest('.remove-btn')) {
                    if (wrapper.children.length > 1) {
                        e.target.closest(`.${className}`).remove();
                    } else {
                        alert("At least one item is required!");
                    }
                }
            });
        }

        setupDynamicInput('tech-wrapper', 'add-tech', 'tech-item', 'e.g. Vue.js');
        setupDynamicInput('feature-wrapper', 'add-feature', 'feature-item', 'e.g. Dark Mode');
    });
</script>
@endsection
