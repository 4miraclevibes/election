@extends('layouts.dashboard.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="mb-4">Selamat datang {{ Auth::user()->name }}</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Jumlah Dukungan per Kecamatan</h5>
                    <div style="height: 300px;">
                        <canvas id="kecamatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Persentase Dukungan per Kelurahan</h5>
                    <div style="height: 300px;">
                        <canvas id="kelurahanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Jumlah Dukungan Tanpa NIK per Kelurahan</h5>
                    <div style="height: 300px;">
                        <canvas id="dukunganTanpaNikChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                font: {
                    size: 16
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Chart Kecamatan
    new Chart(document.getElementById('kecamatanChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! $kecamatanLabels !!},
            datasets: [{
                label: 'Jumlah Dukungan',
                data: {!! $kecamatanValues !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            ...chartOptions,
            plugins: {
                ...chartOptions.plugins,
                title: {
                    ...chartOptions.plugins.title,
                    text: 'Jumlah Dukungan per Kecamatan'
                }
            }
        }
    });

    // Chart Kelurahan
    new Chart(document.getElementById('kelurahanChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: {!! $kelurahanLabels !!},
            datasets: [{
                data: {!! $kelurahanValues !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            ...chartOptions,
            plugins: {
                ...chartOptions.plugins,
                title: {
                    ...chartOptions.plugins.title,
                    text: 'Persentase Dukungan per Kelurahan'
                }
            }
        }
    });

    // Chart Dukungan Tanpa NIK
    new Chart(document.getElementById('dukunganTanpaNikChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! $dukunganTanpaNikLabels !!},
            datasets: [{
                label: 'Jumlah Dukungan Tanpa NIK',
                data: {!! $dukunganTanpaNikValues !!},
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            ...chartOptions,
            plugins: {
                ...chartOptions.plugins,
                title: {
                    ...chartOptions.plugins.title,
                    text: 'Jumlah Dukungan Tanpa NIK per Kelurahan (Top 5)'
                }
            }
        }
    });
});
</script>
@endsection
