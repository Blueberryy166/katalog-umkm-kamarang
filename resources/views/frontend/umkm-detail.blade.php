@extends('layouts.app')

@section('title', $umkm->name . ' - Profil UMKM Desa Kamarang')
@section('meta_description', Str::limit($umkm->description, 160))

@section('content')
<!-- Store Profile Header -->
<div class="bg-gradient-to-br from-emerald-950 via-slate-900 to-teal-950 text-white py-12 lg:py-16 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-emerald-300 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('umkm.index') }}" class="hover:text-white">Direktori UMKM</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-white font-bold">{{ $umkm->name }}</span>
        </nav>

        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <!-- Store Logo -->
            <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-3xl bg-white p-2 border-2 border-emerald-500/40 shadow-2xl overflow-hidden shrink-0">
                <img src="{{ $umkm->logo_url }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover rounded-2xl">
            </div>

            <!-- Store Info -->
            <div class="flex-1 text-center md:text-left space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold border border-emerald-400/30">
                    <i class="fa-solid fa-store text-amber-400"></i> UMKM Terdaftar Desa Kamarang
                </div>

                <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                    {{ $umkm->name }}
                </h1>

                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs text-slate-300">
                    <span class="flex items-center gap-1 text-amber-400 font-semibold">
                        <i class="fa-solid fa-user"></i> Pemilik: {{ $umkm->owner_name }}
                    </span>
                    <span>&bull;</span>
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-emerald-400"></i> {{ $umkm->address ?? 'Desa Kamarang, Kec. Greged' }}
                    </span>
                </div>

                <p class="text-sm text-slate-300 max-w-3xl leading-relaxed">
                    {{ $umkm->description }}
                </p>

                <!-- Actions -->
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 pt-2">
                    @if($umkm->has_whatsapp)
                        <a href="{{ $umkm->whatsapp_link }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold px-5 py-2.5 rounded-xl text-xs shadow-md transition-all">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Hubungi Toko via WhatsApp</span>
                        </a>
                    @else
                        <div class="inline-flex items-center gap-2 bg-amber-500/20 text-amber-300 font-bold px-4 py-2.5 rounded-xl text-xs border border-amber-400/30">
                            <i class="fa-solid fa-store text-amber-400"></i>
                            <span>Pemesanan Langsung di Lokasi Usaha</span>
                        </div>
                    @endif

                    @if($umkm->google_maps_url)
                        <a href="{{ $umkm->google_maps_url }}" target="_blank" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-4 py-2.5 rounded-xl text-xs border border-white/20 backdrop-blur-xs transition-all">
                            <i class="fa-solid fa-map-location-dot text-amber-400"></i>
                            <span>Buka Google Maps</span>
                        </a>
                        @if($umkm->has_coordinates)
                            <a href="{{ $umkm->google_maps_direction_url }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-700/60 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs border border-emerald-500/40 backdrop-blur-xs transition-all">
                                <i class="fa-solid fa-diamond-turn-right text-emerald-300"></i>
                                <span>Petunjuk Arah</span>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Store Location & Google Maps Showcase Section -->
@if($umkm->google_maps_embed_url || $umkm->address)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-emerald-700 font-bold text-xs uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Lokasi Fisik Usaha</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Peta & Alamat UMKM {{ $umkm->name }}</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kunjungi langsung tempat produksi atau outlet kami di Desa Kamarang.</p>
                </div>

                @if($umkm->google_maps_url)
                    <div class="flex items-center gap-2.5 shrink-0">
                        @if($umkm->has_coordinates)
                            <a href="{{ $umkm->google_maps_direction_url }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-xs transition-all">
                                <i class="fa-solid fa-diamond-turn-right"></i> Petunjuk Arah
                            </a>
                        @endif
                        <a href="{{ $umkm->google_maps_url }}" target="_blank" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-xs font-bold transition-colors">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Peta Penuh
                        </a>
                    </div>
                @endif
            </div>

            <!-- Address Card Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                    <span class="text-slate-400 font-semibold uppercase tracking-wider text-[10px] block">Alamat Lengkap</span>
                    <p class="font-bold text-slate-800">{{ $umkm->address ?? 'Desa Kamarang, Kec. Greged, Kab. Cirebon' }}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                    <span class="text-slate-400 font-semibold uppercase tracking-wider text-[10px] block">Wilayah Dusun</span>
                    <p class="font-bold text-slate-800">{{ $umkm->dusun ?? 'Desa Kamarang' }}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                    <span class="text-slate-400 font-semibold uppercase tracking-wider text-[10px] block">Koordinat GPS</span>
                    <p class="font-bold text-slate-800 font-mono">
                        @if($umkm->has_coordinates)
                            {{ number_format($umkm->latitude, 6) }}, {{ number_format($umkm->longitude, 6) }}
                        @else
                            <span class="text-slate-400 font-sans font-normal">Lokasi Desa Kamarang</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Interactive Google Maps Iframe Embed -->
            @if($umkm->google_maps_embed_url)
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-sm aspect-[16/9] sm:aspect-[21/9] w-full bg-slate-100 relative">
                    <iframe 
                        src="{{ $umkm->google_maps_embed_url }}" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full">
                    </iframe>
                </div>
            @endif
        </div>
    </div>
@endif

<!-- Store Products Showcase -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Produk yang Dijual</h2>
            <p class="text-xs text-slate-500">Koleksi seluruh produk olahan dari {{ $umkm->name }}.</p>
        </div>
        <span class="text-xs font-bold bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-full">
            {{ $products->total() }} Produk
        </span>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between card-hover group">
                    <div>
                        <!-- Image -->
                        <div class="relative aspect-square overflow-hidden bg-slate-100">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-3 right-3">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md border {{ $product->stock_status_badge_class }}">
                                    {{ $product->stock_status_label }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <div class="flex items-center justify-between gap-1 mb-1">
                                <span class="text-[10px] font-bold text-emerald-700 uppercase">{{ $product->category->name ?? 'Produk' }}</span>
                                @if($product->has_variants)
                                    <span class="text-[9px] bg-emerald-50 text-emerald-700 border border-emerald-200 px-1 py-0.2 rounded font-semibold">
                                        {{ count($product->variants) }} Varian
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-1 mb-1">
                                <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 mb-3">
                                {{ $product->short_description }}
                            </p>
                            <p class="text-base font-extrabold text-emerald-700">
                                {{ $product->formatted_price }} <span class="text-xs text-slate-400 font-normal">/ {{ $product->unit }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="p-5 pt-0 grid grid-cols-2 gap-2">
                        <a href="{{ route('catalog.show', $product->slug) }}" class="text-center py-2 px-2 rounded-xl border border-slate-300 hover:border-slate-400 text-slate-700 text-xs font-semibold transition-colors">
                            Detail
                        </a>
                        @if($product->has_whatsapp)
                            <a href="{{ $product->whatsapp_order_url }}" target="_blank" class="text-center py-2 px-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors">
                                <i class="fa-brands fa-whatsapp"></i> Chat WA
                            </a>
                        @else
                            <a href="{{ route('catalog.show', $product->slug) }}" class="text-center py-2 px-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-circle-info text-emerald-600"></i> Info
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-md mx-auto">
            <p class="text-xs text-slate-500">Belum ada produk yang diunggah untuk toko ini.</p>
        </div>
    @endif
</div>
@endsection
