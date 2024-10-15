@extends('layouts.dashboard.main')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" />
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <a href="{{ route('dashboard.tps.index') }}" class="btn btn-secondary btn-sm mb-2">Back</a>
      <p class="mb-0">Jumlah Dukungan: {{ $tpsElection->participantElection->count() }} / {{ $tpsElection->total_invitation }}</p>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Table Dukungan TPS {{ $tpsElection->name }}</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example1">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Name</th>
            <th class="text-white">Address</th>
            <th class="text-white">Phone</th>
            <th class="text-white">Relawan</th>
            <th class="text-white">Kelurahan</th>
            <th class="text-white">Kecamatan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tpsElection->participantElection as $participantElection)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $participantElection->name }}</td>
            <td>{{ $participantElection->address }}</td>
            <td>{{ $participantElection->phone }}</td>
            <td>{{ $participantElection->tpsElectionDetail->user->name }}</td>
            <td>{{ $participantElection->tpsElection->kelurahanElection->name }}</td>
            <td>{{ $participantElection->tpsElection->kelurahanElection->kecamatanElection->name }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#example1').DataTable({
            layout: {
                topStart: {
                    buttons: ['excelHtml5', 'csvHtml5', 'pdfHtml5']
                }
            }
        });
    });
</script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
@endpush