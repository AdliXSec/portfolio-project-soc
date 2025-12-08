@extends('admin.layouts.app')
@section('title', 'Manage Projects')

@section('content')
<div class="row">
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Project Gallery</h4>
        <a href="{{ route('admin.project.create') }}" class="btn btn-success btn-icon-text">
            <i class="mdi mdi-plus btn-icon-prepend"></i> Add New Project
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="row">
    @forelse($projects as $project)
        <div class="col-md-6 col-xl-4 grid-margin stretch-card">
            <div class="card" style="overflow: hidden; border-radius: 15px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">

                <div class="card-img-top position-relative" style="height: 200px; overflow: hidden;">
                    @php
                        // Logika ambil gambar pertama atau placeholder
                        $imgSrc = 'https://via.placeholder.com/400x250?text=No+Image';
                        if ($project->galery && is_array($project->galery) && count($project->galery) > 0) {
                            $imgSrc = asset('storage/project/'.$project->galery[0]);
                        }

                        // Warna Badge berdasarkan Kategori
                        $badgeColor = match($project->type) {
                            'Web Development' => 'primary',
                            'IoT' => 'success',
                            'Cyber Security' => 'danger',
                            'Mobile App' => 'warning',
                            default => 'info'
                        };
                    @endphp

                    <img loading="lazy" src="{{ $imgSrc }}" alt="{{ $project->judul }}" style="width: 100%; height: 100%; object-fit: cover;">

                    <div class="badge badge-{{ $badgeColor }} position-absolute" style="top: 15px; right: 15px; opacity: 0.9;">
                        {{ $project->type }}
                    </div>
                </div>

                <div class="card-body">
                    <h4 class="font-weight-bold mb-2 text-white">{{ $project->judul }}</h4>

                    <div class="d-flex justify-content-between text-muted text-small mb-3">
                        <span><i class="mdi mdi-account"></i> {{ Str::limit($project->client ?? 'Personal', 15) }}</span>
                        <span><i class="mdi mdi-calendar"></i> {{ \Carbon\Carbon::parse($project->tanggal)->format('M Y') }}</span>
                    </div>

                    <p class="text-muted mb-4" style="font-size: 0.9rem; line-height: 1.5;">
                        {{ Str::limit($project->deskripsi, 80) }}
                    </p>

                    <div class="mb-4">
                        @if($project->teknologi)
                            @foreach(array_slice($project->teknologi, 0, 4) as $tech)
                                <span class="badge badge-outline-secondary badge-pill" style="font-size: 10px; margin-right: 2px; margin-bottom: 2px;">{{ $tech }}</span>
                            @endforeach
                            @if(count($project->teknologi) > 4)
                                <span class="text-muted" style="font-size: 10px;">+{{ count($project->teknologi) - 4 }} more</span>
                            @endif
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <div>
                            @if($project->website)
                                <a href="{{ $project->website }}" target="_blank" class="text-white mr-2" title="Live Demo"><i class="mdi mdi-web" style="font-size: 1.2rem;"></i></a>
                            @endif
                            @if($project->source)
                                <a href="{{ $project->source }}" target="_blank" class="text-white" title="Source Code"><i class="mdi mdi-github" style="font-size: 1.2rem;"></i></a>
                            @endif
                        </div>

                        <div>
                            <a href="{{ route('admin.project.edit', $project->id) }}" class="btn btn-warning btn-sm btn-icon-text">
                                <i class="mdi mdi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('admin.project.destroy', $project->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon-text ml-1">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="card">
                <div class="card-body">
                    <i class="mdi mdi-folder-open text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-muted">No Projects Found</h4>
                    <p class="text-muted">Start by adding your first project to the portfolio.</p>
                    <a href="{{ route('admin.project.create') }}" class="btn btn-primary mt-2">+ Add Project</a>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
