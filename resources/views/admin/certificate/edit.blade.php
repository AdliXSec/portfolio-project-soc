@extends('admin.layouts.app')
@section('title', 'Edit Certificate')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Certificate</h4>

                <form class="forms-sample" action="{{ route('admin.certificate.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="judul" value="{{ $certificate->judul }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Type</label>
                            <select class="form-control text-white" name="type">
                                @foreach(['Certificate', 'Award', 'Competency'] as $opt)
                                    <option value="{{ $opt }}" {{ $certificate->type == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Issuer</label>
                            <input type="text" class="form-control" name="issued" value="{{ $certificate->issued }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ $certificate->tanggal->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Credential ID</label>
                            <input type="text" class="form-control" name="kredensial" value="{{ $certificate->kredensial }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Status</label>
                            <select class="form-control text-white" name="status">
                                @foreach(['Valid', 'Expired', 'No Expiry'] as $st)
                                    <option value="{{ $st }}" {{ $certificate->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>URL</label>
                            <input type="url" class="form-control" name="link" value="{{ $certificate->link }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="deskripsi" rows="3">{{ $certificate->deskripsi }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Skills</label>
                        <div id="skill-wrapper">
                            @if($certificate->skill)
                                @foreach($certificate->skill as $s)
                                <div class="input-group mb-2 skill-item">
                                    <input type="text" class="form-control" name="skill[]" value="{{ $s }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger remove-skill" type="button"><i class="mdi mdi-minus"></i></button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-skill"><i class="mdi mdi-plus"></i> Add Skill</button>
                    </div>

                    <div class="form-group">
                        <label>Update Image</label>
                        <input type="file" name="foto" class="form-control file-upload-info" accept="image/*">
                        @if($certificate->foto)
                            <div class="mt-2">
                                <img  loading="lazy" src="{{ asset('img/cert/'.$certificate->foto) }}" style="height: 100px; border-radius: 5px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success me-2">Update</button>
                    <a href="{{ route('admin.certificate.index') }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Re-use script from create.blade.php (Dynamic input logic)
    document.addEventListener("DOMContentLoaded", function() {
        const wrapper = document.getElementById('skill-wrapper');
        const btn = document.getElementById('add-skill');
        btn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'input-group mb-2 skill-item';
            div.innerHTML = `<input type="text" class="form-control" name="skill[]" placeholder="e.g. New Skill"><div class="input-group-append"><button class="btn btn-danger remove-skill" type="button"><i class="mdi mdi-minus"></i></button></div>`;
            wrapper.appendChild(div);
        });
        wrapper.addEventListener('click', function(e) {
            if (e.target.closest('.remove-skill')) {
                // Izinkan kosong di edit mode, atau minimal 1 sesuai selera
                e.target.closest('.skill-item').remove();
            }
        });
    });
</script>
@endsection
