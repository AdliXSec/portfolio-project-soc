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
    setInterval(fetchSecurityData, 3000);
    fetchSecurityData(); // Jalankan langsung saat load
</script>
@endpush
@endsection
