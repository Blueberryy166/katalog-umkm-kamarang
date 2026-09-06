@extends('layouts.app')

@section('title', 'Katalog & Pemasaran Digital UMKM Desa Kamarang - Kec. Greged Cirebon')

@section('content')
<!-- Hero Slider Section -->
@if($sliders->count() > 0)
    <section class="relative bg-slate-950 overflow-hidden" 
             x-data="{
                 activeSlide: 0,
                 totalSlides: {{ $sliders->count() }},
                 interval: null,
                 init() {
                     if (this.totalSlides > 1) {
                         this.startTimer();
                     }
                 },
                 startTimer() {
                     this.interval = setInterval(() => { this.next(); }, 6000);
                 },
                 stopTimer() {
                     if (this.interval) clearInterval(this.interval);
                 },
                 next() {
                     this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                 },
                 prev() {
                     this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
                 },
                 goTo(idx) {
                     this.activeSlide = idx;
                 }
             }"
             @mouseenter="stopTimer()" 
             @mouseleave="startTimer()">

        <!-- Slides Container -->
        <div class="relative w-full min-h-[440px] sm:min-h-[500px] lg:min-h-[560px] flex items-center">
            @foreach($sliders as $idx => $s)
                <div x-show="activeSlide === {{ $idx }}" 
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-102"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-300 absolute inset-0"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-98"
                     class="w-full h-full absolute inset-0 flex items-center">
                    
                    <!-- Banner Image (Clearly visible and crisp) -->
                    <img src="{{ $s->image_url }}" alt="{{ $s->title }}" 
                         class="absolute inset-0 w-full h-full object-cover object-center" 
                         onerror="this.src='{{ asset('images/banners/hero_village.jpg') }}'">
                    
                    <!-- Soft Vignette & Gradient so text is sharp without dimming the image -->
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/60 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/30"></div>

                    <!-- Slide Content -->
                    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 w-full">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                            <div class="lg:col-span-8 space-y-5 text-white">
                                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-bold backdrop-blur-md">
                                    <i class="fa-solid fa-leaf text-amber-400"></i>
                                    <span>UMKM Unggulan Desa Kamarang</span>
                                </div>

                                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight drop-shadow-md text-white">
                                    {{ $s->title }}
                                </h1>

                                @if($s->subtitle)
                                    <p class="text-base sm:text-lg text-slate-200 leading-relaxed drop-shadow-sm max-w-2xl">
                                        {{ $s->subtitle }}
                                    </p>
                                @else
                                    <p class="text-base sm:text-lg text-slate-200 leading-relaxed drop-shadow-sm max-w-2xl">
                                        Jelajahi kelezatan aneka makanan ringan, olahan pangan lokal, dan produk minuman berkualitas karya warga Desa Kamarang, Kecamatan Greged, Kabupaten Cirebon.
                                    </p>
                                @endif

                                <!-- Buttons -->
                                <div class="flex flex-wrap items-center gap-4 pt-2">
                                    <a href="{{ $s->link_url ?: route('catalog.index') }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-slate-950 px-6 py-3.5 rounded-xl font-bold text-sm shadow-xl shadow-emerald-500/30 transition-all hover:scale-105">
                                        <i class="fa-solid fa-bag-shopping"></i>
                                        <span>{{ $s->button_text ?: 'Jelajahi Produk' }}</span>
                                    </a>
                                    <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 bg-slate-900/80 hover:bg-slate-800 text-white border border-slate-700/80 px-6 py-3.5 rounded-xl font-semibold text-sm backdrop-blur-md transition-all">
                                        <i class="fa-solid fa-store text-emerald-400"></i>
                                        <span>Direktori UMKM Desa</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Controls: Next & Prev Arrows (If more than 1 slide) -->
        @if($sliders->count() > 1)
            <button @click="prev()" aria-label="Slide Sebelumnya" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-950/60 hover:bg-emerald-600 text-white flex items-center justify-center backdrop-blur-md transition-all border border-white/20 shadow-lg">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button @click="next()" aria-label="Slide Selanjutnya" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-950/60 hover:bg-emerald-600 text-white flex items-center justify-center backdrop-blur-md transition-all border border-white/20 shadow-lg">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <!-- Dots Indicators -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 bg-slate-950/60 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/15">
                @foreach($sliders as $idx => $s)
                    <button @click="goTo({{ $idx }})" 
                            aria-label="Slide {{ $idx + 1 }}"
                            class="h-2.5 rounded-full transition-all"
                            :class="activeSlide === {{ $idx }} ? 'w-7 bg-emerald-400' : 'w-2.5 bg-white/40 hover:bg-white/70'"></button>
                @endforeach
            </div>
        @endif
    </section>
