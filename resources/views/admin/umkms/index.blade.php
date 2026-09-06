@extends('layouts.admin')

@section('title', 'Kelola Data UMKM')
@section('page_title', 'Data UMKM Desa Kamarang')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Pelaku UMKM Terdaftar</h2>
            <p class="text-xs text-slate-500">Kelola direktori toko, pemilik, lokasi dusun, dan kontak WhatsApp.</p>
        </div>
        <a href="{{ route('admin.umkms.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-emerald-600/20 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah UMKM Baru</span>
        </a>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
        <form action="{{ route('admin.umkms.index') }}" method="GET" class="flex gap-3">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama toko, pemilik, atau dusun..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.umkms.index') }}" class="p-2 bg-slate-100 text-slate-600 rounded-xl text-xs hover:bg-slate-200 transition-colors flex items-center justify-center">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                        <th class="py-4 px-6">Logo & Nama Usaha</th>
                        <th class="py-4 px-4">Nama Pemilik</th>
                        <th class="py-4 px-4">Kontak WhatsApp</th>
                        <th class="py-4 px-4">Dusun / Alamat</th>
                        <th class="py-4 px-4 text-center">Jumlah Produk</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($umkms as $umkm)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                                        <img src="{{ $umkm->logo_url }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <a href="{{ route('umkm.show', $umkm->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-emerald-700 block max-w-xs">
                                            {{ $umkm->name }}
                                        </a>
                                        <span class="text-[10px] text-slate-400">Slug: {{ $umkm->slug }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                {{ $umkm->owner_name }}
                            </td>
                            <td class="py-4 px-4">
                                <a href="https://wa.me/{{ $umkm->clean_phone }}" target="_blank" class="text-emerald-700 font-bold hover:underline flex items-center gap-1">
                                    <i class="fa-brands fa-whatsapp"></i> {{ $umkm->phone }}
                                </a>
                            </td>
                            <td class="py-4 px-4 text-slate-600">
                                <span class="font-bold text-slate-800 block">{{ $umkm->dusun ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 truncate max-w-xs block">{{ $umkm->address }}</span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="bg-emerald-50 text-emerald-800 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                    {{ $umkm->products_count }} Produk
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($umkm->is_active)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.umkms.edit', $umkm->id) }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.umkms.destroy', $umkm->id) }}" method="POST" onsubmit="return confirm('Menghapus UMKM ini akan menghapus seluruh produk yang terhubung dengannya. Lanjutkan?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                Belum ada data UMKM terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($umkms->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $umkms->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
