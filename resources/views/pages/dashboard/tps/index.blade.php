@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createTpsModal">
        Create TPS
      </button>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Table TPS</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Name</th>
            <th class="text-white">PJ TPS</th>
            <th class="text-white">Kelurahan</th>
            <th class="text-white">Kecamatan</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tpsElections as $tps)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $tps->name }}</td>
            <td>{{ $tps->user->name }}</td>
            <td>{{ $tps->kelurahanElection->name }}</td>
            <td>{{ $tps->kelurahanElection->kecamatanElection->name }}</td>
              <td>
                <form action="{{ route('dashboard.tps.destroy', $tps->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
              </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Create TPS -->
<div class="modal fade" id="createTpsModal" tabindex="-1" aria-labelledby="createTpsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createTpsModalLabel">Create New TPS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.tps.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="kelurahan_election_id" class="form-label">Kelurahan Election</label>
            <select class="form-select" id="kelurahan_election_id" name="kelurahan_election_id" required>
              <option value="">Pilih Kelurahan Election</option>
              @foreach($kelurahanElections as $kelurahanElection)
                <option value="{{ $kelurahanElection->id }}">{{ $kelurahanElection->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Nama TPS</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="user_id" class="form-label">Penanggung Jawab</label>
            <select class="form-select" id="user_id" name="user_id" required>
              <option value="">Pilih Penanggung Jawab</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- / Modal Create TPS -->

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