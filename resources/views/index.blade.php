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
                    </div>
                    
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                            {{ $pantai->nama }}
                        </h3>
                        <p class="text-gray-600 flex items-center gap-2">
                            📍 {{ $pantai->lokasi }}
                        </p>
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

    <!-- Decorative Wave -->
    <div class="flex justify-center pt-8">
        <div class="text-6xl opacity-30 animate-bounce">🌊</div>
    </div>
</div>
@endsection