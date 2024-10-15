@extends('layouts.dashboard.main')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" />
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="mb-4">Selamat datang {{ Auth::user()->name }}</h1>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Laporan Kecamatan</h5>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Kecamatan</th>
                                <th>Total Memilih</th>
                                <th>Total Pemilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_memilih = 0;
                                $total_pemilih = 0;
                            @endphp
                            @foreach($kecamatanData as $kecamatan)
                                @php
                                    $total_memilih += $kecamatan->total_memilih;
                                    $total_pemilih += $kecamatan->total_pemilih;
                                @endphp
                                <tr>
                                    <td>{{ $kecamatan->name }}</td>
                                    <td>{{ $kecamatan->total_memilih }}</td>
                                    <td>{{ $kecamatan->total_pemilih }}</td>
                                </tr>
                            @endforeach
                            <tr style="font-weight: bold; !important">
                                <td colspan="1" style="font-weight: bold;">Total</td>
                                <td>{{ $total_memilih }}</td>
                                <td>{{ $total_pemilih }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Laporan Kelurahan</h5>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>Total Memilih</th>
                                <th>Total Pemilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_memilih = 0;
                                $total_pemilih = 0;
                            @endphp
                            @foreach($kecamatanData as $kecamatan)
                                @foreach($kecamatan->kelurahanElection as $kelurahan)
                                    @php
                                        $total_memilih += $kelurahan->total_memilih;
                                        $total_pemilih += $kelurahan->total_pemilih;
                                    @endphp
                                    <tr>
                                        <td>{{ $kecamatan->name }}</td>
                                        <td>{{ $kelurahan->name }}</td>
                                        <td>{{ $kelurahan->total_memilih }}</td>
                                        <td>{{ $kelurahan->total_pemilih }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr style="font-weight: bold; !important">
                                <td colspan="1" style="font-weight: bold;">Total</td>
                                <td></td>
                                <td>{{ $total_memilih }}</td>
                                <td>{{ $total_pemilih }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Laporan TPS</h5>
                </div>
                <div class="card-body">
                    <table id="example3" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>TPS</th>
                                <th>Total Memilih</th>
                                <th>Total Pemilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kecamatanData as $kecamatan)
                                @foreach($kecamatan->kelurahanElection as $kelurahan)
                                    @foreach($kelurahan->tpsElection as $tps)
                                        <tr>
                                            <td>{{ $kecamatan->name }}</td>
                                            <td>{{ $kelurahan->name }}</td>
                                            <td>{{ $tps->name }}</td>
                                            <td>{{ $tps->total_memilih }}</td>
                                            <td>{{ $tps->total_invitation }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
        $('#example2').DataTable({
            layout: {
                topStart: {
                    buttons: ['excelHtml5', 'csvHtml5', 'pdfHtml5']
                }
            }
        });
        $('#example3').DataTable({
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
