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
</style>
@endsection

@section('content')
<div class="container py-4">
    <section class="data">
        @if(Auth::user()->kelurahanElection)
        <h5 class="section-title mb-3">Data Pemilih {{ Auth::user()->kelurahanElection->name }}</h5>
        @elseif(Auth::user()->tpsElection)
        <h5 class="section-title mb-3">Data Pemilih {{ Auth::user()->tpsElection->name }}</h5>
        @elseif(Auth::user()->kecamatanElection)
        <h5 class="section-title mb-3">Data Pemilih {{ Auth::user()->kecamatanElection->name }}</h5>
        @else
        <h5 class="section-title mb-3">Data Pemilih</h5>
        @endif
        <h5>Total Pemilih: {{ $participantElection->count() }}</h5>
        <div class="row g-3">
            @foreach($participantElection as $participantElection)
            <div class="col-md-6 col-lg-6 col-6">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">TPS: {{ $participantElection->tpsElection->name }}</h3>
                        <h3 class="card-title">Kel: {{ $participantElection->tpsElection->kelurahanElection->name }}</h3>
                        <h3 class="card-title">Kec: {{ $participantElection->tpsElection->kelurahanElection->kecamatanElection->name }}</h3>
                        <p class="card-text mb-0">Name: {{ $participantElection->name }}</p>
                        <p class="card-text mb-0">Address: {{ $participantElection->address }}</p>
                        <p class="card-text mb-0">Phone: {{ $participantElection->phone }}</p>
                        <form action="{{ route('participant.destroy', $participantElection->id) }}" method="post" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection