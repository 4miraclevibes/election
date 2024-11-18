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
            <th class="text-white">Total Memilih</th>
            <th class="text-white">Total Pemilih</th>
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
            <td>{{ $tps->participantElection->count() }} / {{ $tps->tpsParticipant->count() ?? 0 }}</td>
            <td>{{ $tps->total_invitation }}</td>
            <td>
              <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailTpsModal{{ $tps->id }}">
                Detail
              </button>
            </td>
            <td>{{ $tps->kelurahanElection->name }}</td>
            <td>{{ $tps->kelurahanElection->kecamatanElection->name }}</td>
            <td>
              <a href="{{ route('dashboard.tps.show', $tps->id) }}" class="btn btn-info btn-sm">Show</a>
              <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadCsvModal{{ $tps->id }}">
                Upload CSV
              </button>
              <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadCsvParticipantModal{{ $tps->id }}">
                Upload CSV Peserta
              </button>
              <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPesertaModal{{ $tps->id }}">
                Tambah Peserta
              </button>
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
            <label for="total_invitation" class="form-label">Jumlah Pemilih</label>
            <input type="number" class="form-control" id="total_invitation" name="total_invitation" required>
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

<!-- Modal Detail TPS -->
@foreach ($tpsElections as $tps)
<div class="modal fade" id="detailTpsModal{{ $tps->id }}" tabindex="-1" aria-labelledby="detailTpsModalLabel{{ $tps->id }}" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailTpsModalLabel{{ $tps->id }}">Detail TPS: {{ $tps->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6>Informasi TPS</h6>
        <p><strong>Nama:</strong> {{ $tps->name }}</p>
        <p><strong>PJ TPS:</strong> {{ $tps->user->name }}</p>
        <p><strong>Email:</strong> {{ $tps->user->email }}</p>
        <p><strong>Kelurahan:</strong> {{ $tps->kelurahanElection->name }}</p>
        <p><strong>Kecamatan:</strong> {{ $tps->kelurahanElection->kecamatanElection->name }}</p>
        <p><strong>Total Undangan:</strong> {{ $tps->total_invitation }}</p>

        <h6 class="mt-4">Daftar Penanggung Jawab</h6>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Dukungan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($tps->tpsElectionDetails as $detail)
            <tr>
              <td>{{ $detail->user->name }}</td>
              <td>{{ $detail->user->email }}</td>
              <td>{{ $detail->participantElection->count() }} / {{ $detail->tpsElection->tpsParticipant->count() ?? 0 }}</td>
              <td>
                <form action="{{ route('dashboard.tps.destroyDetail', $detail->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Hapus</button>
                </form>
              </td>
            </tr>
            @endforeach
            <tr>
              <td colspan="2"><strong>Total Dukungan</strong></td>
              <td>
                {{ $tps->tpsElectionDetails->sum(function($detail) {
                  return $detail->participantElection->count();
                }) }} / {{ $tps->tpsParticipant->count() ?? 0 }}
              </td>
            </tr>
          </tbody>
        </table>

        <h6 class="mt-4">Tambah Tim TPS</h6>
        <form action="{{ route('dashboard.tps.storeDetail') }}" method="POST">
          @csrf
          <input type="hidden" name="tps_election_id" value="{{ $tps->id }}">
          <div class="mb-3">
            <label for="user_id" class="form-label">Pilih Tim TPS</label>
            <select class="form-select" id="user_id" name="user_id" required>
              <option value="">Pilih Tim TPS</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Tambah Tim TPS</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endforeach

<!-- Modal Upload CSV -->
@foreach ($tpsElections as $tps)
<div class="modal fade" id="uploadCsvModal{{ $tps->id }}" tabindex="-1" aria-labelledby="uploadCsvModalLabel{{ $tps->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadCsvModalLabel{{ $tps->id }}">Unggah CSV Peserta untuk TPS: {{ $tps->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.tps.uploadCsv', $tps->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="csv_file" class="form-label">Pilih file CSV</label>
            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
          </div>
          <div class="mb-3">
            <p>Format CSV yang diharapkan:</p>
            <pre>
              name,address,sex,age
            </pre>
            <p>Catatan: Pastikan data dalam CSV sesuai dengan format di atas.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Unggah CSV</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- Modal Upload CSV Peserta -->
@foreach ($tpsElections as $tps)
<div class="modal fade" id="uploadCsvParticipantModal{{ $tps->id }}" tabindex="-1" aria-labelledby="uploadCsvParticipantModalLabel{{ $tps->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadCsvParticipantModalLabel{{ $tps->id }}">Unggah CSV Peserta Pemilih untuk TPS: {{ $tps->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.tps.participantUploadCsv', $tps->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <h6>Relawan</h6>
          <div class="mb-3">
            <label for="tps_election_detail_id" class="form-label">Pilih Relawan</label>
            <select class="form-select" name="tps_election_detail_id" id="tps_election_detail_id" required>
              <option value="">Pilih Relawan</option>
              @foreach($tps->tpsElectionDetails as $detail)
                <option value="{{ $detail->id }}">{{ $detail->user->name }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="mb-3">
            <label for="csv_file_participant" class="form-label">Pilih file CSV</label>
            <input type="file" class="form-control" id="csv_file_participant" name="csv_file_participant" accept=".csv" required>
          </div>
          <div class="mb-3">
            <p>Format CSV yang diharapkan:</p>
            <pre>
              name,address,phone
            </pre>
            <p>Catatan: Pastikan data dalam CSV sesuai dengan format di atas.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Unggah CSV</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- Modal Tambah Peserta -->
@foreach ($tpsElections as $tps)
<div class="modal fade" id="tambahPesertaModal{{ $tps->id }}" tabindex="-1" aria-labelledby="tambahPesertaModalLabel{{ $tps->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahPesertaModalLabel{{ $tps->id }}">Tambah Peserta untuk TPS: {{ $tps->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.tps.storeParticipant', $tps->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nama Peserta</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Alamat Peserta</label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>
          <div class="mb-3">
            <label for="sex" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="sex" name="sex" required>
              <option value="">Pilih Jenis Kelamin</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="age" class="form-label">Usia Peserta</label>
            <input type="number" class="form-control" id="age" name="age" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Tambah Peserta</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

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
