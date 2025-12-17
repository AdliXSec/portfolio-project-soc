@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit User</h4>
            <p class="card-description">Update the user's information below.</p>
            <form class="forms-sample" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control text-white" id="role" name="role">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark">Cancel</a>
            </form>
        </div>
    </div>
</div>

<div class="col-12 grid-margin stretch-card mt-4">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Update Password</h4>
            <form class="forms-sample" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm New Password">
                </div>
                <button type="submit" class="btn btn-primary me-2">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
