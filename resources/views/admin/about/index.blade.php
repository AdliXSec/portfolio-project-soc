@extends('admin.layouts.app')

@section('title', 'Edit About Section')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-header">
            <h3 class="page-title"> About Me Settings </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Me</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="mdi mdi-image-filter-frames text-primary me-2"></i>Visual & Stats</h4>

                    <div class="form-group text-center mt-4">
                        <label class="d-block text-start text-muted mb-2">About Image</label>
                        <div class="position-relative d-inline-block w-100">
                            <img loading="lazy" src="{{ $about->foto ? asset('img/about/'.$about->foto) : 'https://via.placeholder.com/400x300' }}"
                                 alt="About Image"
                                 id="imgPreview"
                                 class="img-fluid rounded border border-secondary"
                                 style="width: 100%; height: 300px; object-fit: cover; opacity: 0.8;">

                            <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                 style="top: 0; left: 0; background: rgba(0,0,0,0.4); opacity: 0; transition: 0.3s;"
                                 onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                                <label for="fotoUpload" class="btn btn-outline-light btn-icon-text cursor-pointer">
                                    <i class="mdi mdi-upload btn-icon-prepend"></i> Change Image
                                </label>
                            </div>
                        </div>
                        <input type="file" id="fotoUpload" name="foto" class="d-none" accept="image/*" onchange="previewImage(this)">
                    </div>

                    <hr class="border-secondary my-4">

                    <div class="form-group">
                        <label class="text-muted">Total Projects Completed</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark text-success border-secondary">
                                    <i class="mdi mdi-chart-bar"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control text-white form-control-lg font-weight-bold"
                                   name="total_project"
                                   value="{{ old('total_project', $about->total_project) }}"
                                   style="font-size: 1.5rem; color: #00d25b !important;" required>
                        </div>
                        <small class="text-muted">This number appears on the "About" card overlay.</small>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="mdi mdi-book-open-page-variant text-warning me-2"></i>Story & Skills</h4>

                    <div class="row mt-4">
                        <div class="col-md-6 form-group">
                            <label>Main Title</label>
                            <input type="text" class="form-control text-white" name="judul" value="{{ old('judul', $about->judul) }}" placeholder="About Me" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Subtitle</label>
                            <input type="text" class="form-control text-info" name="subjudul" value="{{ old('subjudul', $about->subjudul) }}" placeholder="My Journey" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description (Bio)</label>
                        <textarea class="form-control text-white" name="deskripsi" rows="8"
                                  placeholder="Write your bio here..."
                                  style="line-height: 1.6; height: 200px;" required>{{ old('deskripsi', $about->deskripsi) }}</textarea>
                        <div class="d-flex justify-content-between mt-2">
                            <small class="text-muted">Supports basic HTML tags (&lt;p&gt;, &lt;br&gt;, &lt;b&gt;)</small>
                            <small class="text-muted"><i class="mdi mdi-keyboard"></i> Writing Mode</small>
                        </div>
                    </div>

                    <hr class="border-secondary my-4">

                    <h4 class="card-title mb-3">Core Competencies <small class="text-muted">(Skills)</small></h4>

                    <div class="form-group">
                        <div id="core-wrapper">
                            @if($about->core && count($about->core) > 0)
                                @foreach($about->core as $skill)
                                    <div class="input-group mb-2 core-item">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark border-secondary text-warning">
                                                <i class="mdi mdi-flash"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-white" name="core[]" value="{{ $skill }}" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-inverse-danger remove-core" type="button">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 core-item">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark border-secondary text-warning"><i class="mdi mdi-flash"></i></span>
                                    </div>
                                    <input type="text" class="form-control text-white" name="core[]" placeholder="e.g. Laravel" required>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-warning btn-sm mt-2" id="add-core">
                            <i class="mdi mdi-plus"></i> Add New Skill
                        </button>
                    </div>

                    <div class="border-top border-secondary pt-4 mt-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-dark me-2" onclick="window.location.reload()">Reset</button>
                        <button type="submit" class="btn btn-success btn-lg btn-icon-text">
                            <i class="mdi mdi-content-save btn-icon-prepend"></i> Save Changes
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

{{-- Javascript untuk Logika Dinamis --}}
<script>
    // 1. Preview Image
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
        // 2. Dynamic Skills Input
        const coreWrapper = document.getElementById('core-wrapper');
        const addCoreBtn = document.getElementById('add-core');

        addCoreBtn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'input-group mb-2 core-item animate-fade-in';
            div.innerHTML = `
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-secondary text-warning"><i class="mdi mdi-flash"></i></span>
                </div>
                <input type="text" class="form-control text-white" name="core[]" placeholder="New Skill..." required>
                <div class="input-group-append">
                    <button class="btn btn-inverse-danger remove-core" type="button"><i class="mdi mdi-delete"></i></button>
                </div>
            `;
            coreWrapper.appendChild(div);
        });

        coreWrapper.addEventListener('click', function(e) {
            if (e.target.closest('.remove-core')) {
                if (document.querySelectorAll('.core-item').length > 1) {
                    e.target.closest('.core-item').remove();
                } else {
                    alert("You must have at least one skill!");
                }
            }
        });
    });
</script>

<style>
    .cursor-pointer { cursor: pointer; }
    /* Efek animasi halus saat tambah item */
    .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
