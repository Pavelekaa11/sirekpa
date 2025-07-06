@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Hero Section -->
    <div class="text-center py-8">
        <h1 class="text-4xl font-bold text-white mb-4">🌊 Temukan Pantai Impianmu</h1>
        <p class="text-blue-100 text-lg">Jelajahi keindahan pantai-pantai terbaik di Yogyakarta</p>
    </div>

    <!-- Search Form -->
    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
        <form action="{{ route('beranda.cari') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="q" placeholder="🔍 Cari nama pantai..." 
                       class="w-full p-4 rounded-xl border-0 bg-white/90 backdrop-blur-sm placeholder-gray-500 text-gray-800 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-lg">
            </div>
            <button type="submit" 
                    class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Cari Pantai
            </button>
            <a href="{{ route('form') }}" 
               class="px-6 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-center">
                🎯 Cari Spesifik
            </a>
        </form>
    </div>

    <!-- Popular Beaches Section -->
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl font-bold text-white">⭐ Pantai Populer</h2>
            <div class="flex-1 h-px bg-gradient-to-r from-white/50 to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pantaiPopuler as $pantai)
                <div class="group bg-white/90 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-white/20">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/' . $pantai->gambar) }}" 
                             alt="{{ $pantai->nama }}" 
                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Popular Badge -->
                        <div class="absolute top-4 left-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                            ⭐ Populer
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                            {{ $pantai->nama }}
                        </h3>
                        <p class="text-gray-600 flex items-center gap-2">
                            📍 {{ $pantai->lokasi }}
                        </p>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <span>💰 Rp {{ number_format($pantai->harga_tiket, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('show', $pantai->id) }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 w-full justify-center">
                            <span>Lihat Detail</span>
                            <span class="group-hover:translate-x-1 transition-transform duration-300">→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- All Beaches Section -->
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl font-bold text-white">🏖️ Semua Pantai</h2>
            <div class="flex-1 h-px bg-gradient-to-r from-white/50 to-transparent"></div>
            <div class="bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 border border-white/30">
                <span class="text-white font-semibold">{{ $semuaPantai->count() }} Pantai</span>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-2 justify-center">
            <button class="filter-btn active px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 text-white font-semibold hover:bg-white/30 transition-all duration-300" data-filter="all">
                Semua
            </button>
            <button class="filter-btn px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 text-white font-semibold hover:bg-white/30 transition-all duration-300" data-filter="murah">
                💰 Murah (< Rp 10,000)
            </button>
            <button class="filter-btn px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 text-white font-semibold hover:bg-white/30 transition-all duration-300" data-filter="sedang">
                💰 Sedang (Rp 10,000 - 20,000)
            </button>
            <button class="filter-btn px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 text-white font-semibold hover:bg-white/30 transition-all duration-300" data-filter="mahal">
                💰 Mahal (> Rp 20,000)
            </button>
        </div>

        <!-- Beaches Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="beaches-grid">
            @foreach ($semuaPantai as $pantai)
                @php
                    $hargaClass = '';
                    if ($pantai->harga_tiket < 10000) {
                        $hargaClass = 'murah';
                    } elseif ($pantai->harga_tiket <= 20000) {
                        $hargaClass = 'sedang';
                    } else {
                        $hargaClass = 'mahal';
                    }
                @endphp
                
                <div class="beach-card {{ $hargaClass }} group bg-white/90 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-white/20">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/' . $pantai->gambar) }}" 
                             alt="{{ $pantai->nama }}" 
                             class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Price Badge -->
                        <div class="absolute top-3 right-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                            Rp {{ number_format($pantai->harga_tiket, 0, ',', '.') }}
                        </div>
                    </div>
                    
                    <div class="p-5 space-y-3">
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300 line-clamp-2">
                            {{ $pantai->nama }}
                        </h3>
                        <p class="text-gray-600 flex items-center gap-2 text-sm">
                            📍 {{ $pantai->lokasi }}
                        </p>
                        
                        <!-- Rating Display -->
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <div class="flex items-center gap-1">
                                <span>✨</span>
                                <span>{{ $pantai->keindahan }}/5</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span>🚗</span>
                                <span>{{ $pantai->aksesibilitas }}/5</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span>🏢</span>
                                <span>{{ $pantai->fasilitas }}/5</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span>🎯</span>
                                <span>{{ $pantai->aktivitas }}/5</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('show', $pantai->id) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 w-full justify-center text-sm">
                            <span>Lihat Detail</span>
                            <span class="group-hover:translate-x-1 transition-transform duration-300">→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Load More Button (Optional) -->
    <div class="text-center">
        <button id="load-more" class="px-8 py-4 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" style="display: none;">
            Muat Lebih Banyak
        </button>
    </div>

    <!-- Decorative Wave -->
    <div class="flex justify-center pt-8">
        <div class="text-6xl opacity-30 animate-bounce">🌊</div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.filter-btn.active {
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
    color: white;
}

.beach-card {
    transition: all 0.3s ease;
}

.beach-card.hidden {
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const beachCards = document.querySelectorAll('.beach-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            beachCards.forEach(card => {
                if (filter === 'all' || card.classList.contains(filter)) {
                    card.style.display = 'block';
                    // Add fade in animation
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    // Initialize all cards as visible
    beachCards.forEach(card => {
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    });
});
</script>
@endsection