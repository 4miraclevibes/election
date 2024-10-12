@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-body">
      Total Pemilih : {{ $tpsParticipants->count() }}
      <br>
      Total Dukungan : {{ $tpsParticipants->where('status', 'done')->count() }}
      <br>
      Total Tidak Dukungan : {{ $tpsParticipants->where('status', 'pending')->count() }}
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Table Participant</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Name</th>
            <th class="text-white">Address</th>
            <th class="text-white">Sex</th>
            <th class="text-white">Age</th>
            <th class="text-white">TPS</th>
            <th class="text-white">Kelurahan</th>
            <th class="text-white">Kecamatan</th>
            <th class="text-white">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tpsParticipants as $participant)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $participant->name }}</td>
            <td>{{ $participant->address }}</td>
            <td>{{ $participant->sex }}</td>
            <td>{{ $participant->age }}</td>
            <td>{{ $participant->tpsElection->name }}</td>
            <td>{{ $participant->tpsElection->kelurahanElection->name }}</td>
            <td>{{ $participant->tpsElection->kelurahanElection->kecamatanElection->name }}</td>
            <td>{{ $participant->status }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- / Content -->
@endsection

@push('scripts')
<script>
  // Inisialisasi DataTable jika belum ada
  $(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#example')) {
      $('#example').DataTable();
    }
  });
  $(document).ready(function() {
    $('#select1').select2();
  });
</script>
@endpush