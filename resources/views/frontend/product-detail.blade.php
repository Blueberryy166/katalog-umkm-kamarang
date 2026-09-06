@extends('layouts.app')

@section('title', $product->name . ' - UMKM Desa Kamarang')
@section('meta_description', Str::limit($product->short_description ?? $product->full_description, 160))
@section('og_image', $product->image_url)

@section('content')
<!-- Breadcrumbs Bar -->
<div class="bg-slate-100 border-b border-slate-200 py-3.5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-slate-500 overflow-x-auto whitespace-nowrap">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 font-medium">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('catalog.index') }}" class="hover:text-emerald-700 font-medium">Katalog</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            @if($product->category)
                <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-emerald-700 font-medium">{{ $product->category->name }}</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            @endif
            <span class="text-slate-900 font-bold truncate max-w-xs">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10 mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left: Product Image Gallery -->
            <div class="lg:col-span-5 space-y-4">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-xs">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        @if($product->is_featured)
                            <span class="bg-amber-500 text-slate-950 font-extrabold text-xs px-3 py-1 rounded-lg shadow-md uppercase tracking-wider">
                                Produk Unggulan
                            </span>
                        @endif
                        @if($product->pirt_number)
                            <span class="bg-slate-900/80 text-white text-xs px-3 py-1 rounded-lg backdrop-blur-xs font-semibold">
                                {{ $product->pirt_number }}
                            </span>
                        @endif
                    </div>

                    <div class="absolute top-4 right-4">
                        <span class="text-xs font-bold px-3 py-1 rounded-lg border shadow-xs {{ $product->stock_status_badge_class }}">
                            {{ $product->stock_status_label }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400 px-1">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-eye text-slate-400"></i> Dilihat {{ $product->view_count }} kali</span>
                    <span class="text-emerald-700 font-semibold flex items-center gap-1"><i class="fa-solid fa-shield-check"></i> Produk Asli Desa Kamarang</span>
                </div>
            </div>

            <!-- Right: Product Information & Direct WhatsApp CTA -->
            <div class="lg:col-span-7 flex flex-col justify-between space-y-6">
                <div>
                    <!-- Category Tag -->
                    <div class="flex items-center gap-2 mb-2">
                        <a href="{{ route('catalog.index', ['category' => $product->category->slug ?? '']) }}" class="text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1 rounded-lg transition-colors">
                            {{ $product->category->name ?? 'Olahan Pangan' }}
                        </a>
                        <span class="text-slate-300">&bull;</span>
                        <span class="text-xs text-slate-500 font-medium">UMKM Desa Kamarang</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug mb-3">
                        {{ $product->name }}
                    </h1>

                    <!-- Price Block -->
                    <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-2xl p-5 mb-6">
                        <div class="flex items-baseline gap-2 flex-wrap">
                            <span class="text-xs font-bold text-emerald-800 uppercase tracking-wide">Harga:</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-emerald-700">{{ $product->formatted_price }}</span>
                            <span class="text-sm font-semibold text-slate-500">/ {{ $product->unit }}</span>
                        </div>
                        @if($product->price_max && $product->price_max > $product->price)
                            <p class="text-[11px] text-emerald-800/80 mt-1.5 font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-info text-[10px]"></i>
                                Estimasi rentang harga bergantung pada varian rasa, ukuran kemasan, atau jumlah pesanan.
                            </p>
                        @endif
                    </div>

                    <!-- Variants Selection (If Available) -->
                    @if($product->has_variants)
                        <div class="mb-6 bg-slate-50 border border-slate-200 p-5 rounded-2xl" x-data="{ 
                            selectedVariant: '{{ $product->variants[0] ?? '' }}',
                            phone: '{{ $product->umkm->clean_phone ?? '' }}',
                            productName: '{{ addslashes($product->name) }}',
                            sellerName: '{{ addslashes($product->umkm->name ?? '') }}',
                            priceFormatted: '{{ $product->formatted_price }}',
                            unit: '{{ $product->unit ? '/' . $product->unit : '' }}',
                            getWaLink() {
                                if (!this.phone) return '#';
                                const variantText = this.selectedVariant ? ' (Varian: ' + this.selectedVariant + ')' : '';
                                const msg = 'Halo ' + this.sellerName + ', saya tertarik dengan produk \"' + this.productName + '\"' + variantText + ' (' + this.priceFormatted + this.unit + ') di Website Katalog UMKM Desa Kamarang. Apakah produk ini masih tersedia?';
                                return 'https://wa.me/' + this.phone + '?text=' + encodeURIComponent(msg);
                            }
                        }">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                    <i class="fa-solid fa-shapes text-emerald-600"></i> Pilihan Varian Produk
                                </h3>
                                <span class="text-[11px] text-emerald-700 font-semibold bg-emerald-100 px-2 py-0.5 rounded-full">
                                    {{ count($product->variants) }} Opsi
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 mb-3">Pilih varian yang Anda minati di bawah ini:</p>
                            
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->variants as $variant)
                                    <button type="button" 
                                        @click="selectedVariant = '{{ addslashes($variant) }}'; $dispatch('variant-selected', '{{ addslashes($variant) }}')"
                                        :class="selectedVariant === '{{ addslashes($variant) }}' ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-600/20' : 'bg-white text-slate-700 border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/50'"
                                        class="px-3.5 py-2 rounded-xl text-xs font-bold border transition-all flex items-center gap-1.5">
                                        <i class="fa-solid fa-check text-[10px]" x-show="selectedVariant === '{{ addslashes($variant) }}'"></i>
                                        <span>{{ $variant }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Short Description -->
                    @if($product->short_description)
                        <div class="mb-6">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Ringkasan Produk</h3>
                            <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                                {{ $product->short_description }}
                            </p>
                        </div>
                    @endif

                    <!-- Full Description -->
                    <div class="mb-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi Lengkap</h3>
                        <div class="text-sm text-slate-600 leading-relaxed space-y-2 prose prose-emerald max-w-none">
                            {!! nl2br(e($product->full_description ?? 'Belum ada deskripsi tambahan untuk produk ini.')) !!}
                        </div>
                    </div>
                </div>

                <!-- Seller Info Card & Order Action CTA -->
                <div class="space-y-4 pt-6 border-t border-slate-200" x-data="{ 
                    currentVariant: '{{ $product->variants[0] ?? '' }}',
                    phone: '{{ $product->umkm->clean_phone ?? '' }}',
                    productName: '{{ addslashes($product->name) }}',
                    sellerName: '{{ addslashes($product->umkm->name ?? '') }}',
                    priceFormatted: '{{ $product->formatted_price }}',
                    unit: '{{ $product->unit ? '/' . $product->unit : '' }}',
                    get currentWaUrl() {
                        if (!this.phone) return '#';
                        const vText = this.currentVariant ? ' (Varian: ' + this.currentVariant + ')' : '';
                        const msg = 'Halo ' + this.sellerName + ', saya tertarik dengan produk \"' + this.productName + '\"' + vText + ' (' + this.priceFormatted + this.unit + ') di Website Katalog UMKM Desa Kamarang. Apakah produk ini masih tersedia?';
                        return 'https://wa.me/' + this.phone + '?text=' + encodeURIComponent(msg);
                    }
                }" @variant-selected.window="currentVariant = $event.detail">
                    <!-- Seller Card -->
                    @if($product->umkm)
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 overflow-hidden shadow-xs shrink-0">
                                    <img src="{{ $product->umkm->logo_url }}" alt="{{ $product->umkm->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <span class="text-xs text-slate-400 block font-medium">Diproduksi / Dijual oleh:</span>
                                    <a href="{{ route('umkm.show', $product->umkm->slug) }}" class="text-sm font-bold text-slate-900 hover:text-emerald-600 transition-colors">
                                        {{ $product->umkm->name }}
                                    </a>
                                    <div class="text-xs text-slate-500 flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-emerald-600 text-[10px]"></i>
                                        <span>{{ $product->umkm->dusun ?? 'Desa Kamarang, Kec. Greged' }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('umkm.show', $product->umkm->slug) }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-100 border border-slate-300 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                                <i class="fa-solid fa-store"></i> Kunjungi Toko
                            </a>
                        </div>
                    @endif

                    <!-- Action CTA depending on WhatsApp availability -->
                    @if($product->has_whatsapp)
                        <!-- Seller Has WhatsApp -->
                        <div class="space-y-2">
                            <a :href="currentWaUrl" target="_blank" class="w-full inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white py-4 px-6 rounded-2xl font-extrabold text-base shadow-lg shadow-emerald-600/30 transition-all hover:scale-[1.01]">
                                <i class="fa-brands fa-whatsapp text-2xl"></i>
                                <span>Pesan via WhatsApp</span>
                                <template x-if="currentVariant">
                                    <span class="text-xs bg-emerald-800/80 px-2 py-0.5 rounded-lg font-medium" x-text="'Varian: ' + currentVariant"></span>
                                </template>
                            </a>
                            <p class="text-[11px] text-center text-slate-400 font-medium">
                                Klik untuk langsung terhubung ke WhatsApp penjual dengan pesan sapaan otomatis.
                            </p>
                        </div>
                    @else
                        <!-- Seller Does NOT have WhatsApp: Direct Offline Purchase Notice -->
                        <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-5 space-y-3">
                            <div class="flex items-center gap-2.5 text-amber-900 font-bold text-sm">
                                <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm shrink-0">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <div>
                                    <span class="block">Pemesanan / Pembelian Langsung di Tempat</span>
                                    <span class="text-[11px] font-normal text-amber-800">Pelaku UMKM ini belum menggunakan kontak WhatsApp online.</span>
                                </div>
                            </div>

                            <div class="bg-white/80 p-3.5 rounded-xl border border-amber-100 text-xs text-slate-700 space-y-1.5">
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-location-dot text-emerald-600 mt-0.5"></i>
                                    <span><strong>Alamat Toko:</strong> {{ $product->umkm->address ?? 'Desa Kamarang, Kec. Greged, Kab. Cirebon' }} ({{ $product->umkm->dusun ?? 'Desa Kamarang' }})</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-user text-amber-600"></i>
                                    <span><strong>Pemilik Usaha:</strong> {{ $product->umkm->owner_name }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-2 pt-1">
                                @if($product->umkm && $product->umkm->google_maps_url)
                                    <a href="{{ $product->umkm->google_maps_url }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 px-4 rounded-xl text-xs font-bold shadow-xs transition-colors">
                                        <i class="fa-solid fa-map-location-dot"></i> Buka Google Maps
                                    </a>
                                    @if($product->umkm->has_coordinates)
                                        <a href="{{ $product->umkm->google_maps_direction_url }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-emerald-800 hover:bg-emerald-900 text-white py-2.5 px-4 rounded-xl text-xs font-bold shadow-xs transition-colors">
                                            <i class="fa-solid fa-diamond-turn-right text-emerald-300"></i> Petunjuk Arah
                                        </a>
                                    @endif
                                @endif
                                <a href="{{ route('umkm.show', $product->umkm->slug) }}" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 py-2.5 px-4 rounded-xl text-xs font-bold transition-colors">
                                    <i class="fa-solid fa-store"></i> Lihat Profil UMKM
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">Produk Serupa Lainnya</h2>
                    <p class="text-xs text-slate-500">Pilihan produk lain dalam kategori yang sama.</p>
                </div>
                <a href="{{ route('catalog.index', ['category' => $product->category->slug ?? '']) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                    <span>Lihat Kategori</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between card-hover group">
                        <div>
                            <div class="relative aspect-square overflow-hidden bg-slate-100">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-3 right-3">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md border {{ $rel->stock_status_badge_class }}">
                                        {{ $rel->stock_status_label }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-1 mb-1">
                                    <a href="{{ route('catalog.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h3>
                                <p class="text-xs font-extrabold text-emerald-700">{{ $rel->formatted_price }} <span class="text-[10px] text-slate-400 font-normal">/{{ $rel->unit }}</span></p>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            @if($rel->has_whatsapp)
                                <a href="{{ $rel->whatsapp_order_url }}" target="_blank" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold transition-colors">
                                    <i class="fa-brands fa-whatsapp text-sm text-emerald-600"></i> Chat WA
                                </a>
                            @else
                                <a href="{{ route('catalog.show', $rel->slug) }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                                    <i class="fa-solid fa-circle-info text-emerald-600"></i> Detail & Lokasi
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
