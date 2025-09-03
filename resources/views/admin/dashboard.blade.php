@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Dashboard Admin</h1>
<table class="w-full border">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-2 border">Nama</th>
            <th class="p-2 border">Tanggal</th>
            <th class="p-2 border">Jam</th>
            <th class="p-2 border">Latitude</th>
            <th class="p-2 border">Longitude</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($absensi as $a)
        <tr>
            <td class="p-2 border">{{ $a->user->name }}</td>
            <td class="p-2 border">{{ $a->tanggal }}</td>
            <td class="p-2 border">{{ $a->jam }}</td>
            <td class="p-2 border">{{ $a->latitude }}</td>
            <td class="p-2 border">{{ $a->longitude }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection