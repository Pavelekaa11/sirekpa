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

        $userPref = [
            'keindahan' => $request->keindahan,
            'aksesibilitas' => $request->aksesibilitas,
            'fasilitas' => $request->fasilitas,
            'aktivitas' => $request->aktivitas,
            'harga' => $request->harga_tiket_max,
        ];

        // Bobot untuk setiap atribut
        $bobot = [
            'keindahan' => 0.23,
            'aksesibilitas' => 0.17,
            'fasilitas' => 0.18,
            'aktivitas' => 0.15,
            'harga' => 0.27,
        ];

        // Threshold minimum untuk rekomendasi
        $thresholdMinimum = 0.7; // 70% kecocokan minimum

        $pantai = Pantai::all()->map(function ($item) use ($userPref, $bobot, $thresholdMinimum) {
            // Hitung skor similarity untuk setiap atribut
            $skorKeindahan = $this->hitungSkorAtribut($item->keindahan, $userPref['keindahan']);
            $skorAksesibilitas = $this->hitungSkorAtribut($item->aksesibilitas, $userPref['aksesibilitas']);
            $skorFasilitas = $this->hitungSkorAtribut($item->fasilitas, $userPref['fasilitas']);
            $skorAktivitas = $this->hitungSkorAtribut($item->aktivitas, $userPref['aktivitas']);
            $skorHarga = $this->hitungSkorHarga($item->harga_tiket, $userPref['harga']);

            // Hitung total skor dengan bobot
            $totalSkor = ($skorKeindahan * $bobot['keindahan']) +
                        ($skorAksesibilitas * $bobot['aksesibilitas']) +
                        ($skorFasilitas * $bobot['fasilitas']) +
                        ($skorAktivitas * $bobot['aktivitas']) +
                        ($skorHarga * $bobot['harga']);

            $item->skor = round($totalSkor, 6);
            $item->kategori_rekomendasi = $this->tentukanKategoriRekomendasi($totalSkor);
            $item->layak_direkomendasikan = $this->cekKelayakanRekomendasi($item, $userPref, $thresholdMinimum);

            return $item;
        })
        ->filter(function ($item) {
            // Hanya tampilkan pantai yang layak direkomendasikan
            return $item->layak_direkomendasikan;
        })
        ->sortByDesc('skor')
        ->values();

        return view('hasil', compact('pantai'));
    }

    /**
     * Hitung skor similarity untuk atribut non-harga (skala 1-5)
     */
    private function hitungSkorAtribut($nilaiPantai, $nilaiUser)
    {
        $selisih = abs($nilaiPantai - $nilaiUser);
        
        // Knowledge base rules untuk atribut
        if ($selisih == 0) {
            return 1.0; // Cocok sempurna
        } elseif ($selisih == 1) {
            return 0.8; // Sangat cocok
        } elseif ($selisih == 2) {
            return 0.6; // Cukup cocok
        } elseif ($selisih == 3) {
            return 0.4; // Kurang cocok
        } else {
            return 0.2; // Tidak cocok
        }
    }

    /**
     * Hitung skor similarity untuk harga
     */
    private function hitungSkorHarga($hargaPantai, $budgetUser)
    {
        // Jika harga pantai melebihi budget user
        if ($hargaPantai > $budgetUser) {
            $selisih = $hargaPantai - $budgetUser;
            $persentaseKelebihan = $selisih / $budgetUser;
            
            if ($persentaseKelebihan > 0.5) {
                return 0.0; // Sangat tidak cocok jika lebih dari 50% budget
            } elseif ($persentaseKelebihan > 0.3) {
                return 0.3; // Kurang cocok
            } elseif ($persentaseKelebihan > 0.1) {
                return 0.6; // Cukup cocok
            } else {
                return 0.8; // Masih bisa diterima
            }
        } else {
            // Jika harga pantai dalam budget
            $selisih = $budgetUser - $hargaPantai;
            $persentasePenghematan = $selisih / $budgetUser;
            
            if ($persentasePenghematan > 0.7) {
                return 0.9; // Sangat hemat
            } elseif ($persentasePenghematan > 0.5) {
                return 1.0; // Hemat dan cocok
            } elseif ($persentasePenghematan > 0.3) {
                return 0.95; // Cocok
            } else {
                return 0.85; // Sesuai budget
            }
        }
    }

    /**
     * Tentukan kategori rekomendasi berdasarkan skor
     */
    private function tentukanKategoriRekomendasi($skor)
    {
        if ($skor >= 0.9) {
            return 'Sangat Direkomendasikan';
        } elseif ($skor >= 0.8) {
            return 'Direkomendasikan';
        } elseif ($skor >= 0.7) {
            return 'Cukup Direkomendasikan';
        } elseif ($skor >= 0.6) {
            return 'Kurang Direkomendasikan';
        } else {
            return 'Tidak Direkomendasikan';
        }
    }

    /**
     * Cek kelayakan rekomendasi dengan aturan knowledge base
     */
    private function cekKelayakanRekomendasi($pantai, $userPref, $thresholdMinimum)
    {
        // Aturan 1: Harga tidak boleh melebihi budget terlalu jauh
        if ($pantai->harga_tiket > $userPref['harga'] * 1.2) {
            return false;
        }

        // Aturan 2: Minimal skor keseluruhan harus di atas threshold
        if ($pantai->skor < $thresholdMinimum) {
            return false;
        }

        // Aturan 3: Tidak ada atribut yang terlalu jauh dari preferensi
        $selisihKeindahan = abs($pantai->keindahan - $userPref['keindahan']);
        $selisihAksesibilitas = abs($pantai->aksesibilitas - $userPref['aksesibilitas']);
        $selisihFasilitas = abs($pantai->fasilitas - $userPref['fasilitas']);
        $selisihAktivitas = abs($pantai->aktivitas - $userPref['aktivitas']);

        // Jika ada atribut yang selisihnya lebih dari 3 poin, tidak direkomendasikan
        if ($selisihKeindahan > 3 || $selisihAksesibilitas > 3 || 
            $selisihFasilitas > 3 || $selisihAktivitas > 3) {
            return false;
        }

        // Aturan 4: Prioritas khusus untuk atribut penting
        // Jika user menginginkan keindahan tinggi (4-5), pantai harus minimal 3
        if ($userPref['keindahan'] >= 4 && $pantai->keindahan < 3) {
            return false;
        }

        // Jika user menginginkan aksesibilitas tinggi (4-5), pantai harus minimal 3
        if ($userPref['aksesibilitas'] >= 4 && $pantai->aksesibilitas < 3) {
            return false;
        }

        // Aturan 5: Kombinasi atribut harus seimbang
        $rataRataAtribut = ($pantai->keindahan + $pantai->aksesibilitas + 
                          $pantai->fasilitas + $pantai->aktivitas) / 4;
        
        if ($rataRataAtribut < 2.5) {
            return false; // Pantai dengan rata-rata atribut terlalu rendah
        }

        return true;
    }
}