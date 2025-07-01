<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pantai;

class RekomendasiController extends Controller
{
    public function form()
    {
        return view('form');
    }

    public function hasil(Request $request)
    {
        $request->validate([
            'keindahan' => 'required|numeric|min:1|max:5',
            'aksesibilitas' => 'required|numeric|min:1|max:5',
            'fasilitas' => 'required|numeric|min:1|max:5',
            'aktivitas' => 'required|numeric|min:1|max:5',
            'harga_tiket_max' => 'required|numeric|min:0',
        ]);

        $pantai = Pantai::where('harga_tiket', '<=', $request->harga_tiket_max)
            ->get()
            ->map(function ($item) use ($request) {
                $skor = abs($item->keindahan - $request->keindahan)
                      + abs($item->aksesibilitas - $request->aksesibilitas)
                      + abs($item->fasilitas - $request->fasilitas)
                      + abs($item->aktivitas - $request->aktivitas);

                $item->skor = $skor;
                return $item;
            })
            ->sortBy('skor')
            ->values();

        return view('hasil', compact('pantai'));
    }
}
