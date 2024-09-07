<footer class="border-top">
    <div class="container">
        <div class="row py-2">
            <div class="col-3 text-center">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <i class="bi bi-house-door{{ Route::is('home') ? '-fill text-success' : ' text-secondary' }} fs-5"></i>
                    <p class="mb-0 small {{ Route::is('home') ? 'text-success' : 'text-secondary' }}">Beranda</p>
                </a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('participant.index') }}" class="text-decoration-none @auth{{ Auth::user()->tpsElection == null ? 'disabled' : '' }} @else disabled @endauth">
                    <i class="bi bi-cart{{ Route::is('participant.index') ? '-fill text-success' : ' text-secondary' }} fs-5"></i>
                    <p class="mb-0 small {{ Route::is('participant.index') ? 'text-success' : 'text-secondary' }}">Entri Data TPS</p>

                </a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('participant.all') }}" class="text-decoration-none">
                    <i class="bi bi-clipboard{{ Route::is('participant.all') ? '-fill text-success' : ' text-secondary' }} fs-5"></i>
                    <p class="mb-0 small {{ Route::is('participant.all') ? 'text-success' : 'text-secondary' }}">Pemilih</p>
                </a>
            </div>
            <div class="col-3 text-center">
                <a href="#" class="text-decoration-none">
                    <i class="bi bi-person fs-5 text-secondary"></i>
                    <p class="mb-0 small text-secondary">Quick Count</p>
                </a>
            </div>
        </div>
    </div>
</footer>