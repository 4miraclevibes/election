@extends('layouts.landing.main')

@section('style')
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 960px;
    }
    .banner img {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .section-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    .kecamatan-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
        padding-bottom: 10px;
    }
    .kecamatan-wrapper::-webkit-scrollbar {
        display: none;
    }
    .kecamatan-item {
        flex: 0 0 auto;
        width: auto;
        text-align: center;
        padding: 8px 16px;
        border-radius: 20px;
        margin-right: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .kecamatan-item a {
        font-size: 0.9rem;
        margin: 0;
        color: #333;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-body {
        padding: 1rem;
    }
    .card-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: #333;
    }
    .card-text {
        font-size: 0.8rem;
        color: #666;
    }
    .btn-detail {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        font-size: 0.8rem;
        transition: background-color 0.2s;
    }
    .btn-detail:hover {
        background-color: #45a049;
    }
    .modal-content {
        border-radius: 10px 10px 0 0;
    }
    .tps-button {
        border: 1px solid #ddd;
        background-color: white;
        color: #333;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .tps-button.active {
        background-color: #4CAF50;
        color: white;
        border-color: #4CAF50;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <section class="banner mb-4">
        <img src="{{ asset('assets/landing/images/derisesni.png') }}" alt="Banner" class="w-100">
    </section>

    <section class="kecamatan mb-4">
        <h2 class="section-title">{{ !$activeKecamatanElection ? 'Semua Kecamatan' : $activeKecamatanElection->name }} {{ Auth::user()->role->name !== 'admin' ? ' di ' . Auth::user()->kecamatanElection->name : '' }}</h2>
        <div class="kecamatan-wrapper">
            <div class="d-flex">
                <div class="kecamatan-item {{ !$activeKecamatanElection ? 'bg-success' : '' }}">
                    <a href="{{ route('home') }}" class="text-decoration-none {{ !$activeKecamatanElection ? 'fw-bold text-white active' : '' }}">
                        Semua
                    </a>
                </div>
                @if($activeKecamatanElection)
                <div class="kecamatan-item bg-success">
                    <a href="{{ route('home', ['kecamatan' => $activeKecamatanElection->slug]) }}" class="text-decoration-none fw-bold text-white active">
                        {{ $activeKecamatanElection->name }}
                    </a>
                </div>
                @foreach($kecamatanElections->whereNotIn('id', $activeKecamatanElection->id) as $kecamatanElection)
                <div class="kecamatan-item">
                    <a href="{{ route('home', ['kecamatan' => $kecamatanElection->slug]) }}" class="text-decoration-none">
                        {{ $kecamatanElection->name }}
                    </a>
                </div>
                @endforeach
                @else
                @foreach($kecamatanElections as $kecamatanElection)
                <div class="kecamatan-item">
                    <a href="{{ route('home', ['kecamatan' => $kecamatanElection->slug]) }}" class="text-decoration-none">
                        {{ $kecamatanElection->name }}
                    </a>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </section>

    <section class="kelurahan">
        @if($activeKecamatanElection)
        <h5 class="section-title">Kelurahan di Kecamatan <span class="text-success">{{ $activeKecamatanElection->name }}</span> <br> <span class="text-primary">{{ $activeKecamatanElection->user->name }}</span></h5>
        @else
        <h5 class="section-title">Kelurahan {{ Auth::user()->role->name !== 'admin' ? 'di Kecamatan ' . Auth::user()->kecamatanElection->name : 'di Semua Kecamatan' }}</h5>
        @endif
        <div class="row g-3">
            @foreach($kelurahanElections as $kelurahanElection)
            <div class="col-md-6 col-lg-6 col-6">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Kel {{ $kelurahanElection->name }}</h3>
                        <p class="card-text mb-2">PJ: {{ $kelurahanElection->user->name }}</p>
                        <p class="card-text">Dukungan: {{ number_format($kelurahanElection->participantElections->count() ?? 0, 0, ',', '.') }} / {{ number_format($kelurahanElection->tpsElection->sum('total_invitation') ?? 0, 0, ',', '.') }}</p>
                        <p class="card-text">Dukungan Tanpa NIK: {{ number_format($kelurahanElection->participantElections->whereNull('nik')->count() ?? 0, 0, ',', '.') }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="btn-detail text-decoration-none" 
                                   data-kelurahan-id="{{ $kelurahanElection->id }}"
                                   data-kelurahan-name="{{ $kelurahanElection->name }}"
                                   data-kelurahan-pemilih="{{ number_format($kelurahanElection->tpsElection->sum('total_invitation') ?? 0, 0, ',', '.') }}"
                                   data-memilih="{{ number_format($kelurahanElection->participantElections->count() ?? 0, 0, ',', '.') }}"
                                   data-memilih-tanpa-nik="{{ number_format($kelurahanElection->participantElections->whereNull('nik')->count() ?? 0, 0, ',', '.') }}"
                                   data-tps-election="{{ json_encode($kelurahanElection->tpsElection->map(function($tpsElection) {
                                       return [
                                           'id' => $tpsElection->id,
                                           'name' => $tpsElection->name,
                                           'user_id' => $tpsElection->user->name,
                                           'email' => $tpsElection->user->email,
                                           'jumlah_pemilih' => $tpsElection->total_invitation ?? 0,
                                           'jumlah_memilih' => $tpsElection->participantElection->count() ?? 0,
                                           'jumlah_memilih_tanpa_nik' => $tpsElection->participantElection->whereNull('nik')->count() ?? 0,
                                       ];
                                   })) }}">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <h4 id="kelurahanName" class="mb-2"></h4>
                    <p id="totalPemilih" class="text-muted mb-2"></p>
                    <p id="totalMemilih" class="text-muted mb-2"></p>
                    <p id="totalMemilihTanpaNik" class="text-muted mb-3"></p>
                    
                    <h5 class="mb-3">Daftar TPS</h5>
                    <div id="tpsButtons" class="d-flex flex-wrap gap-2 mb-3">
                        <!-- TPS buttons akan ditambahkan secara dinamis menggunakan JavaScript -->
                    </div>
                    
                    <p class="mb-0">PJ TPS: <span id="tpsPj" class="fw-bold"></span></p>
                    <p class="mb-0" style="font-size: 0.7rem">Email PJ TPS: <span id="tpsEmail" class="fw-bold"></span></p>
                    <p class="mb-0">Pemilih TPS: <span id="tpsPemilih" class="fw-bold"></span></p>
                    <p class="mb-0">Dukungan TPS: <span id="tpsMemilih" class="fw-bold"></span></p>
                    <p class="mb-0">Tanpa NIK: <span id="tpsMemilihTanpaNik" class="fw-bold"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailButtons = document.querySelectorAll('.btn-detail');
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    let currentTPS = [];

    detailButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const kelurahanId = this.dataset.kelurahanId;
            const kelurahanName = this.dataset.kelurahanName;
            const kelurahanPemilih = this.dataset.kelurahanPemilih;
            const memilih = this.dataset.memilih;
            const memilihTanpaNik = this.dataset.memilihTanpaNik;
            currentTPS = JSON.parse(this.dataset.tpsElection);

            document.getElementById('kelurahanName').textContent = kelurahanName;
            document.getElementById('totalPemilih').textContent = `Total Pemilih: ${kelurahanPemilih}`;
            document.getElementById('totalMemilih').textContent = `Total Memilih: ${memilih}`;
            document.getElementById('totalMemilihTanpaNik').textContent = `Total Memilih Tanpa NIK: ${memilihTanpaNik}`;
            const tpsButtons = document.getElementById('tpsButtons');
            tpsButtons.innerHTML = '';
            currentTPS.forEach(tps => {
                const button = document.createElement('button');
                button.textContent = tps.name;
                button.classList.add('tps-button');
                button.onclick = (e) => {
                    e.preventDefault();
                    selectTPS(tps);
                };
                tpsButtons.appendChild(button);
            });

            if (currentTPS.length > 0) {
                selectTPS(currentTPS[0]);
            }

            modal.show();
        });
    });

    function selectTPS(tps) {
        document.getElementById('tpsPemilih').textContent = tps.jumlah_pemilih.toLocaleString('id-ID');
        document.getElementById('tpsMemilih').textContent = tps.jumlah_memilih.toLocaleString('id-ID');
        document.getElementById('tpsMemilihTanpaNik').textContent = tps.jumlah_memilih_tanpa_nik.toLocaleString('id-ID');
        document.getElementById('tpsPj').textContent = tps.user_id;
        document.getElementById('tpsEmail').textContent = tps.email;
        document.querySelectorAll('.tps-button').forEach(btn => {
            btn.classList.remove('active');
            if (btn.textContent === tps.name) {
                btn.classList.add('active');
            }
        });
    }
});
</script>
@endsection