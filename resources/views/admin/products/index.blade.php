@extends('layouts.admin')

@section('title', 'Kelola Produk UMKM')
@section('page_title', 'Daftar Produk UMKM')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Produk Katalog</h2>
            <p class="text-xs text-slate-500">Kelola daftar seluruh produk yang tampil di website katalog desa.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-emerald-600/20 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Produk Baru</span>
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
        <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div class="sm:col-span-3">
                <select name="category_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-3">
                <select name="umkm_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">Semua UMKM</option>
                    @foreach($umkms as $u)
                        <option value="{{ $u->id }}" {{ request('umkm_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-1 flex gap-1">
                <button type="submit" class="w-full bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors flex items-center justify-center p-2">
                    <i class="fa-solid fa-filter"></i>
                </button>
                @if(request()->hasAny(['q', 'category_id', 'umkm_id']))
                    <a href="{{ route('admin.products.index') }}" class="p-2 bg-slate-100 text-slate-600 rounded-xl text-xs hover:bg-slate-200 transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                        <th class="py-4 px-6">Foto & Nama Produk</th>
                        <th class="py-4 px-4">UMKM Penjual</th>
                        <th class="py-4 px-4">Kategori</th>
                        <th class="py-4 px-4">Harga / Satuan</th>
                        <th class="py-4 px-4 text-center">Status Stok</th>
                        <th class="py-4 px-4 text-center">Unggulan</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <a href="{{ route('catalog.show', $product->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-emerald-700 block line-clamp-1 max-w-xs">
                                            {{ $product->name }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[10px] text-slate-400">P-IRT: {{ $product->pirt_number ?? '-' }} &bull; Dilihat: {{ $product->view_count }}x</span>
                                            @if($product->has_variants)
                                                <span class="bg-teal-50 text-teal-700 border border-teal-200 text-[10px] px-1.5 py-0.2 rounded font-semibold">
                                                    {{ count($product->variants) }} varian
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-slate-700 font-medium">
                                {{ $product->umkm->name ?? '-' }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-emerald-50 text-emerald-800 px-2 py-1 rounded-md font-semibold text-[11px]">
                                    {{ $product->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-900">{{ $product->formatted_price }}</div>
                                <span class="text-[10px] text-slate-400 font-normal">/ {{ $product->unit }}</span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold border {{ $product->stock_status_badge_class }}">
                                    {{ $product->stock_status_label }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('admin.products.toggle-featured', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" title="Klik untuk ubah status unggulan" class="p-1 rounded-lg transition-transform hover:scale-110 {{ $product->is_featured ? 'text-amber-500' : 'text-slate-300 hover:text-slate-400' }}">
                                        <i class="fa-solid fa-star text-base"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
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
                                <i class="fa-solid fa-box-open text-3xl mb-2 block"></i>
                                Belum ada data produk yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
