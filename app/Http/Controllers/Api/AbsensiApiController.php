<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsensiResource;
use App\Http\Resources\AbsensiCollection;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\Geo;
use Illuminate\Support\Facades\Config;

class AbsensiApiController extends Controller
{
    // Lokasi diambil dari config/school.php

    public function index(Request $request)
    {
        $user = $request->user();
        $data = Absensi::where('user_id', $user->id)->latest()->get();
        return response()->json([
            'message' => 'Data absensi berhasil diambil',
            'data' => new AbsensiCollection($data)
        ]);
    }

    public function adminIndex()
    {
        $data = Absensi::with('user')->latest()->get();
        return response()->json([
            'message' => 'Data absensi semua siswa berhasil diambil',
            'data' => new AbsensiCollection($data)
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $schoolLat = (float) Config::get('school.lat');
        $schoolLng = (float) Config::get('school.lng');
        $maxRadius = (float) Config::get('school.max_radius_meters');

        // Cegah lebih dari sekali absen per hari per user
        $already = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', now()->toDateString())
            ->exists();
        if ($already) {
            return response()->json(['message' => 'Anda sudah absen hari ini.'], 422);
        }

        $distance = Geo::distanceInMeters($schoolLat, $schoolLng, (float) $validated['latitude'], (float) $validated['longitude']);
        if ($distance > $maxRadius) {
            return response()->json(['message' => 'Anda harus berada dalam radius 50 meter untuk absen.'], 422);
        }

        $absen = Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => now()->toDateString(),
            'jam' => now()->toTimeString(),
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return response()->json([
            'message' => 'Absensi berhasil.',
            'data' => new AbsensiResource($absen)
        ], 201);
    }

}