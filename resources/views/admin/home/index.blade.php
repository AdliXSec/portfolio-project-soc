@extends('admin.layouts.app')

@section('title', 'Edit Profile & Home')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-header">
            <h3 class="page-title"> Home / Profile Settings </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Home Profile</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Form Utama --}}
<form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-4">Profile Picture</h4>

                    <div class="position-relative d-inline-block mb-4">
                        <img src="{{ $home->foto ? asset('img/home/'.$home->foto) : 'https://via.placeholder.com/150' }}"
                             alt="profile"
                             id="imgPreview"
                             class="img-lg rounded-circle border border-primary p-1"
                             style="width: 180px; height: 180px; object-fit: cover;">

                        <label for="fotoUpload" class="position-absolute bg-success rounded-circle p-2 cursor-pointer"
                               style="bottom: 10px; right: 10px; cursor: pointer;" title="Change Photo">
                            <i class="mdi mdi-camera text-white"></i>
                        </label>
                        <input type="file" id="fotoUpload" name="foto" class="d-none" accept="image/*" onchange="previewImage(this)">
                    </div>

                    <p class="text-muted mb-4">Allowed JPG, GIF or PNG. Max size of 2MB</p>

                    <hr class="border-secondary">

                    <div class="form-group text-start">
                        <label class="text-muted mb-1">Contact Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark text-white"><i class="mdi mdi-email"></i></span>
                            </div>
                            <input type="email" class="form-control text-white" name="email" value="{{ old('email', $home->mail) }}" placeholder="Email for 'Hire Me'">
                        </div>
                    </div>

                    <div class="form-group text-start">
                        <label class="text-muted mb-1">Curriculum Vitae (PDF)</label>
                        <input type="file" name="cv" class="file-upload-default" id="cvInput" accept="application/pdf">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload PDF">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('cvInput').click()">File</button>
                            </span>
                        </div>
                        @if($home->cv)
                            <div class="mt-2">
                                <a href="{{ asset($home->cv) }}" target="_blank" class="text-success text-small">
                                    <i class="mdi mdi-check-circle"></i> CV Available. Click to view.
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Personal Details</h4>

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control text-white" name="nama" value="{{ old('nama', $home->nama) }}" placeholder="Your Name" required>
                    </div>

                    <div class="form-group">
                        <label>Short Bio</label>
                        <textarea class="form-control text-white" name="deskripsi" rows="4" placeholder="Tell us a bit about yourself...">{{ old('deskripsi', $home->deskripsi) }}</textarea>
                    </div>

                    <h4 class="card-title mt-5">Dynamic Roles <small class="text-muted">(TypeIt Animation)</small></h4>

                    <div class="form-group">
                        <div id="role-wrapper">
                            @if($home->role && count($home->role) > 0)
                                @foreach($home->role as $role)
                                    <div class="input-group mb-2 role-item">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark border-secondary text-success">
                                                <i class="mdi mdi-code-tags"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-white" name="role[]" value="{{ $role }}" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-inverse-danger remove-role" type="button">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 role-item">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark border-secondary text-success"><i class="mdi mdi-code-tags"></i></span>
                                    </div>
                                    <input type="text" class="form-control text-white" name="role[]" placeholder="e.g. Web Developer" required>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-role">
                            <i class="mdi mdi-plus"></i> Add New Role
                        </button>
                    </div>

                    <h4 class="card-title mt-5">Social Media</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>GitHub</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark text-white"><i class="mdi mdi-github"></i></span>
                                    </div>
                                    <input type="url" class="form-control text-white" name="github" value="{{ old('github', $home->github) }}" placeholder="https://github.com/...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>LinkedIn</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark text-info"><i class="mdi mdi-linkedin"></i></span>
                                    </div>
                                    <input type="url" class="form-control text-white" name="linkedin" value="{{ old('linkedin', $home->linkedin) }}" placeholder="https://linkedin.com/in/...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Instagram</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark text-danger"><i class="mdi mdi-instagram"></i></span>
                                    </div>
                                    <input type="url" class="form-control text-white" name="instagram" value="{{ old('instagram', $home->instagram) }}" placeholder="https://instagram.com/...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-top border-secondary pt-4 mt-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-dark me-2" onclick="window.location.reload()">Reset</button>
                        <button type="submit" class="btn btn-success btn-lg"><i class="mdi mdi-content-save"></i> Save Changes</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

{{-- Javascript --}}
<script>
    // 1. Preview Image Real-time
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imgPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        // 2. Upload File Browse Name Logic (Bawaan template)
        const cvInput = document.getElementById('cvInput');
        const cvInfo = document.querySelector('.file-upload-info');
        cvInput.addEventListener('change', function() {
            if (cvInput.files.length > 0) {
                cvInfo.value = cvInput.files[0].name;
            }
        });

        // 3. Dynamic Role Inputs
        const roleWrapper = document.getElementById('role-wrapper');
        const addRoleBtn = document.getElementById('add-role');

        addRoleBtn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'input-group mb-2 role-item animate-fade-in'; // Tambah animasi css
            div.innerHTML = `
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-secondary text-success"><i class="mdi mdi-code-tags"></i></span>
                </div>
                <input type="text" class="form-control text-white" name="role[]" placeholder="New Role..." required>
                <div class="input-group-append">
                    <button class="btn btn-inverse-danger remove-role" type="button"><i class="mdi mdi-delete"></i></button>
                </div>
            `;
            roleWrapper.appendChild(div);
        });

        roleWrapper.addEventListener('click', function(e) {
            // Handle klik pada icon atau button delete
            if (e.target.closest('.remove-role')) {
                if (document.querySelectorAll('.role-item').length > 1) {
                    e.target.closest('.role-item').remove();
                } else {
                    alert("At least one role is required!");
                }
            }
        });
    });
</script>

{{-- CSS Tambahan Sedikit untuk halaman ini --}}
<style>
    .cursor-pointer { cursor: pointer; transition: transform 0.2s; }
    .cursor-pointer:hover { transform: scale(1.1); }
    .animate-fade-in { animation: fadeIn 0.5s; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
