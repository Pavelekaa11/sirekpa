@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="text-center py-6">
        <h1 class="text-3xl font-bold text-white mb-3">🎯 Masukkan Preferensi Wisata Anda</h1>
        <p class="text-blue-100 text-lg">Bantu kami menemukan pantai yang sempurna untuk Anda</p>
    </div>

    <!-- Form Container -->
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-8 shadow-2xl border border-white/30">
        <form action="{{ route('hasil') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Criteria Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                $criteriaInfo = [
                    'keindahan' => ['icon' => '🌅', 'desc' => 'Pemandangan dan keindahan alam'],
                    'aksesibilitas' => ['icon' => '🚗', 'desc' => 'Kemudahan akses dan transportasi'],
                    'fasilitas' => ['icon' => '🏖️', 'desc' => 'Kelengkapan fasilitas pantai'],
                    'aktivitas' => ['icon' => '🏄‍♂️', 'desc' => 'Variasi aktivitas yang tersedia']
                ];
                @endphp

                @foreach ($criteriaInfo as $kriteria => $info)
                    <div class="group">
                        <label class="flex items-center gap-3 text-lg font-semibold text-gray-800 mb-3">
                            <span class="text-2xl">{{ $info['icon'] }}</span>
                            <div>
                                <span class="capitalize">{{ $kriteria }}</span>
                                <p class="text-sm font-normal text-gray-600">{{ $info['desc'] }}</p>
                            </div>
                        </label>
                        
                        <div class="relative">
                            <input type="range" name="{{ $kriteria }}" min="1" max="5" value="3" required 
                                   class="w-full h-3 bg-gradient-to-r from-blue-200 to-cyan-200 rounded-lg appearance-none cursor-pointer slider"
                                   oninput="updateValue('{{ $kriteria }}', this.value)">
                            <div class="flex justify-between text-xs text-gray-500 mt-2">
                                <span>1 - Tidak Penting</span>
                                <span>3 - Cukup</span>
                                <span>5 - Sangat Penting</span>
                            </div>
                            <div class="text-center mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                    Nilai: <span id="{{ $kriteria }}_value" class="ml-1">3</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Price Section -->
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6 border border-blue-100">
                <label class="flex items-center gap-3 text-lg font-semibold text-gray-800 mb-4">
                    <span class="text-2xl">💰</span>
                    <div>
                        <span>Budget Maksimum</span>
                        <p class="text-sm font-normal text-gray-600">Harga tiket masuk yang bersedia Anda bayar</p>
                    </div>
                </label>
                
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                    <input type="number" name="harga_tiket_max" min="0" placeholder="50000" required 
                           class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-blue-200 focus:border-blue-400 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 text-lg font-semibold">
                </div>
                <p class="text-sm text-gray-500 mt-2">💡 Contoh: 50000 untuk budget Rp 50.000</p>
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-4">
                <button type="submit" 
                        class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 text-white text-lg font-bold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                    <span class="text-2xl group-hover:animate-bounce">🔍</span>
                    <span>Lihat Rekomendasi Pantai</span>
                    <span class="group-hover:translate-x-2 transition-transform duration-300">→</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateValue(criteriaName, value) {
    document.getElementById(criteriaName + '_value').textContent = value;
}

// Style the range sliders
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.slider');
    sliders.forEach(slider => {
        slider.addEventListener('input', function() {
            const value = (this.value - this.min) / (this.max - this.min) * 100;
            this.style.background = `linear-gradient(to right, #3b82f6 0%, #06b6d4 ${value}%, #e2e8f0 ${value}%, #e2e8f0 100%)`;
        });
        
        // Initialize
        const value = (slider.value - slider.min) / (slider.max - slider.min) * 100;
        slider.style.background = `linear-gradient(to right, #3b82f6 0%, #06b6d4 ${value}%, #e2e8f0 ${value}%, #e2e8f0 100%)`;
    });
});
</script>

<style>
.slider::-webkit-slider-thumb {
    appearance: none;
    height: 24px;
    width: 24px;
    border-radius: 50%;
    background: linear-gradient(45deg, #3b82f6, #06b6d4);
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    border: 3px solid white;
}

.slider::-moz-range-thumb {
    height: 24px;
    width: 24px;
    border-radius: 50%;
    background: linear-gradient(45deg, #3b82f6, #06b6d4);
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    border: 3px solid white;
}
</style>
@endsection