@else
    <!-- Default Hero Section (Fallback) -->
    <section class="relative bg-slate-900 overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <!-- Hero Background Image & Gradient Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/banners/hero_village.jpg') }}" alt="Desa Kamarang" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 z-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-transparent"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Hero Content -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-xs">
                        <i class="fa-solid fa-leaf text-amber-400"></i>
                        <span>Ekonomi Sirkular & Potensi Lokal Desa Kamarang</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Katalog & Promosi Produk <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-300">UMKM Unggulan</span> Desa Kamarang
                    </h1>

                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Jelajahi kelezatan aneka makanan ringan, olahan pangan lokal, dan produk minuman berkualitas karya warga Desa Kamarang, Kecamatan Greged, Kabupaten Cirebon.
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('catalog.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-slate-950 px-6 py-3.5 rounded-xl font-bold text-sm shadow-lg shadow-emerald-500/30 transition-all hover:scale-105">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span>Lihat Semua Produk</span>
                        </a>
                        <a href="{{ route('umkm.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-800/80 hover:bg-slate-700 text-white border border-slate-700 px-6 py-3.5 rounded-xl font-semibold text-sm backdrop-blur-xs transition-all">
                            <i class="fa-solid fa-store text-emerald-400"></i>
                            <span>Direktori UMKM Desa</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- Quick Search & Stats Bar Section -->
<section class="bg-gradient-to-b from-slate-900 to-slate-950 text-white border-b border-slate-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Fast Search Bar -->
            <div class="lg:col-span-5">
                <form action="{{ route('catalog.index') }}" method="GET">
                    <div class="relative flex items-center">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 text-slate-400"></i>
                        <input type="text" name="q" placeholder="Cari makanan ringan, olahan pangan, minuman..." class="w-full pl-11 pr-24 py-3.5 bg-slate-800/90 border border-slate-700 rounded-xl text-white placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:bg-slate-800 transition-all shadow-inner">
                        <button type="submit" class="absolute right-2 px-4 py-2 bg-emerald-500 text-slate-950 rounded-lg text-xs font-bold hover:bg-emerald-400 transition-colors">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats Highlight Cards -->
            <div class="lg:col-span-7">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                        <span class="text-xl sm:text-2xl font-extrabold text-emerald-400 block">{{ number_format($villageInfo->total_population ?? 3114, 0, ',', '.') }}</span>
                        <span class="text-[11px] text-slate-400 font-medium">Jiwa Penduduk</span>
                    </div>
                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                        <span class="text-xl sm:text-2xl font-extrabold text-amber-400 block">{{ number_format($villageInfo->total_families ?? 1015, 0, ',', '.') }}</span>
                        <span class="text-[11px] text-slate-400 font-medium">Kepala Keluarga</span>
                    </div>
                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                        <span class="text-xl sm:text-2xl font-extrabold text-teal-300 block">{{ $totalUmkm }}</span>
                        <span class="text-[11px] text-slate-400 font-medium">Pelaku UMKM</span>
                    </div>
                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                        <span class="text-xl sm:text-2xl font-extrabold text-cyan-300 block">{{ $totalProducts }}</span>
                        <span class="text-[11px] text-slate-400 font-medium">Produk Terdata</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Quick Bar -->
<section class="py-12 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-xs font-bold uppercase tracking-widest text-emerald-700">Kategori Pilihan</h2>
            <p class="text-xl font-extrabold text-slate-900">Temukan Berdasarkan Jenis Produk</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-4xl mx-auto">
            @foreach($categories as $cat)
                <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}" class="group bg-slate-50 hover:bg-emerald-50/90 p-6 rounded-3xl border border-slate-200 hover:border-emerald-300 transition-all card-hover flex items-center gap-5 shadow-xs">
                    <div class="w-14 h-14 rounded-2xl bg-white shadow-xs group-hover:bg-emerald-600 group-hover:text-white text-emerald-600 flex items-center justify-center text-2xl transition-all">
                        @if($cat->slug == 'makanan-ringan')
                            <i class="fa-solid fa-cookie-bite"></i>
                        @elseif($cat->slug == 'olahan-pangan')
                            <i class="fa-solid fa-bowl-rice"></i>
                        @elseif($cat->slug == 'minuman')
                            <i class="fa-solid fa-glass-water"></i>
                        @else
                            <i class="fa-solid fa-tags"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-800 transition-colors">{{ $cat->name }}</h3>
                        <span class="text-xs text-slate-500 font-medium">{{ $cat->products_count }} Produk</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section (Produk Unggulan) -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">Paling Diminati</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Produk Unggulan Desa Kamarang</h2>
                <p class="text-sm text-slate-600 mt-1">Pilihan produk terbaik dengan citarasa otentik dan kemasan higienis.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="mt-4 sm:mt-0 inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition-colors">
                <span>Lihat Semua Katalog</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if($featuredProducts->count() > 0)
            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between card-hover group">
                        <div>
                            <!-- Product Image & Badges -->
                            <div class="relative aspect-square overflow-hidden bg-slate-100">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                
                                <!-- Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                    <span class="bg-amber-500 text-slate-950 font-extrabold text-[10px] px-2.5 py-1 rounded-md shadow-xs uppercase tracking-wide">
                                        Unggulan
                                    </span>
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
        @else
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-lg mx-auto shadow-xs">
                <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-2xl mb-4">
                    <i class="fa-solid fa-store"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1">Katalog Produk Segera Hadir</h3>
                <p class="text-xs text-slate-500 mb-6 leading-relaxed">
                    Daftar produk unggulan UMKM Desa Kamarang sedang dalam proses kurasi dan pembaharuan data.
                </p>
                <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-store"></i> Jelajahi Direktori UMKM
                </a>
            </div>
        @endif
    </div>
