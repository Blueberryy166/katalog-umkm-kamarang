@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Ringkasan')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-800 text-white rounded-3xl p-6 sm:p-8 shadow-sm relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-block bg-white/20 text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 backdrop-blur-xs">
                    KKM UMC 2026 &bull; Desa Kamarang
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang di Panel CMS UMKM</h2>
                <p class="text-xs sm:text-sm text-emerald-100 mt-1 max-w-xl">
                    Kelola data produk olahan pangan, profil toko UMKM, kategori, dan informasi desa secara mandiri dan cepat.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-white text-slate-950 rounded-xl text-xs font-bold shadow-md hover:bg-emerald-50 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-plus text-emerald-600"></i> Tambah Produk
                </a>
                <a href="{{ route('admin.umkms.create') }}" class="px-4 py-2.5 bg-emerald-950/60 hover:bg-emerald-950 text-white rounded-xl text-xs font-bold border border-emerald-400/30 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-store text-amber-300"></i> Tambah UMKM
                </a>
            </div>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Metric 1 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Produk</span>
                <span class="text-3xl font-extrabold text-slate-900">{{ $totalProducts }}</span>
                <span class="text-[11px] text-emerald-600 font-semibold block mt-1">Aktif di Katalog</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>

        <!-- Metric 2 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Pelaku UMKM</span>
                <span class="text-3xl font-extrabold text-slate-900">{{ $totalUmkms }}</span>
                <span class="text-[11px] text-teal-600 font-semibold block mt-1">Toko Terdaftar</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-store"></i>
            </div>
        </div>

        <!-- Metric 3 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Kategori Produk</span>
                <span class="text-3xl font-extrabold text-slate-900">{{ $totalCategories }}</span>
                <span class="text-[11px] text-amber-600 font-semibold block mt-1">Kelompok Usaha</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-tags"></i>
            </div>
        </div>

        <!-- Metric 4 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Kunjungan</span>
                <span class="text-3xl font-extrabold text-slate-900">{{ number_format($totalViews, 0, ',', '.') }}</span>
                <span class="text-[11px] text-cyan-600 font-semibold block mt-1">Dilihat Calon Pembeli</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>
    </div>

    <!-- Content Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Top Products Table -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Produk Paling Populer</h3>
                    <p class="text-xs text-slate-500">Berdasarkan jumlah kunjungan calon pembeli.</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 uppercase font-bold text-[10px]">
                            <th class="pb-3">Produk</th>
                            <th class="pb-3">UMKM</th>
                            <th class="pb-3">Harga</th>
                            <th class="pb-3 text-center">Dilihat</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($topProducts as $tp)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shrink-0">
                                            <img src="{{ $tp->image_url }}" alt="{{ $tp->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block truncate max-w-xs">{{ $tp->name }}</span>
                                            <span class="text-[10px] text-slate-400">{{ $tp->category->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-slate-600 font-medium">{{ $tp->umkm->name ?? '-' }}</td>
                                <td class="py-3 font-bold text-emerald-700">{{ $tp->formatted_price }}</td>
                                <td class="py-3 text-center font-bold text-slate-700">{{ $tp->view_count }}x</td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('admin.products.edit', $tp->id) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-bold">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">Belum ada data produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent UMKMs List -->
        <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-extrabold text-slate-900">UMKM Terdaftar</h3>
                    <a href="{{ route('admin.umkms.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">Kelola</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentUmkms as $ru)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 overflow-hidden shrink-0">
                                    <img src="{{ $ru->logo_url }}" alt="{{ $ru->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block truncate max-w-[150px]">{{ $ru->name }}</span>
                                    <span class="text-[10px] text-amber-700 font-semibold">{{ $ru->owner_name }}</span>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-md">
                                {{ $ru->products_count }} Produk
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada UMKM terdaftar.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.guide.index') }}" class="flex items-center justify-between text-xs text-amber-800 bg-amber-50 p-3 rounded-2xl border border-amber-200 font-bold hover:bg-amber-100 transition-colors">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-book-open-reader text-amber-600"></i> Panduan Pengelolaan Web</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
