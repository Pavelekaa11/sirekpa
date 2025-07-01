@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Back Button -->
    <div>
        <a href="{{ route('beranda') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-xl hover:bg-white/30 transition-all duration-300 border border-white/30">
            <span>←</span>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white/95 backdrop-blur-sm rounded-3xl overflow-hidden shadow-2xl border border-white/30">
        
        <!-- Hero Image -->
        <div class="relative h-80 md:h-96 overflow-hidden">
            <img src="{{ asset('images/' . $pantai->gambar) }}" 
                 alt="{{ $pantai->nama }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
            
            <!-- Title Overlay -->
            <div class="absolute bottom-0 left-0 right-0 p-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 drop-shadow-lg">
                    {{ $pantai->nama }}
                </h1>
                <p class="text-xl text-blue-100 flex items-center gap-2">
                    <span>📍</span>
                    {{ $pantai->lokasi }}
                </p>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8 space-y-8">
            
            <!-- Description -->
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-100">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                    <span class="text-3xl">📖</span>
                    Tentang Pantai
                </h2>
                <p class="text-gray-700 leading-relaxed text-lg">{{ $pantai->deskripsi }}</p>
            </div>

            <!-- Rating Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                $ratings = [
                    'keindahan' => ['icon' => '🌅', 'label' => 'Keindahan', 'color' => 'from-pink-500 to-rose-500'],
                    'aksesibilitas' => ['icon' => '🚗', 'label' => 'Aksesibilitas', 'color' => 'from-green-500 to-emerald-500'],
                    'fasilitas' => ['icon' => '🏖️', 'label' => 'Fasilitas', 'color' => 'from-blue-500 to-cyan-500'],
                    'aktivitas' => ['icon' => '🏄‍♂️', 'label' => 'Aktivitas', 'color' => 'from-purple-500 to-indigo-500']
                ];
                @endphp

                @foreach ($ratings as $key => $rating)
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 text-center group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-4xl mb-3">{{ $rating['icon'] }}</div>
                        <h3 class="font-bold text-gray-800 text-lg mb-3">{{ $rating['label'] }}</h3>
                        
                        <!-- Star Rating -->
                        <div class="flex justify-center gap-1 mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="text-2xl {{ $i <= $pantai->$key ? 'text-yellow-400' : 'text-gray-300' }}">
                                    ⭐
                                </span>
                            @endfor
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                            <div class="bg-gradient-to-r {{ $rating['color'] }} h-3 rounded-full transition-all duration-500" 
                                 style="width: {{ ($pantai->$key / 5) * 100 }}%"></div>
                        </div>
                        
                        <div class="text-2xl font-bold bg-gradient-to-r {{ $rating['color'] }} bg-clip-text text-transparent">
                            {{ $pantai->$key }}/5
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Price Section -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl p-8 text-white text-center shadow-xl">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <span class="text-5xl">💰</span>
                    <div>
                        <h2 class="text-3xl font-bold">Harga Tiket Masuk</h2>
                        <p class="text-emerald-100">Per orang</p>
                    </div>
                </div>
                
                <div class="text-5xl font-bold mb-4">
                    Rp {{ number_format($pantai->harga_tiket, 0, ',', '.') }}
                </div>
                
                @if($pantai->harga_tiket == 0)
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-400 text-yellow-900 rounded-full font-bold text-lg">
                        <span>🎉</span>
                        <span>GRATIS!</span>
                    </div>
                @elseif($pantai->harga_tiket < 20000)
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-green-400 text-green-900 rounded-full font-bold">
                        <span>💚</span>
                        <span>Harga Terjangkau</span>
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-blue-400 text-blue-900 rounded-full font-bold">
                        <span>⭐</span>
                        <span>Premium Experience</span>
                    </div>
                @endif
            </div>

            <!-- Overall Rating -->
            <div class="text-center bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-8 border border-indigo-100">
                @php
                $overallRating = ($pantai->keindahan + $pantai->aksesibilitas + $pantai->fasilitas + $pantai->aktivitas) / 4;
                @endphp
                
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Rating Keseluruhan</h2>
                <div class="text-6xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-4">
                    {{ number_format($overallRating, 1) }}/5.0
                </div>
                
                <div class="flex justify-center gap-1 mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-3xl {{ $i <= round($overallRating) ? 'text-yellow-400' : 'text-gray-300' }}">
                            ⭐
                        </span>
                    @endfor
                </div>
                
                <p class="text-gray-600 text-lg">
                    @if($overallRating >= 4.5)
                        🏆 Pantai Luar Biasa!
                    @elseif($overallRating >= 4.0)
                        ⭐ Pantai Sangat Baik
                    @elseif($overallRating >= 3.5)
                        👍 Pantai Baik
                    @elseif($overallRating >= 3.0)
                        😊 Pantai Cukup Baik
                    @else
                        📝 Perlu Peningkatan
                    @endif
                </p>
            </div>

        </div>
    </div>

    <!-- Decorative Element -->
    <div class="text-center">
        <div class="inline-flex items-center gap-2 text-6xl opacity-30">
            <span class="animate-pulse">🌊</span>
            <span class="animate-bounce" style="animation-delay: 0.5s">🏖️</span>
            <span class="animate-pulse" style="animation-delay: 1s">🌊</span>
        </div>
    </div>
</div>
@endsection