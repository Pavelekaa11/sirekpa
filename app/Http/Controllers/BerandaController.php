<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pantai;

class BerandaController extends Controller
{
    public function index()
    {
    $pantaiPopuler = Pantai::orderBy('keindahan', 'desc')
                           ->take(5)
                           ->get();
    
    $semuaPantai = Pantai::orderBy('nama', 'asc')->get();
    
    return view('index', compact('pantaiPopuler', 'semuaPantai'));
    }

    public function cari(Request $request)
    {
        $request->validate(['q' => 'required|string']);
        $pantai = Pantai::where('nama', 'like', '%' . $request->q . '%')->get();

        return view('hasil', compact('pantai'));
    }
}
