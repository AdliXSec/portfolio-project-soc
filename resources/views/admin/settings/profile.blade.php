@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-header">
            <h3 class="page-title">Edit Profile</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Profile Picture</h4>

                <div class="position-relative d-inline-block mb-4">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/'.$user->avatar) }}"
                             alt="Avatar"
                             id="avatarPreview"
                             class="img-lg rounded-circle border border-primary p-1"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="avatar-placeholder rounded-circle border border-secondary d-flex align-items-center justify-content-center"
                             id="avatarPlaceholder"
                             style="width: 150px; height: 150px; background: #2c2e33;">
                            <i class="mdi mdi-account text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <img src="" alt="Avatar" id="avatarPreview" class="img-lg rounded-circle border border-primary p-1 d-none"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                </div>

                <form action="{{ route('admin.settings.profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <div class="mb-3">
                        <label for="avatarUpload" class="btn btn-outline-primary btn-sm">
                            <i class="mdi mdi-camera"></i> Change Photo
                        </label>
                        <input type="file" id="avatarUpload" name="avatar" class="d-none" accept="image/*" onchange="previewAvatar(this)">
                    </div>

                    <button type="submit" class="btn btn-success btn-sm d-none" id="saveAvatarBtn">
                        <i class="mdi mdi-content-save"></i> Save Photo
                    </button>
                </form>

                @if($user->avatar)
                <form action="{{ route('admin.settings.avatar.delete') }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Remove your avatar?')">
                        <i class="mdi mdi-delete"></i> Remove
                    </button>
                </form>
                @endif

                <hr class="border-secondary my-4">

                <div class="text-start">
                    <p class="text-muted mb-1"><strong>Member since:</strong></p>
                    <p class="text-white">{{ $user->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="mdi mdi-account-edit text-primary me-2"></i>Account Details</h4>

                <form action="{{ route('admin.settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Full Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark text-white border-secondary">
                                    <i class="mdi mdi-account"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control text-white" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark text-white border-secondary">
                                    <i class="mdi mdi-email"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control text-white" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div class="border-top border-secondary pt-4 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="mdi mdi-content-save"></i> Save Changes
                        </button>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-dark btn-lg">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row" id="password">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="mdi mdi-lock text-warning me-2"></i>Change Password</h4>
                <p class="text-muted mb-4">Ensure your account is using a long, random password to stay secure.</p>

                <form action="{{ route('admin.settings.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Current Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-dark text-warning border-secondary">
                                        <i class="mdi mdi-lock-open"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control text-white" name="current_password" required>
                            </div>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>New Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-dark text-success border-secondary">
                                        <i class="mdi mdi-lock"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control text-white" name="password" required minlength="8">
                            </div>
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Confirm New Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-dark text-success border-secondary">
                                        <i class="mdi mdi-lock-check"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control text-white" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="border-top border-secondary pt-4 mt-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="mdi mdi-lock-reset"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('avatarPreview');
                const placeholder = document.getElementById('avatarPlaceholder');
                const saveBtn = document.getElementById('saveAvatarBtn');

                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
                saveBtn.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
