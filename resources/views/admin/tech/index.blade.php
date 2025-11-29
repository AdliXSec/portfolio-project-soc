@extends('admin.layouts.app')

@section('title', 'Manage Technologies')

@section('content')
<div class="row">
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Tech Arsenal</h4>
            <p class="text-muted mb-0">Manage your skills and tools</p>
        </div>
        <a href="{{ route('admin.tech.create') }}" class="btn btn-success btn-icon-text">
            <i class="mdi mdi-plus btn-icon-prepend"></i> Add New Tech
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="row">
    @forelse($techs as $tech)
        <div class="col-xl-2 col-lg-3 col-md-4 col-6 grid-margin stretch-card">
            <div class="card tech-card text-center position-relative" style="background: #191c24; border: 1px solid #2c2e33;">
                <div class="card-body p-3 d-flex flex-col align-items-center justify-content-center">

                    <div class="icon-container mb-3 p-2 rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px; background: rgba(255,255,255,0.05);">
                        <img src="{{ asset('img/code/'.$tech->foto) }}" alt="{{ $tech->judul }}" style="max-width: 35px; max-height: 35px;">
                    </div>

                    <h6 class="mb-0 font-weight-bold">{{ $tech->judul }}</h6>

                    <div class="card-actions position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                         style="top:0; left:0; background: rgba(0,0,0,0.8); opacity: 0; transition: 0.3s; border-radius: 0.25rem;">

                        <a href="{{ route('admin.tech.edit', $tech->id) }}" class="btn btn-warning btn-icon btn-rounded mx-1">
                            <i class="mdi mdi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.tech.destroy', $tech->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete {{ $tech->judul }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-icon btn-rounded mx-1">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="p-5 border border-dashed border-secondary rounded">
                <i class="mdi mdi-code-tags text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No technologies added yet.</h5>
            </div>
        </div>
    @endforelse
</div>

<style>
    /* Efek Hover Card */
    .tech-card:hover {
        border-color: #0090e7 !important;
        transform: translateY(-5px);
        transition: all 0.3s;
    }
    /* Munculkan tombol aksi saat hover */
    .tech-card:hover .card-actions {
        opacity: 1 !important;
    }
</style>
@endsection
