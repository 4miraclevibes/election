@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <a href="{{ route('dashboard.kecamatan.index') }}" class="btn btn-secondary btn-sm mb-2">Back</a>
      <p class="mb-0">Jumlah Dukungan: {{ $kecamatanElection->totalParticipant() }} / {{ $kecamatanElection->totalInvitation() }}</p>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Table Dukungan Kecamatan {{ $kecamatanElection->name }}</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Name</th>
            <th class="text-white">Address</th>
            <th class="text-white">Phone</th>
            <th class="text-white">Relawan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kecamatanElection->participantElections as $participantElection)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $participantElection->name }}</td>
            <td>{{ $participantElection->address }}</td>
            <td>{{ $participantElection->phone }}</td>
            <td>{{ $participantElection->tpsElection->user->name }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection