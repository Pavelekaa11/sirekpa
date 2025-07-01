<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pantai;

class BerandaController extends Controller
{
    public function index()
    {
        // tampilkan 3-5 pantai dengan rating keindahan tertinggi
        $pantaiPopuler = Pantai::orderByDesc('keindahan')->limit(5)->get();

        return view('index', compact('pantaiPopuler'));
    }

    public function cari(Request $request)
    {
        $request->validate(['q' => 'required|string']);
        $pantai = Pantai::where('nama', 'like', '%' . $request->q . '%')->get();

        return view('hasil', compact('pantai'));
    }
}
