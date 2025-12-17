@extends('admin.layouts.app')

@section('title', 'Add New User')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add New User</h4>
            <p class="card-description"> Fill out the form below to add a new user. </p>
            <form class="forms-sample" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control text-white" id="role" name="role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
