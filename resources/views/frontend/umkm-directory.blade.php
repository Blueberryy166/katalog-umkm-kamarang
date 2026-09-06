@extends('layouts.app')

@section('title', 'Direktori UMKM Desa Kamarang - Kec. Greged Cirebon')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center justify-center sm:justify-start gap-2 text-xs text-emerald-300 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-white font-bold">Direktori UMKM</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Direktori UMKM Desa Kamarang</h1>
                <p class="text-sm text-emerald-100 mt-1">Daftar lengkap profil pelaku usaha, perajin, dan produsen olahan lokal Desa Kamarang.</p>
            </div>
            <div class="text-xs bg-white/10 px-4 py-2 rounded-xl backdrop-blur-xs border border-white/20 inline-block">
                Total <strong class="text-amber-300 font-extrabold">{{ $umkms->total() }}</strong> Usaha Terdata
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-6 mb-8 shadow-xs">
        <form action="{{ route('umkm.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
            <div class="sm:col-span-6 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama usaha atau pemilik..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div class="sm:col-span-4">
                <select name="dusun" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">Semua Dusun / Wilayah</option>
                    @foreach($dusuns as $d)
                        <option value="{{ $d }}" {{ request('dusun') == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 px-4 rounded-xl text-sm font-bold shadow-xs transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
                @if(request()->hasAny(['q', 'dusun']))
                    <a href="{{ route('umkm.index') }}" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- UMKM Cards Grid -->
    @if($umkms->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($umkms as $umkm)
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between card-hover">
                    <div class="p-6">
                        <!-- Top Logo & Info -->
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 shadow-xs">
                                <img src="{{ $umkm->logo_url }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 leading-snug">
                                    <a href="{{ route('umkm.show', $umkm->slug) }}" class="hover:text-emerald-600 transition-colors">{{ $umkm->name }}</a>
                                </h3>
                                <div class="text-xs text-amber-700 font-semibold mt-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-user text-[11px]"></i>
                                    <span>{{ $umkm->owner_name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3 mb-4">
                            {{ $umkm->description ?? 'Pelaku usaha mikro binaan Desa Kamarang yang memproduksi aneka produk berkualitas tinggi.' }}
                        </p>

                        <!-- Address -->
                        <div class="space-y-1.5 text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <div class="flex items-start gap-2">
                                <i class="fa-solid fa-location-dot text-emerald-600 mt-0.5"></i>
                                <span class="line-clamp-1">{{ $umkm->address ?? 'Desa Kamarang, Kec. Greged, Cirebon' }}</span>
                            </div>
                            @if($umkm->has_whatsapp)
                                <div class="flex items-center gap-2">
                                    <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                                    <span>{{ $umkm->phone }}</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-slate-500">
                                    <i class="fa-solid fa-store text-amber-500"></i>
                                    <span>Pemesanan di Tempat</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3">
                        <span class="text-xs font-bold text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full">
                            {{ $umkm->products_count }} Produk
                        </span>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('umkm.show', $umkm->slug) }}" class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-300 hover:border-slate-400 text-slate-700 text-xs font-bold transition-colors">
                                Lihat Toko
                            </a>
                            @if($umkm->has_whatsapp)
                                <a href="{{ $umkm->whatsapp_link }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors inline-flex items-center gap-1">
                                    <i class="fa-brands fa-whatsapp"></i> Chat
                                </a>
                            @else
                                <a href="{{ $umkm->google_maps_url ?? route('umkm.show', $umkm->slug) }}" target="{{ $umkm->google_maps_url ? '_blank' : '_self' }}" class="px-3.5 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold transition-colors inline-flex items-center gap-1" title="Lihat lokasi di Google Maps">
                                    <i class="fa-solid fa-location-dot text-emerald-600"></i> Lokasi Peta
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $umkms->links() }}
        </div>
    @else
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-lg mx-auto shadow-xs">
            <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-2xl mb-4">
                <i class="fa-solid fa-store"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1">
                @if(request()->hasAny(['q', 'dusun']))
                    UMKM Tidak Ditemukan
                @else
                    Direktori UMKM Segera Hadir
                @endif
            </h3>
            <p class="text-xs text-slate-500 mb-6 leading-relaxed">
                @if(request()->hasAny(['q', 'dusun']))
                    Tidak ada data UMKM yang cocok dengan filter pencarian Anda. Coba gunakan kata kunci atau dusun lain.
                @else
                    Data pelaku UMKM Desa Kamarang sedang dalam proses pendataan dan verifikasi. Silakan kunjungi kembali dalam waktu dekat.
                @endif
            </p>
            @if(request()->hasAny(['q', 'dusun']))
                <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            @else
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-house"></i> Kembali ke Beranda
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
