@extends('admin.layouts.app')

@section('title', 'Command Center')

@push('plugin-js')
    @if(isset($chartData) && count($chartData) > 0)
        <script>
            var monthlyLabels = {!! json_encode($chartData->pluck('label')->toArray()) !!};
            var monthlyVisits = {!! json_encode($chartData->pluck('visits')->toArray()) !!};
        </script>
        <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @endif
@endpush

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                        <div class="col-4 col-sm-3 col-xl-2">
                            <img  loading="lazy" src="{{ asset('assets/images/dashboard/Group126.svg') }}" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h4 class="mb-1 mb-sm-0">Welcome back, {{ Auth::user()->name }}!</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">System status is stable. Monitoring active traffic.</p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                            <span>
                                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-light btn-rounded get-started-btn">View Website</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ number_format($totalViews ?? 0) }}</h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium">+2.1%</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-eye icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Page Views</h6>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ number_format($totalUniqueIPs ?? 0) }}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-primary">
                                <span class="mdi mdi-access-point-network icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Unique Visitors</h6>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalProjects ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-warning">
                                <span class="mdi mdi-briefcase-check icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Projects Portfolio</h6>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalCertificates ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-danger">
                                <span class="mdi mdi-certificate icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Certificates</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Traffic Analytics</h4>
                        <p class="text-muted mb-0 text-small">Monthly Overview</p>
                    </div>
                    <canvas id="lineChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Visited Pages</h4>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                @forelse($topPages ?? [] as $page)
                                    @php
                                        // Hitung persentase sederhana untuk progress bar
                                        $percent = ($totalViews > 0) ? ($page->views_count / $totalViews) * 100 : 0;
                                        // Warna random untuk variasi
                                        $colors = ['primary', 'success', 'warning', 'danger', 'info'];
                                        $color = $colors[$loop->index % 5];
                                    @endphp
                                    <tr>
                                        <td class="ps-0">
                                            <p class="mb-1 text-small text-muted">{{ Str::limit($page->path, 30) }}</p>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0 text-muted font-weight-bold">
                                            {{ $page->views_count }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="text-muted">No data yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="mdi mdi-console text-success me-2"></i>Live Activity Log</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Timestamp</th>
                                    <th>IP Address</th>
                                    <th>Path Accessed</th>
                                    <th>Referrer</th>
                                    <th>Session Hash</th>
                                </tr>
                            </thead>
                            <tbody style="font-family: 'Consolas', 'Monaco', monospace; font-size: 0.85rem;">
                                @forelse($recentLogs ?? [] as $log)
                                    <tr>
                                        <td class="text-muted">{{ $log->created_at->format('H:i:s d-M') }}</td>
                                        <td class="text-info">{{ $log->user_ip }}</td>
                                        <td>
                                            <span class="text-success">GET</span>
                                            <span class="text-white">{{ Str::limit($log->path, 40) }}</span>
                                        </td>
                                        <td class="text-muted">{{ Str::limit($log->referrer ?? '-', 30) }}</td>
                                        <td class="text-warning">{{ Str::limit($log->session_id, 8, '') }}...</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center">No recent activity detected.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
