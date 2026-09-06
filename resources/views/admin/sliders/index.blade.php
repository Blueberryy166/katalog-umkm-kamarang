@extends('layouts.admin')

@section('title', 'Banner Slider Beranda')
@section('page_title', 'Kelola Banner Slider Beranda')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Form Tambah Banner -->
    <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 h-fit">
        <h2 class="text-base font-extrabold text-slate-900 mb-1">Tambah Banner Slider Baru</h2>
        <p class="text-xs text-slate-500 mb-6">Banner promo atau pengumuman di bagian atas beranda web.</p>

        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Banner <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Katalog Produk Unggulan Desa Kamarang" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Sub Judul / Keterangan</label>
                <input type="text" name="subtitle" placeholder="Penjelasan singkat banner..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Gambar Banner (Rasio 16:9, Maks 4MB) <span class="text-rose-500">*</span></label>
                <input type="file" name="image" required accept="image/*" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Teks Tombol</label>
                    <input type="text" name="button_text" placeholder="Lihat Produk" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link Tujuan</label>
                    <input type="text" name="link_url" placeholder="/katalog" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>
            </div>

            <div class="bg-slate-50 p-3 rounded-2xl flex items-center justify-between border border-slate-200">
                <span class="text-xs font-bold text-slate-900">Aktifkan Banner</span>
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs shadow-xs transition-colors">
                Simpan Banner
            </button>
        </form>
    </div>

    <!-- Daftar Banner Slider -->
    <div class="lg:col-span-7 space-y-4">
        <h2 class="text-base font-extrabold text-slate-900">Banner Slider Aktif</h2>

        <div class="space-y-4">
            @forelse($sliders as $s)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="relative aspect-video w-full bg-slate-900">
                        <img src="{{ $s->image_url }}" alt="{{ $s->title }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/banners/hero_village.jpg') }}'">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent flex flex-col justify-end p-6 text-white">
                            <span class="text-[10px] uppercase font-bold text-emerald-400">Order: {{ $s->order_num }} &bull; {{ $s->is_active ? 'Aktif' : 'Non-Aktif' }}</span>
                            <h3 class="text-lg font-bold">{{ $s->title }}</h3>
                            <p class="text-xs text-slate-300">{{ $s->subtitle }}</p>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-slate-500">Link: <code class="bg-slate-200 px-1.5 py-0.5 rounded text-[11px]">{{ $s->link_url ?? '-' }}</code></span>
                            <a href="{{ $s->image_url }}" target="_blank" class="text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 underline">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Buka Gambar
                            </a>
                        </div>
                        <form action="{{ route('admin.sliders.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus banner ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition-colors">
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-200 p-8 text-center text-slate-400 text-xs">
                    Belum ada banner slider tambahan. Banner bawaan sistem akan digunakan.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
