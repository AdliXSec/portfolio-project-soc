@extends('admin.layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="row">
    <div class="col-12">
        <h4 class="card-title mb-4">Search Results for: <span class="text-primary">"{{ $query }}"</span></h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Projects Found ({{ $projects->count() }})</h4>
                @if($projects->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.project.edit', $project->id) }}" class="text-white" style="text-decoration: none;">
                                            <div class="d-flex align-items-center">
                                                <i class="mdi mdi-briefcase text-info icon-md me-3"></i>
                                                <div>
                                                    <p class="mb-1 font-weight-bold">{{ $project->judul }}</p>
                                                    <p class="text-muted mb-0 text-small">{{ Str::limit($project->deskripsi, 40) }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.project.edit', $project->id) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No projects found matching your query.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Certificates Found ({{ $certificates->count() }})</h4>
                @if($certificates->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                @foreach($certificates as $cert)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.certificate.edit', $cert->id) }}" class="text-white" style="text-decoration: none;">
                                            <div class="d-flex align-items-center">
                                                <i class="mdi mdi-certificate text-warning icon-md me-3"></i>
                                                <div>
                                                    <p class="mb-1 font-weight-bold">{{ $cert->judul }}</p>
                                                    <p class="text-muted mb-0 text-small">{{ $cert->issued }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.certificate.edit', $cert->id) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No certificates found matching your query.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
