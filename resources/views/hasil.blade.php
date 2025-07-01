@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="text-center py-6">
        <h1 class="text-3xl font-bold text-white mb-3">🔍 Hasil Pencarian</h1>
        <p class="text-blue-100 text-lg">Pantai-pantai yang sesuai dengan preferensi Anda</p>
    </div>

    <!-- Results Content -->
    @if ($pantai->count())
        <!-- Results Count -->
        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 border border-white/30">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📊</span>
                    <span class="text-white font-semibold">
                        Ditemukan {{ $pantai->count() }} pantai yang cocok untuk Anda
                    </span>
                </div>
                <a href="{{ route('beranda') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-xl hover:bg-white/30 transition-all duration-300 border border-white/30">
                    <span>🏠</span>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        <!-- Results Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pantai as $index => $p)
                <div class="group bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-white/20 relative">
                    
                    <!-- Ranking Badge -->
                    <div class="absolute top-4 left-4 z-10">
                        <div class="flex items-center gap-2 px-3 py-1 rounded-full font-bold text-sm shadow-lg
                            {{ $index == 0 ? 'bg-gradient-to-r from-yellow-400 to-yellow-500 text-yellow-900' : 
                               ($index == 1 ? 'bg-gradient-to-r from-gray-300 to-gray-400 text-gray-800' : 
                                ($index == 2 ? 'bg-gradient-to-r from-amber-600 to-amber-700 text-amber-100' : 
                                 'bg-gradient-to-r from-blue-500 to-blue-600 text-white')) }}">
                            <span>
                                {{ $index == 0 ? '🥇' : ($index == 1 ? '🥈' : ($index == 2 ? '🥉' : '#' . ($index + 1))) }}
                            </span>
                            <span>{{ $index == 0 ? 'TERBAIK' : ($index == 1 ? 'RUNNER UP' : ($index == 2 ? 'TOP 3' : 'REKOMENDASI')) }}</span>
                        </div>
                    </div>

                    <!-- Image with Overlay -->
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/' . $p->gambar) }}" 
                             alt="{{ $p->nama }}" 
                             class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Quick Stats Overlay -->
                        <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            @php
                            $overallRating = ($p->keindahan + $p->aksesibilitas + $p->fasilitas + $p->aktivitas) / 4;
                            @endphp
                            <div class="bg-black/70 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-semibold">
                                ⭐ {{ number_format($overallRating, 1) }}/5
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300 mb-2">
                                {{ $p->nama }}
                            </h3>
                            <p class="text-gray-600 flex items-center gap-2 mb-3">
                                <span>📍</span>
                                {{ $p->lokasi }}
                            </p>
                        </div>

                        <!-- Quick Rating Preview -->
                        <div class="grid grid-cols-4 gap-2 mb-4">
                            @php
                            $quickRatings = [
                                ['icon' => '🌅', 'value' => $p->keindahan],
                                ['icon' => '🚗', 'value' => $p->aksesibilitas],
                                ['icon' => '🏖️', 'value' => $p->fasilitas],
                                ['icon' => '🏄‍♂️', 'value' => $p->aktivitas]
                            ];
                            @endphp
                            
                            @foreach ($quickRatings as $rating)
                                <div class="text-center">
                                    <div class="text-lg mb-1">{{ $rating['icon'] }}</div>
                                    <div class="text-xs font-bold text-gray-600">{{ $rating['value'] }}/5</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price and CTA -->
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div class="text-sm">
                                <span class="text-gray-500">Tiket:</span>
                                <span class="font-bold text-emerald-600">
                                    {{ $p->harga_tiket == 0 ? 'GRATIS!' : 'Rp ' . number_format($p->harga_tiket, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('show', $p->id) }}" 
                           class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform group-hover:-translate-y-1 mt-4">
                            <span>Lihat Detail</span>
                            <span class="group-hover:translate-x-1 transition-transform duration-300">→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Additional Search Options -->
        <div class="bg-gradient-to-r from-blue-50/20 to-cyan-50/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center">
            <h3 class="text-xl font-bold text-white mb-4">🔄 Tidak menemukan yang cocok?</h3>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('form') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span>🎯</span>
                    <span>Coba Pencarian Lain</span>
                </a>
                <a href="{{ route('beranda') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span>🏠</span>
                    <span>Lihat Semua Pantai</span>
                </a>
            </div>
        </div>

    @else
        <!-- No Results -->
        <div class="text-center py-16">
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-12 shadow-xl border border-white/30 max-w-md mx-auto">
                <div class="text-8xl mb-6">🔍</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Oops! Tidak Ada Hasil</h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Maaf, tidak ada pantai yang sesuai dengan kriteria pencarian Anda. 
                    Coba ubah filter atau kata kunci pencarian.
                </p>
                
                <div class="space-y-4">
                    <a href="{{ route('form') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <span>🎯</span>
                        <span>Ubah Kriteria Pencarian</span>
                    </a>
                    
                    <div class="text-gray-400">atau</div>
                    
                    <a href="{{ route('beranda') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <span>🏠</span>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Tips -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span>💡</span>
                Tips Pencarian
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                <div class="flex items-start gap-2">
                    <span>🔍</span>
                    <div>
                        <strong>Kata Kunci:</strong> Coba gunakan nama pantai yang lebih umum
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <span>⚖️</span>
                    <div>
                        <strong>Kriteria:</strong> Turunkan standar pada beberapa kriteria
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <span>💰</span>
                    <div>
                        <strong>Budget:</strong> Naikkan budget maksimum tiket masuk
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Decorative Wave -->
    <div class="text-center pt-8">
        <div class="inline-flex items-center gap-4 text-6xl opacity-30">
            <span class="animate-pulse">🌊</span>
            <span class="animate-bounce" style="animation-delay: 0.3s">🏖️</span>
            <span class="animate-pulse" style="animation-delay: 0.6s">🌴</span>
            <span class="animate-bounce" style="animation-delay: 0.9s">🏖️</span>
            <span class="animate-pulse" style="animation-delay: 1.2s">🌊</span>
        </div>
    </div>
</div>
@endsection