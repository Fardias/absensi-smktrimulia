@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Absensi Siswa</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 rounded mb-3">
    {{ $errors->first() }}
</div>
@endif

@if (session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-3">
    {{ session('success') }}
</div>
@endif

<form id="absensiForm" method="POST" action="{{ route('absensi.store') }}">
    @csrf
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
        Absen Sekarang
    </button>
</form>

<script>
document.getElementById('absensiForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((pos) => {
            document.getElementById('latitude').value = pos.coords.latitude;
            document.getElementById('longitude').value = pos.coords.longitude;
            e.target.submit();
        }, () => {
            alert("Lokasi tidak bisa didapatkan.");
        });
    } else {
        alert("Browser tidak mendukung geolocation.");
    }
});
</script>
@endsection