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
    @if(Auth::user()->tpsElectionDetails)
    <section class="entriData">
        <form action="{{ route('participant.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama</label>
            <input type="text" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Nama" name="name">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Alamat</label>
            <input type="text" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Alamat" name="address">    
        </div>
        <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">No. Telp</label>
                    <input type="text" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="No. Telp" name="phone">
                </div>
            </div>
        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
    </form>
    </section>
    @endif
    <section class="data mt-5">
        <h5 class="section-title mb-3">Data Pemilih <span class="text-success">{{ Auth::user()->tpsElectionDetails->tpsElection->kelurahanElection->name }} {{ Auth::user()->tpsElectionDetails->tpsElection->name }}</span></h5>
        <h5>Total Pemilih: {{ $participantElection->count() }}</h5>
        <div class="row g-3">
            @foreach($participantElection as $participantElection)
            <div class="col-md-6 col-lg-6 col-6">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Tps {{ $participantElection->tpsElection->name }}</h3>
                        <p class="card-text mb-0">Nama: {{ $participantElection->name }}</p>
                        <p class="card-text mb-0">Alamat: {{ $participantElection->address }}</p>
                        <p class="card-text mb-0">No. Telp: {{ $participantElection->phone }}</p>
                        <p class="card-text mb-0">Petugas: {{ $participantElection->tpsElectionDetail->user->name }}</p>
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