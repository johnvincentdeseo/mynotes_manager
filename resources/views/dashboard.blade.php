@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold text-dark mb-1">Dashboard</h1>
            <p class="text-muted small mb-0">Good day, <span class="fw-bold text-secondary">{{ auth()->user()->name }}!</span></p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3">
                <div class="card-body d-flex align-items-center gap-3 p-2">
                    <div class="fs-2 p-3 bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem;">👥</div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0 fs-2">{{ $totalUsers }}</h3>
                        <p class="text-muted small fw-medium mb-0">Total Users</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3">
                <div class="card-body d-flex align-items-center gap-3 p-2">
                    <div class="fs-2 p-3 bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem; color: #E67E5A !important; background-color: rgba(230, 126, 90, 0.1) !important;">📄</div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0 fs-2">{{ $totalNotes }}</h3>
                        <p class="text-muted small fw-medium mb-0">Total Notes</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3">
                <div class="card-body d-flex align-items-center gap-3 p-2">
                    <div class="fs-2 p-3 bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem;">📈</div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0 fs-2">{{ $myNotesCount }}</h3>
                        <p class="text-muted small fw-medium mb-0">My Notes</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3">
                <div class="card-body d-flex align-items-center gap-3 p-2">
                    <div class="fs-2 p-3 bg-info bg-opacity-10 text-info rounded-3 d-flex align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem;">📅</div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0 fs-2">{{ $thisMonthNotes }}</h3>
                        <p class="text-muted small fw-medium mb-0">This Month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-5 p-4 d-flex flex-column justify-content-between layout-chart-card" style="min-height: 380px;">
                <div class="mb-3">
                    <h5 class="fw-bold text-dark mb-1">Notes Created Over Time</h5>
                    <p class="text-muted text-uppercase tracking-wider mb-0" style="font-size: 11px; font-weight: 600;">Daily note creation log volume</p>
                </div>
                <div class="position-relative flex-grow-1 w-100" style="height: 240px;">
                    <canvas id="dashboardTimelineChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-5 p-4 d-flex flex-column justify-content-between layout-chart-card" style="min-height: 380px;">
                <div class="mb-3">
                    <h5 class="fw-bold text-dark mb-1">Users vs Notes</h5>
                    <p class="text-muted text-uppercase tracking-wider mb-0" style="font-size: 11px; font-weight: 600;">Proportional system-wide distribution</p>
                </div>
                <div class="position-relative flex-grow-1 w-100 d-flex align-items-center justify-content-center" style="height: 240px;">
                    <div style="width: 210px; height: 210px; max-width: 100%; max-height: 100%;">
                        <canvas id="dashboardComparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.5rem !important; }
    .rounded-5 { border-radius: 2.25rem !important; }
    .tracking-wider { letter-spacing: 0.05em !important; }
    .layout-chart-card { background-color: #ffffff; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        const ctxTimeline = document.getElementById('dashboardTimelineChart').getContext('2d');
        new Chart(ctxTimeline, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Notes Created',
                    data: {!! json_encode($counts) !!},
                    borderColor: '#E67E5A', 
                    backgroundColor: 'rgba(230, 126, 90, 0.06)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#E67E5A',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#94a3b8' },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        ticks: { color: '#94a3b8' },
                        grid: { display: false }
                    }
                }
            }
        });

  
        const ctxCompare = document.getElementById('dashboardComparisonChart').getContext('2d');
        new Chart(ctxCompare, {
            type: 'doughnut',
            data: {
                labels: ['Total Users', 'Total Notes'],
                datasets: [{
                    data: [{{ $totalUsers }}, {{ $totalNotes }}],
                    backgroundColor: ['#2D509E', '#E67E5A'], 
                    borderWidth: 4,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: { size: 12, weight: 'bold' },
                            color: '#64748b',
                            padding: 14
                        }
                    }
                },
                cutout: '72%' 
            }
        });
    });
</script>
@endsection