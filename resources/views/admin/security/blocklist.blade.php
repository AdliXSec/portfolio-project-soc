@extends('admin.layouts.app')

@section('title', 'Firewall Manager')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="text-danger"><i class="mdi mdi-firewall me-2"></i>Firewall Manager</h3>
                <p class="text-muted">Manually block suspicious IPs or manage existing rules.</p>
            </div>
            <a href="{{ route('admin.security.index') }}" class="btn btn-outline-secondary">
                <i class="mdi mdi-arrow-left"></i> Back to SOC
            </a>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4 grid-margin stretch-card">
        <div class="card border-danger">
            <div class="card-body">
                <h4 class="card-title text-danger">Block New IP</h4>
                <p class="text-small text-muted mb-4">This action will instantly deny access (403) to the target IP.</p>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.security.block') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Target IP Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-danger text-white border-danger">
                                    <i class="mdi mdi-target"></i>
                                </span>
                            </div>
                            <input type="text" name="ip_address" class="form-control text-white" placeholder="e.g. 192.168.1.50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Reason / Note</label>
                        <textarea name="reason" class="form-control text-white" rows="3" placeholder="e.g. Spamming contact form"></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 btn-lg">
                        <i class="mdi mdi-block-helper me-2"></i> BLOCK ACCESS
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Active Blacklist Rules</h4>

                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>IP Address</th>
                                <th>Reason</th>
                                <th>Blocked At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blockedIps as $ip)
                                <tr>
                                    <td class="text-danger font-weight-bold font-monospace">
                                        <i class="mdi mdi-cancel me-1"></i> {{ $ip->ip_address }}
                                    </td>
                                    <td>
                                        <span class="badge badge-outline-warning">{{ $ip->reason }}</span>
                                    </td>
                                    <td class="text-muted">
                                        {{ $ip->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.security.unblock', $ip->id) }}" method="POST" onsubmit="return confirm('Unblock IP {{ $ip->ip_address }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="mdi mdi-lock-open-variant me-1"></i> Unblock
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="mdi mdi-shield-check" style="font-size: 3rem;"></i>
                                            <p class="mt-2">No active blocks. System is clean.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
        <div class="col-12 grid-margin stretch-card">
            <div class="card border-secondary">
                <div class="card-body">
                    <h4 class="card-title text-info">
                        <i class="mdi mdi-radar me-2"></i>Suspicious Activity Monitor (Live Logs)
                    </h4>
                    <p class="text-muted mb-3">Analyze recent traffic and click the <span class="text-danger">Block</span> button to instantly blacklist an IP.</p>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Status</th> <th>IP Address</th>
                                    <th>Location / Device</th>
                                    <th>Path Accessed</th>
                                    <th>Timestamp</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="live-log-body" class="font-monospace" style="font-size: 0.85rem;">
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Loading live data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('plugin-js')
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // PERBAIKAN 1: Gunakan tanda kutip yang benar atau helper route Laravel
        // const apiUrl = "http://127.0.0.1:8000/admin/security/api/logs";
        // Lebih baik pakai ini:
        const apiUrl = "{{ route('admin.security.logs.api') }}";

        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : ''; // Cegah error jika null

        // Jika token kosong, tampilkan error di console agar kita tahu
        if (!csrfToken) {
            console.error('CSRF Token not found in meta tag!');
        }

        function fetchBlocklistLogs() {
            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const tableBody = document.getElementById('live-log-body');
                    let htmlContent = '';

                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No recent activity.</td></tr>';
                        return;
                    }

                    data.forEach(log => {
                        let actionButton = '';
                        let ipDisplay = '';

                        // Logika Tampilan jika IP sudah diblokir
                        if (log.is_blocked) {
                            ipDisplay = `<span class="text-danger text-decoration-line-through" title="Already Blocked">${log.user_ip}</span>`;
                            actionButton = `
                                <button disabled class="btn btn-outline-secondary btn-sm btn-icon-text">
                                    <i class="mdi mdi-lock me-1"></i> Blocked
                                </button>
                            `;
                        } else {
                            ipDisplay = `<span class="text-white font-weight-bold">${log.user_ip}</span>`;
                            // Perhatikan penggunaan backtick (`) untuk string template
                            actionButton = `
                                <form action="${log.block_url}" method="POST" class="d-inline" onsubmit="return confirm('Block IP ${log.user_ip}?')">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="ip_address" value="${log.user_ip}">
                                    <input type="hidden" name="reason" value="Quick Block from Log Monitor">
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon-text" title="Block IP">
                                        <i class="mdi mdi-block-helper me-1"></i> Block IP
                                    </button>
                                </form>
                            `;
                        }

                        htmlContent += `
                            <tr>
                                <td>
                                    <label class="badge badge-outline-${log.badge_color}">${log.status_code}</label>
                                </td>
                                <td>${ipDisplay}</td>
                                <td>
                                    <i class="mdi ${log.device_icon} me-1 text-muted"></i>
                                    <span class="text-muted">
                                        ${log.country}
                                        <small class="d-block text-secondary" style="font-size: 10px;">${log.user_agent_short}</small>
                                    </span>
                                </td>
                                <td class="text-info">${log.path}</td>
                                <td>
                                    ${log.time_exact}
                                    <small class="d-block text-muted">${log.time_ago}</small>
                                </td>
                                <td>${actionButton}</td>
                            </tr>
                        `;
                    });

                    tableBody.innerHTML = htmlContent;
                })
                .catch(error => console.error('Error fetching logs:', error));
        }

        // Jalankan pertama kali
        fetchBlocklistLogs();

        // Ulangi setiap 3 detik
        setInterval(fetchBlocklistLogs, 3000);
    });
</script>
@endpush
