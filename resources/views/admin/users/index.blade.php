@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">User Management</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Add New User</a>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="py-1">{{ $loop->iteration }}</td>
                            <td> {{ $user->name }} </td>
                            <td> {{ $user->email }} </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
