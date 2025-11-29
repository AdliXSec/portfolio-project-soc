@extends('admin.layouts.app')

@section('title', 'Timeline Manager')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-header">
            <h3 class="page-title"> Experience Timeline </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Journey</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="mdi mdi-plus-circle-outline text-success me-2"></i>Add New Journey</h4>
                <p class="text-muted mb-4">Add your work experience or education history here.</p>

                <form class="forms-sample" action="{{ route('admin.journey.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Period / Year</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark text-info border-secondary">
                                    <i class="mdi mdi-calendar-clock"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control text-white" name="tahun" placeholder="e.g. 2023 - Present" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Role / Title</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark text-warning border-secondary">
                                    <i class="mdi mdi-account-card-details"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control text-white" name="judul" placeholder="e.g. Senior Backend Dev" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control text-white" name="deskripsi" rows="5" placeholder="Describe your responsibilities..." style="line-height: 1.5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100 btn-icon-text">
                        <i class="mdi mdi-content-save btn-icon-prepend"></i> Add to Timeline
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">

        @if(session('success'))
            <div class="alert alert-success mb-4 d-flex align-items-center">
                <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"><i class="mdi mdi-history text-primary me-2"></i>Your Journey History</h4>

                @if($journeys->count() > 0)
                    <div class="timeline-container">
                        @foreach($journeys as $index => $journey)
                            @php
                                // Rotasi warna border agar tidak monoton
                                $colors = ['primary', 'success', 'danger', 'warning', 'info'];
                                $color = $colors[$index % 5];
                            @endphp

                            <div class="card mb-3 border border-secondary" style="background: #191c24;">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start">

                                        <div class="d-flex align-items-start">
                                            <div class="me-3 rounded" style="width: 4px; height: 60px; background-color: var(--bs-{{ $color }});"></div>

                                            <div>
                                                <h5 class="card-title mb-1 text-white">{{ $journey->judul }}</h5>
                                                <span class="badge badge-outline-{{ $color }} mb-2">
                                                    <i class="mdi mdi-calendar me-1"></i> {{ $journey->tahun }}
                                                </span>
                                                <p class="text-gray-400 mb-0 text-small" style="line-height: 1.4;">
                                                    {{ Str::limit($journey->deskripsi, 120) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <button class="btn btn-inverse-secondary btn-icon btn-sm" type="button" id="dropdownMenuButton{{ $journey->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $journey->id }}">
                                                <a class="dropdown-item text-warning" href="{{ route('admin.journey.edit', $journey->id) }}">
                                                    <i class="mdi mdi-pencil me-2"></i> Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.journey.destroy', $journey->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="mdi mdi-delete me-2"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="mdi mdi-map-marker-off text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-muted">No journey data added yet.</h5>
                        <p class="text-muted">Start adding your experience on the left form.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
