@extends('admin.layouts.app')

@section('title', 'Security Operations Center')

@section('content')
<div class="row">
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-white">🛡️ Security Operations Center (SOC)</h3>
            <p class="text-muted">Real-time monitoring for threats and anomalies.</p>
        </div>
        <a href="{{ route('admin.security.firewall') }}" class="btn btn-danger btn-icon-text">
            <i class="mdi mdi-firewall btn-icon-prepend"></i> Manage Firewall
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row mb-4">
    <div class="col-12">
        <div class="card border border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title text-warning mb-0"><i class="mdi mdi-cog me-2"></i>SOC Control Panel</h4>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background: rgba(255,255,255,0.05);">
                            <div>
                                <h6 class="text-white mb-1">SOC Monitoring</h6>
                                <small class="text-muted">Enable/Disable real-time monitoring</small>
                            </div>
                            <div class="toggle-switch">
                                <input type="checkbox" id="soc_enabled" class="toggle-input" {{ $settings['soc_enabled'] ?? false ? 'checked' : '' }}>
                                <label for="soc_enabled" class="toggle-label"></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background: rgba(255,255,255,0.05);">
                            <div>
                                <h6 class="text-white mb-1">Auto Block</h6>
                                <small class="text-muted">Auto-block suspicious IPs</small>
                            </div>
                            <div class="toggle-switch">
                                <input type="checkbox" id="soc_auto_block" class="toggle-input" {{ $settings['soc_auto_block'] ?? false ? 'checked' : '' }}>
                                <label for="soc_auto_block" class="toggle-label"></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <form action="{{ route('admin.security.threshold') }}" method="POST" class="d-flex align-items-center justify-content-between p-3 rounded" style="background: rgba(255,255,255,0.05);">
                            @csrf
                            @method('PUT')
                            <div>
                                <h6 class="text-white mb-1">Block Threshold</h6>
                                <small class="text-muted">Failed attempts before block</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <input type="number" name="threshold" value="{{ $settings['soc_block_threshold'] ?? 5 }}" min="1" max="100" class="form-control form-control-sm text-white text-center" style="width: 60px;">
                                <button type="submit" class="btn btn-warning btn-sm"><i class="mdi mdi-check"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-3 pt-3 border-top border-secondary">
                    <div class="d-flex align-items-center">
                        <div id="soc-status-indicator" class="me-2" style="width: 12px; height: 12px; border-radius: 50%; background: {{ $settings['soc_enabled'] ?? false ? '#00d25b' : '#6c757d' }}; box-shadow: 0 0 10px {{ $settings['soc_enabled'] ?? false ? '#00d25b' : 'transparent' }};"></div>
                        <span id="soc-status-text" class="{{ $settings['soc_enabled'] ?? false ? 'text-success' : 'text-muted' }}">
                            SOC is {{ $settings['soc_enabled'] ?? false ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card border border-primary">
            <div class="card-body">
                <h4 class="card-title text-primary"><i class="mdi mdi-server me-2"></i>Server Resources</h4>

                <div class="mb-4">
                    <div class="d-flex justify-content-between">
                        <span>CPU Load (Simulated)</span>
                        <span id="cpu-text" class="text-danger fw-bold">0%</span>
                    </div>
                    <div class="progress progress-sm">
                        <div id="cpu-bar" class="progress-bar bg-danger" role="progressbar" style="width: 0%"></div>
                    </div>
                    <small class="text-muted">High usage might indicate mining malware.</small>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>RAM Usage (PHP)</span>
                        <span id="ram-text" class="text-warning fw-bold">0 MB</span>
                    </div>
                    <div class="progress progress-sm">
                        <div id="ram-bar" class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin stretch-card">
        <div class="card border border-danger">
            <div class="card-body text-center">
                <h4 class="card-title text-danger"><i class="mdi mdi-shield-alert me-2"></i>Threat Intelligence</h4>

                <div class="row mt-4">
                    <div class="col-6 border-right">
                        <h2 class="text-white font-weight-bold" id="failed-logins">0</h2>
                        <p class="text-muted">Failed Logins</p>
                        <small class="text-danger">Possible Brute Force</small>
                    </div>
                    <div class="col-6">
                        <h2 class="text-white font-weight-bold" id="error-403">0</h2>
                        <p class="text-muted">403 Forbidden</p>
                        <small class="text-success">Firewall Blocking</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin stretch-card">
        <div class="card border border-success">
            <div class="card-body">
                <h4 class="card-title text-success"><i class="mdi mdi-lock me-2"></i>SSL/TLS Status</h4>
                <div class="d-flex align-items-center justify-content-center flex-column" style="height: 100%;">
                    <i class="mdi mdi-certificate text-white" style="font-size: 4rem;"></i>
                    <h2 class="mt-3 text-white" id="ssl-days">0 Days</h2>
                    <p class="text-muted">Remaining Validity</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Traffic Anomaly Detection (Requests)</h4>
                <canvas id="trafficChart" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">HTTP Response Codes</h4>
                <canvas id="statusChart" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>

@push('plugin-js')
<script>
    // --- 1. CONFIGURASI CHART ---
    // Traffic Chart (Line)
    var trafficCtx = document.getElementById('trafficChart').getContext('2d');
    var trafficChart = new Chart(trafficCtx, {
        type: 'line',
        data: {
            labels: [], // Diisi Live
            datasets: [{
                label: 'Incoming Requests',
                data: [],
                borderColor: '#00d25b',
                backgroundColor: 'rgba(0, 210, 91, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{ gridLines: { display: false, color: "rgba(255,255,255,0.1)" } }],
                yAxes: [{ gridLines: { color: "rgba(255,255,255,0.1)" } }]
            },
            elements: { point: { radius: 0 } } // Sembunyikan titik agar seperti detak jantung
        }
    });

    // Status Chart (Doughnut)
    var statusCtx = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['200 OK', '403 Forbidden', '404 Not Found', '500 Error'],
            datasets: [{
                data: [100, 0, 0, 0], // Default
                backgroundColor: ['#00d25b', '#ffab00', '#8f5fe8', '#fc424a']
            }]
        },
        options: { cutoutPercentage: 70 }
    });

    // --- 2. FUNGSI FETCH DATA LIVE (AJAX) ---
    function fetchSecurityData() {
        fetch("{{ route('admin.security.api') }}")
            .then(response => response.json())
            .then(data => {
                // A. Update Server Resources
                document.getElementById('cpu-text').innerText = data.server.cpu_load + '%';
                document.getElementById('cpu-bar').style.width = data.server.cpu_load + '%';

                document.getElementById('ram-text').innerText = data.server.memory + ' MB';
                document.getElementById('ram-bar').style.width = (data.server.memory / 100 * 100) + '%'; // Asumsi scale sederhana

                // B. Update Threat Intel
                document.getElementById('failed-logins').innerText = data.security.failed_logins;
                document.getElementById('error-403').innerText = data.errors['403'];
                document.getElementById('ssl-days').innerText = data.security.ssl_days + ' Days';

                // C. Update Traffic Chart (Simulasi Realtime push)
                const now = new Date().toLocaleTimeString();
                // Tambah data baru di kanan
                if(trafficChart.data.labels.length > 10) {
                    trafficChart.data.labels.shift(); // Hapus data lama
                    trafficChart.data.datasets[0].data.shift();
                }
                trafficChart.data.labels.push(now);
                // Ambil data traffic terakhir (dummy logic dari count menit terakhir)
                let lastCount = data.traffic.length > 0 ? data.traffic[data.traffic.length-1].count : 0;
                trafficChart.data.datasets[0].data.push(lastCount);
                trafficChart.update();

                // D. Update Status Chart
                // Disini kita hitung rasio. Untuk demo, kita pakai data error langsung
                // (Perlu logika total 200 OK di backend untuk akurat, disini kita update errornya saja)
                statusChart.data.datasets[0].data = [
                    50, // Dummy 200 OK (Statik dulu)
                    data.errors['403'],
                    data.errors['404'],
                    data.errors['500']
                ];
                statusChart.update();
            });
    }

    // --- 3. JALANKAN INTERVAL (SETIAP 3 DETIK) ---
    let socEnabled = {{ $settings['soc_enabled'] ?? false ? 'true' : 'false' }};
    let fetchInterval = null;

    function startMonitoring() {
        if (fetchInterval) clearInterval(fetchInterval);
        fetchInterval = setInterval(fetchSecurityData, 3000);
        fetchSecurityData();
    }

    function stopMonitoring() {
        if (fetchInterval) {
            clearInterval(fetchInterval);
            fetchInterval = null;
        }
    }

    if (socEnabled) {
        startMonitoring();
    }

    // --- 4. TOGGLE SWITCH HANDLER ---
    function handleToggle(key, checkbox) {
        const value = checkbox.checked;

        fetch("{{ route('admin.security.toggle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ key: key, value: value })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (key === 'soc_enabled') {
                    const indicator = document.getElementById('soc-status-indicator');
                    const statusText = document.getElementById('soc-status-text');

                    if (value) {
                        indicator.style.background = '#00d25b';
                        indicator.style.boxShadow = '0 0 10px #00d25b';
                        statusText.className = 'text-success';
                        statusText.innerText = 'SOC is Active';
                        socEnabled = true;
                        startMonitoring();
                    } else {
                        indicator.style.background = '#6c757d';
                        indicator.style.boxShadow = 'none';
                        statusText.className = 'text-muted';
                        statusText.innerText = 'SOC is Inactive';
                        socEnabled = false;
                        stopMonitoring();
                    }
                }
            } else {
                checkbox.checked = !value;
                alert('Failed to update setting');
            }
        })
        .catch(error => {
            checkbox.checked = !value;
            console.error('Error:', error);
        });
    }

    document.getElementById('soc_enabled').addEventListener('change', function() {
        handleToggle('soc_enabled', this);
    });

    document.getElementById('soc_auto_block').addEventListener('change', function() {
        handleToggle('soc_auto_block', this);
    });
</script>

<style>
    .toggle-switch {
        position: relative;
        width: 50px;
        height: 26px;
    }

    .toggle-input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-label {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #3a3a3a;
        transition: 0.3s;
        border-radius: 26px;
    }

    .toggle-label:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }

    .toggle-input:checked + .toggle-label {
        background-color: #00d25b;
        box-shadow: 0 0 10px rgba(0, 210, 91, 0.5);
    }

    .toggle-input:checked + .toggle-label:before {
        transform: translateX(24px);
    }

    .toggle-input:focus + .toggle-label {
        box-shadow: 0 0 1px #00d25b;
    }
</style>
@endpush
@endsection
