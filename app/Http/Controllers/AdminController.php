<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $absensi = Absensi::with('user')->latest()->get();
        return view('admin.dashboard', compact('absensi'));
    }
}