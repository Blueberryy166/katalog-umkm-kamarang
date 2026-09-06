@extends('layouts.app')

@section('title', 'Katalog Produk UMKM Desa Kamarang')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center justify-center sm:justify-start gap-2 text-xs text-emerald-300 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-white font-bold">Katalog Produk</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Katalog Produk UMKM Desa Kamarang</h1>
                <p class="text-sm text-emerald-100 mt-1">Eksplorasi aneka ragam produk olahan pangan, camilan, dan kerajinan khas desa.</p>
            </div>
            <div class="text-xs bg-white/10 px-4 py-2 rounded-xl backdrop-blur-xs border border-white/20 inline-block">
                Menampilkan <strong class="text-amber-300 font-extrabold">{{ $products->total() }}</strong> Produk
            </div>
        </div>
    </div>
</div>

<!-- Main Catalog Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-6 mb-8 shadow-xs">
        <form action="{{ route('catalog.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                <!-- Search Input -->
                <div class="md:col-span-5 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk / olahan..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>

                <!-- UMKM Filter Dropdown -->
                <div class="md:col-span-3">
                    <select name="umkm" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        <option value="">Semua Pelaku UMKM</option>
                        @foreach($umkms as $u)
                            <option value="{{ $u->slug }}" {{ request('umkm') == $u->slug ? 'selected' : '' }}>
                                {{ $u->name }} ({{ $u->products_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort Dropdown -->
                <div class="md:col-span-2">
                    <select name="sort" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 flex gap-2">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 px-4 rounded-xl text-sm font-bold shadow-xs transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    @if(request()->hasAny(['q', 'category', 'umkm', 'sort', 'stock']))
                        <a href="{{ route('catalog.index') }}" title="Reset Filter" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm transition-colors flex items-center justify-center">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Category Pills -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 pt-2 border-t border-slate-100">
                <span class="text-xs font-bold text-slate-400 whitespace-nowrap mr-1">Kategori:</span>
                <a href="{{ route('catalog.index', array_merge(request()->except('category'), [])) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition-colors {{ !request('category') ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Kategori
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('catalog.index', array_merge(request()->except('category'), ['category' => $cat->slug])) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition-colors {{ request('category') == $cat->slug ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $cat->name }} ({{ $cat->products_count }})
                    </a>
                @endforeach
            </div>
        </form>
    </div>

    <!-- Active Filters Indicator -->
    @if($selectedCategory || $selectedUmkm || request('q'))
        <div class="flex flex-wrap items-center gap-2 mb-6 text-xs text-slate-600">
            <span class="font-bold">Filter Aktif:</span>
            @if(request('q'))
                <span class="inline-flex items-center gap-1 bg-slate-200 px-2.5 py-1 rounded-md">
                    Keyword: "{{ request('q') }}"
                    <a href="{{ route('catalog.index', request()->except('q')) }}" class="text-slate-500 hover:text-slate-900"><i class="fa-solid fa-xmark"></i></a>
                </span>
            @endif
            @if($selectedCategory)
                <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-md">
                    Kategori: {{ $selectedCategory->name }}
                    <a href="{{ route('catalog.index', request()->except('category')) }}" class="text-emerald-800 hover:text-emerald-950"><i class="fa-solid fa-xmark"></i></a>
                </span>
            @endif
            @if($selectedUmkm)
                <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-900 px-2.5 py-1 rounded-md">
                    UMKM: {{ $selectedUmkm->name }}
                    <a href="{{ route('catalog.index', request()->except('umkm')) }}" class="text-amber-900 hover:text-amber-950"><i class="fa-solid fa-xmark"></i></a>
                </span>
            @endif
            <a href="{{ route('catalog.index') }}" class="text-emerald-600 hover:underline font-semibold ml-2">Hapus Semua</a>
        </div>
    @endif

    <!-- Product Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between card-hover group">
                    <div>
                        <!-- Product Image & Badges -->
                        <div class="relative aspect-square overflow-hidden bg-slate-100">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                @if($product->is_featured)
                                    <span class="bg-amber-500 text-slate-950 font-extrabold text-[10px] px-2.5 py-1 rounded-md shadow-xs uppercase tracking-wide">
                                        Unggulan
                                    </span>
                                @endif
                                @if($product->pirt_number)
                                    <span class="bg-slate-900/80 text-white text-[10px] px-2 py-0.5 rounded-md backdrop-blur-xs font-medium">
                                        P-IRT
                                    </span>
                                @endif
                            </div>

                            <div class="absolute top-3 right-3">
                                <span class="text-[10px] font-bold px-2 py-1 rounded-md border {{ $product->stock_status_badge_class }}">
                                    {{ $product->stock_status_label }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Content -->
                        <div class="p-5">
                            <div class="text-[11px] font-semibold text-emerald-600 uppercase tracking-wide mb-1">
                                {{ $product->category->name ?? 'UMKM Kamarang' }}
                            </div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-1 mb-1">
                                <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 mb-3">
                                {{ $product->short_description }}
                            </p>
                            
                            <!-- Seller Tag & Variants -->
                            <div class="flex items-center justify-between gap-2 pt-2 border-t border-slate-100 text-xs text-slate-600">
                                <div class="flex items-center gap-1.5 truncate">
                                    <i class="fa-solid fa-store text-emerald-600 text-[11px]"></i>
                                    <span class="truncate font-medium">{{ $product->umkm->name ?? 'UMKM Kamarang' }}</span>
                                </div>
                                @if($product->has_variants)
                                    <span class="text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200 px-1.5 py-0.5 rounded font-semibold shrink-0">
                                        {{ count($product->variants) }} Varian
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Price & WhatsApp Direct Chat -->
                    <div class="p-5 pt-0">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div>
                                <span class="text-xs text-slate-400 block">Harga</span>
                                <span class="text-base font-extrabold text-emerald-700">{{ $product->formatted_price }}</span>
                                <span class="text-[11px] text-slate-500">/ {{ $product->unit }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl border border-slate-300 hover:border-slate-400 text-slate-700 text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-circle-info"></i> Detail
                            </a>
                            @if($product->has_whatsapp)
                                <a href="{{ $product->whatsapp_order_url }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs shadow-emerald-600/30 transition-all">
                                    <i class="fa-brands fa-whatsapp text-sm"></i> Chat WA
                                </a>
                            @else
                                <a href="{{ route('umkm.show', $product->umkm->slug) }}" class="inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors" title="Pemesanan langsung di tempat">
                                    <i class="fa-solid fa-store text-emerald-600"></i> Ke Toko
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-lg mx-auto shadow-xs">
            <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-2xl mb-4">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1">
                @if(request()->hasAny(['q', 'category', 'umkm', 'sort', 'stock']))
                    Produk Tidak Ditemukan
                @else
                    Katalog Produk Segera Hadir
                @endif
            </h3>
            <p class="text-xs text-slate-500 mb-6 leading-relaxed">
                @if(request()->hasAny(['q', 'category', 'umkm', 'sort', 'stock']))
                    Maaf, tidak ada produk yang sesuai dengan filter pencarian Anda. Coba gunakan kata kunci lain atau reset filter.
                @else
                    Data produk olahan UMKM Desa Kamarang sedang dalam proses pembaharuan oleh pengelola. Silakan kunjungi kembali dalam waktu dekat.
                @endif
            </p>
            @if(request()->hasAny(['q', 'category', 'umkm', 'sort', 'stock']))
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">
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
