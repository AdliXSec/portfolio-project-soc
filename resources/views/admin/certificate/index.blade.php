@extends('admin.layouts.app')
@section('title', 'Manage Certificates')

@section('content')
<div class="row">
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Certificates & Awards</h4>
        <a href="{{ route('admin.certificate.create') }}" class="btn btn-success btn-icon-text">
            <i class="mdi mdi-plus btn-icon-prepend"></i> Add New
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="row">
    @forelse($certificates as $cert)
        <div class="col-md-6 col-xl-4 grid-margin stretch-card">
            <div class="card" style="border-radius: 15px; overflow: hidden;">
                <div class="position-relative">
                    <img loading="lazy" src="{{ asset('img/cert/'.$cert->foto) }}" alt="{{ $cert->judul }}"
                         style="width: 100%; height: 200px; object-fit: cover;">

                    @php
                        $typeColor = $cert->type == 'Award' ? 'warning' : 'primary';
                        $statusColor = $cert->status == 'Valid' ? 'success' : 'danger';
                    @endphp
                    <span class="badge badge-{{ $typeColor }} position-absolute" style="top: 10px; right: 10px;">
                        {{ $cert->type }}
                    </span>
                </div>

                <div class="card-body">
                    <h5 class="font-weight-bold mb-2">{{ $cert->judul }}</h5>
                    <p class="text-muted text-small mb-3">
                        <i class="mdi mdi-bank"></i> {{ $cert->issued }} |
                        <i class="mdi mdi-calendar"></i> {{ \Carbon\Carbon::parse($cert->tanggal)->year }}
                    </p>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge badge-outline-{{ $statusColor }}">{{ $cert->status }}</span>
                        <small class="text-muted">ID: {{ $cert->kredensial ?? '-' }}</small>
                    </div>

                    <div class="mb-3">
                        @if($cert->skill)
                            @foreach(array_slice($cert->skill, 0, 3) as $s)
                                <span class="badge badge-inverse-info p-1" style="font-size: 10px">{{ $s }}</span>
                            @endforeach
                            @if(count($cert->skill) > 3) <small>+{{ count($cert->skill)-3 }}</small> @endif
                        @endif
                    </div>

                    <div class="border-top pt-3 d-flex justify-content-between">
                        @if($cert->link)
                            <a href="{{ $cert->link }}" target="_blank" class="btn btn-inverse-light btn-sm"><i class="mdi mdi-link"></i> Verify</a>
                        @else
                            <button disabled class="btn btn-inverse-secondary btn-sm">No Link</button>
                        @endif

                        <div>
                            <a href="{{ route('admin.certificate.edit', $cert->id) }}" class="btn btn-warning btn-sm p-2"><i class="mdi mdi-pencil"></i></a>
                            <form action="{{ route('admin.certificate.destroy', $cert->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this item?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm p-2"><i class="mdi mdi-delete"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">No certificates found.</h4>
        </div>
    @endforelse
</div>
@endsection
