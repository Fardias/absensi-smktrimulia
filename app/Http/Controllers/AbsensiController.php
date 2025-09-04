<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\Geo;
use Illuminate\Support\Facades\Config;

class AbsensiController extends Controller
{

    // Lokasi diambil dari config/school.php

    public function index()
    {
        return view('siswa.absensi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $schoolLat = (float) Config::get('school.lat');
        $schoolLng = (float) Config::get('school.lng');
        $maxRadius = (float) Config::get('school.max_radius_meters');

        // Cegah lebih dari sekali absen per hari
        $already = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', now()->toDateString())
            ->exists();
        if ($already) {
            return back()->withErrors(['msg' => 'Anda sudah absen hari ini.']);
        }

        $distance = Geo::distanceInMeters($schoolLat, $schoolLng, (float) $request->latitude, (float) $request->longitude);

        if ($distance > $maxRadius) {
            return back()->withErrors(['msg' => 'Anda harus berada dalam radius 50 meter untuk absen.']);
        }

        Absensi::create([
            'user_id' => auth()->id(),
            'tanggal' => now()->toDateString(),
            'jam' => now()->toTimeString(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return back()->with('success', 'Absensi berhasil.');
    }

}