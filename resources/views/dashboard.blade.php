@extends('layouts.dashboard.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1>Selamat datang {{ Auth::user()->name }}</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Dukungan per Kecamatan</h5>
                    <canvas id="kecamatanChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Persentase Dukungan per Kelurahan</h5>
                    <canvas id="kelurahanChart"></canvas>
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
    // Chart Kecamatan
    var kecamatanCtx = document.getElementById('kecamatanChart').getContext('2d');
    var kecamatanChart = new Chart(kecamatanCtx, {
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart Kelurahan
    var kelurahanCtx = document.getElementById('kelurahanChart').getContext('2d');
    var kelurahanChart = new Chart(kelurahanCtx, {
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
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Persentase Dukungan per Kelurahan'
                }
            }
        }
    });
});
</script>
@endsection
