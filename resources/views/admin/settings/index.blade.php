@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-header">
            <h3 class="page-title">Settings</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
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

<div class="row">
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
        <div class="card card-hover" onclick="window.location='{{ route('admin.settings.profile') }}'">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="icon-circle bg-primary mx-auto">
                        <i class="mdi mdi-account-circle text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <h4 class="font-weight-bold text-white">Edit Profile</h4>
                <p class="text-muted mb-0">Update your name, email, and avatar</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
        <div class="card card-hover" onclick="window.location='{{ route('admin.settings.profile') }}#password'">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="icon-circle bg-warning mx-auto">
                        <i class="mdi mdi-lock text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <h4 class="font-weight-bold text-white">Change Password</h4>
                <p class="text-muted mb-0">Update your account password</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
        <div class="card card-hover" onclick="window.location='{{ route('admin.security.index') }}'">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="icon-circle bg-danger mx-auto">
                        <i class="mdi mdi-shield-lock text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <h4 class="font-weight-bold text-white">Security</h4>
                <p class="text-muted mb-0">Monitor security & blocked IPs</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="mdi mdi-information-outline text-info me-2"></i>Account Information</h4>
                <div class="table-responsive">
                    <table class="table table-dark">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width: 200px;">Name</td>
                                <td class="text-white font-weight-bold">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td class="text-white">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Account Created</td>
                                <td class="text-white">{{ $user->created_at->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Last Updated</td>
                                <td class="text-white">{{ $user->updated_at->diffForHumans() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-hover {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        border-color: #0090e7;
        box-shadow: 0 10px 30px rgba(0, 144, 231, 0.2);
    }
    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
