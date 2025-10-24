@extends('layouts.app')

@section('content')
<div class="text-center bg-primary text-white p-5">
    <h1 class="display-4">Sistem Pengaduan Sarpras</h1>
    <p class="lead">Laporkan masalah sarana prasarana dengan mudah!</p>
    <div class="mt-4">
        <a href="{{ route('login') }}" class="btn btn-light btn-lg m-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg m-2">Register</a>
    </div>
</div>
<div class="p-4 text-center">
    <p>&copy; 2025 Sekolah Menengah Kejuruan</p>
</div>
@endsection
