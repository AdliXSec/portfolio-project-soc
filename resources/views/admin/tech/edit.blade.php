@extends('admin.layouts.app')

@section('title', 'Update Technology')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0 text-start">Edit Tech Stack</h4>
                    <a href="{{ route('admin.tech.index') }}" class="btn btn-inverse-secondary btn-sm btn-icon-text">
                        <i class="mdi mdi-arrow-left btn-icon-prepend"></i> Back
                    </a>
                </div>

                <form class="forms-sample" action="{{ route('admin.tech.update', $tech->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="tech-preview-container mb-4 position-relative d-inline-block">
                        <div class="glow-effect"></div>

                        <div class="preview-box p-4 border border-secondary rounded bg-dark d-flex align-items-center justify-content-center"
                             style="width: 150px; height: 150px; overflow: hidden; position: relative; z-index: 2;">
                            <img loading="lazy" src="{{ asset('img/code/'.$tech->foto) }}"
                                 alt="Preview"
                                 id="imgPreview"
                                 class="img-fluid"
                                 style="max-height: 100px; object-fit: contain; filter: drop-shadow(0 0 10px rgba(255,255,255,0.2));">
                        </div>

                        <label for="fileInput" class="btn btn-success btn-rounded btn-icon position-absolute"
                               style="bottom: -10px; right: -10px; z-index: 3; box-shadow: 0 0 15px rgba(0,210,91,0.5); cursor: pointer;">
                            <i class="mdi mdi-camera-retake"></i>
                        </label>
                    </div>

                    <input type="file" name="foto" id="fileInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                    <p class="text-muted text-small mb-4">Click the green button to change logo</p>

                    <div class="form-group text-start">
                        <label class="text-muted">Technology Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark text-primary border-secondary">
                                    <i class="mdi mdi-code-tags"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control text-white form-control-lg"
                                   id="judul" name="judul"
                                   value="{{ $tech->judul }}"
                                   placeholder="e.g. Laravel" required
                                   style="font-size: 1.1rem; font-weight: bold;">
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="mdi mdi-content-save-edit me-2"></i> Update Technology
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- CSS Tambahan untuk Efek Glow --}}
<style>
    .tech-preview-container:hover .glow-effect {
        opacity: 1;
        transform: scale(1.1);
    }
    .glow-effect {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0,144,231,0.4) 0%, rgba(0,0,0,0) 70%);
        opacity: 0.5;
        transition: all 0.5s ease;
        z-index: 1;
    }
    .preview-box {
        transition: border-color 0.3s;
    }
    .tech-preview-container:hover .preview-box {
        border-color: #0090e7 !important; /* Warna Primary template */
    }
</style>

{{-- Script Preview Gambar --}}
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                // Ganti src gambar
                document.getElementById('imgPreview').src = e.target.result;
                // Update nama di input (opsional visual feedback)
                // document.getElementById('judul').value = input.files[0].name.split('.')[0];
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
