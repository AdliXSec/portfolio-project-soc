@extends('admin.layouts.app')

@section('title', 'Security Logs')

@section('content')
<div class="row">
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-white">📜 Security Logs</h3>
            <p class="text-muted">Recorded suspicious activities and potential threats.</p>
        </div>
        <a href="{{ route('admin.security.index') }}" class="btn btn-outline-light btn-icon-text">
            <i class="mdi mdi-arrow-left btn-icon-prepend"></i> Back to SOC
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Activity Log</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>IP Address</th>
                                <th>Path</th>
                                <th style="width: 30%;">Payload</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>
                                        @if($log->type == 'SQLi')
                                            <span class="badge badge-danger">SQLi</span>
                                        @elseif($log->type == 'XSS')
                                            <span class="badge badge-warning">XSS</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $log->type }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $log->ip_address }}</td>
                                    <td>{{ $log->path }}</td>
                                    <td>
                                        <code class="text-white" style="white-space: pre-wrap; word-break: break-all;">{{ $log->payload }}</code>
                                    </td>
                                    <td>{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No suspicious activity recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
