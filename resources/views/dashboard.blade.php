@extends('layouts.dashboard.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="mb-4">Selamat datang {{ Auth::user()->name }}</h1>
</div>
@endsection
