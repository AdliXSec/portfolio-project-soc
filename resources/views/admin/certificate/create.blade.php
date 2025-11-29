@extends('admin.layouts.app')
@section('title', 'Add Certificate')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Certificate / Award</h4>

                <form class="forms-sample" action="{{ route('admin.certificate.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Title / Achievement Name</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Type</label>
                            <select class="form-control text-white" name="type" required>
                                <option value="Certificate">Certificate (Course/Webinar)</option>
                                <option value="Award">Award (Competition/Winner)</option>
                                <option value="Competency">Competency (BNSP/Professional)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Issuer (Organization)</label>
                            <input type="text" class="form-control" name="issued" placeholder="e.g. Dicoding, Google" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Date Issued</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Credential ID (Optional)</label>
                            <input type="text" class="form-control" name="kredensial">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Status</label>
                            <select class="form-control text-white" name="status">
                                <option value="Valid">Valid</option>
                                <option value="Expired">Expired</option>
                                <option value="No Expiry">No Expiry</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Credential URL</label>
                            <input type="url" class="form-control" name="link" placeholder="https://...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Skills Validated</label>
                        <div id="skill-wrapper">
                            <div class="input-group mb-2 skill-item">
                                <input type="text" class="form-control" name="skill[]" placeholder="e.g. PHP">
                                <div class="input-group-append">
                                    <button class="btn btn-danger remove-skill" type="button"><i class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-skill"><i class="mdi mdi-plus"></i> Add Skill</button>
                    </div>

                    <div class="form-group">
                        <label>Certificate Image / Scan</label>
                        <input type="file" name="foto" class="form-control file-upload-info" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-success me-2">Save</button>
                    <a href="{{ route('admin.certificate.index') }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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
                if(wrapper.children.length > 1) e.target.closest('.skill-item').remove();
            }
        });
    });
</script>
@endsection
