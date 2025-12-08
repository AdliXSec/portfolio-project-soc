@extends('admin.layouts.app')
@section('title', 'Edit Project')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Project</h4>

                <form class="forms-sample" action="{{ route('admin.project.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Project Title</label>
                            <input type="text" class="form-control" name="judul" value="{{ $project->judul }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Category Type</label>
                            <select class="form-control text-white" name="type" required>
                                @foreach(['Web Development', 'IoT', 'Cyber Security', 'Mobile App'] as $type)
                                    <option value="{{ $type }}" {{ $project->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="deskripsi" rows="5" required>{{ $project->deskripsi }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Client</label>
                            <input type="text" class="form-control" name="client" value="{{ $project->client }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Role</label>
                            <input type="text" class="form-control" name="role" value="{{ $project->role }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ $project->tanggal }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tech Stack</label>
                        <div id="tech-wrapper">
                            @if($project->teknologi)
                                @foreach($project->teknologi as $tech)
                                <div class="input-group mb-2 tech-item">
                                    <input type="text" class="form-control" name="teknologi[]" value="{{ $tech }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger remove-btn" type="button"><i class="mdi mdi-minus"></i></button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-tech"><i class="mdi mdi-plus"></i> Add Tech</button>
                    </div>

                    <div class="form-group">
                        <label>Key Features</label>
                        <div id="feature-wrapper">
                            @if($project->fitur)
                                @foreach($project->fitur as $fitur)
                                <div class="input-group mb-2 feature-item">
                                    <input type="text" class="form-control" name="fitur[]" value="{{ $fitur }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger remove-btn" type="button"><i class="mdi mdi-minus"></i></button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-feature"><i class="mdi mdi-plus"></i> Add Feature</button>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Live Demo URL</label>
                            <input type="url" class="form-control" name="website" value="{{ $project->website }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Source Code URL</label>
                            <input type="url" class="form-control" name="source" value="{{ $project->source }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Update Gallery (Will Replace All Existing Photos)</label>
                        <input type="file" name="galery[]" class="form-control file-upload-info" multiple accept="image/*">

                        @if($project->galery)
                            <div class="mt-2 d-flex gap-2">
                                @foreach($project->galery as $img)
                                    <img loading="lazy" src="{{ asset('storage/project/'.$img) }}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 5px;">
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success me-2">Update Project</button>
                    <a href="{{ route('admin.project.index') }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script JS sama dengan create.blade.php --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function setupDynamicInput(wrapperId, btnId, className, placeholder) {
            const wrapper = document.getElementById(wrapperId);
            const btn = document.getElementById(btnId);
            btn.addEventListener('click', function() {
                const div = document.createElement('div');
                div.className = `input-group mb-2 ${className}`;
                div.innerHTML = `<input type="text" class="form-control" name="${wrapperId === 'tech-wrapper' ? 'teknologi[]' : 'fitur[]'}" placeholder="${placeholder}"><div class="input-group-append"><button class="btn btn-danger remove-btn" type="button"><i class="mdi mdi-minus"></i></button></div>`;
                wrapper.appendChild(div);
            });
            wrapper.addEventListener('click', function(e) {
                if (e.target.closest('.remove-btn')) {
                    // Izinkan hapus semua di edit mode (opsional)
                    e.target.closest(`.${className}`).remove();
                }
            });
        }
        setupDynamicInput('tech-wrapper', 'add-tech', 'tech-item', 'e.g. Vue.js');
        setupDynamicInput('feature-wrapper', 'add-feature', 'feature-item', 'e.g. Dark Mode');
    });
</script>
@endsection