</section>

<!-- UMKM Directory Preview Section -->
<section class="py-16 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">Pelaku Usaha Warga</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Direktori UMKM Desa Kamarang</h2>
                <p class="text-sm text-slate-600 mt-1">Dukung kemandirian ekonomi desa dengan membeli langsung dari produsen lokal.</p>
            </div>
            <a href="{{ route('umkm.index') }}" class="mt-4 sm:mt-0 inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition-colors">
                <span>Lihat Semua UMKM</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if($umkms->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($umkms as $umkm)
                    <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 flex flex-col justify-between card-hover">
                        <div>
                            <div class="w-14 h-14 rounded-2xl bg-white border border-slate-200 overflow-hidden mb-4 shadow-xs">
                                <img src="{{ $umkm->logo_url }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">
                                <a href="{{ route('umkm.show', $umkm->slug) }}" class="hover:text-emerald-600 transition-colors">{{ $umkm->name }}</a>
                            </h3>
                            <div class="flex items-center gap-1 text-xs text-amber-600 font-semibold mb-2">
                                <i class="fa-solid fa-user text-[10px]"></i>
                                <span>{{ $umkm->owner_name }}</span>
                            </div>
                            <p class="text-xs text-slate-500 line-clamp-2 mb-4 leading-relaxed">
                                {{ $umkm->description }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between text-xs text-slate-600">
                                <span class="flex items-center gap-1"><i class="fa-solid fa-location-dot text-emerald-600"></i> {{ $umkm->dusun ?? 'Desa Kamarang' }}</span>
                                <span class="font-bold text-emerald-700">{{ $umkm->products_count }} Produk</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 pt-2">
                                <a href="{{ route('umkm.show', $umkm->slug) }}" class="text-center py-2 px-3 rounded-xl bg-white border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-semibold transition-colors">
                                    Toko
                                </a>
                                @if($umkm->has_whatsapp)
                                    <a href="{{ $umkm->whatsapp_link }}" target="_blank" class="text-center py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors">
                                        <i class="fa-brands fa-whatsapp"></i> Hubungi
                                    </a>
                                @else
                                    <a href="{{ route('umkm.show', $umkm->slug) }}" class="text-center py-2 px-3 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold transition-colors" title="Pemesanan langsung di tempat">
                                        <i class="fa-solid fa-location-dot text-emerald-600"></i> Lokasi
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-slate-50 rounded-3xl border border-slate-200 p-10 text-center max-w-md mx-auto">
                <p class="text-xs text-slate-500">Belum ada data UMKM yang terdaftar di sistem.</p>
            </div>
        @endif
    </div>
</section>

<!-- Village Head & KKM Greeting Box -->
<section class="py-16 bg-gradient-to-br from-emerald-900 to-slate-900 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-4 text-center lg:text-left space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold border border-emerald-400/30">
                    <i class="fa-solid fa-handshake-angle"></i> Kolaborasi KKM UMC 2026
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Membangun Kemandirian Ekonomi Desa</h2>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Pengembangan platform digital ini merupakan program kerja Kuliah Kerja Mahasiswa (KKM) Kelompok 26 Universitas Muhammadiyah Cirebon dalam rangka penguatan branding dan pemasaran produk UMKM lokal.
                </p>
                <div class="pt-2">
                    <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 bg-white text-slate-950 hover:bg-emerald-100 px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md">
                        <i class="fa-solid fa-store text-emerald-700"></i> Jelajahi Direktori UMKM
                    </a>
                </div>
            </div>

            <div class="lg:col-span-8 bg-white/10 backdrop-blur-md rounded-2xl p-6 sm:p-8 border border-white/20 space-y-4">
                <i class="fa-solid fa-quote-left text-3xl text-emerald-400 opacity-60"></i>
                <p class="text-sm sm:text-base text-slate-200 italic leading-relaxed">
                    "{{ $villageInfo->village_head_speech ?? 'Website ini merupakan wujud nyata kolaborasi untuk memajukan perekonomian dan daya saing produk UMKM warga Desa Kamarang ke ranah digital yang lebih luas.' }}"
                </p>
                <div class="pt-4 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-slate-300">
                    <div>
                        <span class="font-bold text-white block text-sm">{{ $villageInfo->village_head_name ?? 'Pemerintah Desa Kamarang' }}</span>
                        <span>Kecamatan Greged, Kabupaten Cirebon</span>
                    </div>
                    <div class="text-amber-300 font-semibold">
                        {{ $villageInfo->kkm_team_name ?? 'KKM Kelompok 26 Universitas Muhammadiyah Cirebon 2026' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
