<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{

    // testing -6.232391, 106.685865
    const SCHOOL_LAT = -6.232391;
    const SCHOOL_LNG = 106.685865;

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

        $distance = $this->haversine(
            self::SCHOOL_LAT, self::SCHOOL_LNG,
            $request->latitude, $request->longitude
        );

        if ($distance > 50) {
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

    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}