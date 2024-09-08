@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createTpsModal">
        Create Kelurahan
      </button>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Table Kelurahan</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Name</th>
            <th class="text-white">Email</th>
            <th class="text-white">PJ</th>
            <th class="text-white">Kecamatan</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kelurahanElections as $kelurahan)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $kelurahan->name }}</td>
            <td>{{ $kelurahan->user->email }}</td>
            <td>{{ $kelurahan->user->name }}</td>
            <td>{{ $kelurahan->kecamatanElection->name }}</td>
              <td>
                <form action="{{ route('dashboard.kelurahan.destroy', $kelurahan->id) }}" method="POST" style="display:inline-block;">
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
        <h5 class="modal-title" id="createTpsModalLabel">Create New Kelurahan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.kelurahan.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="kecamatan_election_id" class="form-label">Kecamatan Election</label>
            <select class="form-select" id="kecamatan_election_id" name="kecamatan_election_id" required>
              <option value="">Pilih Kecamatan Election</option>
              @foreach($kecamatanElections as $kecamatanElection)
                <option value="{{ $kecamatanElection->id }}">{{ $kecamatanElection->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Nama Kelurahan</label>
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