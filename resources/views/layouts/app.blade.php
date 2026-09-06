<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'Katalog & Pemasaran Digital UMKM Desa Kamarang') - KKM UMC 2026</title>
    <meta name="description" content="@yield('meta_description', 'Platform resmi etalase katalog dan promosi digital produk unggulan UMKM Desa Kamarang, Kecamatan Greged, Kabupaten Cirebon. Program KKM Kelompok 26 Universitas Muhammadiyah Cirebon 2026.')">
    <meta name="keywords" content="UMKM Desa Kamarang, Katalog UMKM Kamarang, Greged Cirebon, KKM UMC 2026, Oleh-oleh Khas Kamarang, Produk Desa Cirebon">
    <meta name="author" content="Khotibul Umam - KKM Kelompok 26 UMC">

    <!-- Open Graph / WhatsApp Sharing Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Katalog & Pemasaran Digital UMKM Desa Kamarang')">
    <meta property="og:description" content="@yield('meta_description', 'Temukan aneka produk olahan, camilan renyah, kerajinan, dan produk unggulan warga Desa Kamarang, Kec. Greged, Cirebon.')">
    <meta property="og:image" content="@yield('og_image', asset('images/banners/hero_village.jpg'))">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS CDN Fallback & Compiled Assets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        },
                        amber: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .card-hover { transition: all 0.25s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 24px -6px rgba(5, 150, 105, 0.15); }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-emerald-500 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white text-xs py-2 px-4 border-b border-emerald-700/50">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <span class="bg-amber-500 text-slate-950 font-bold px-2 py-0.5 rounded-full text-[10px] tracking-wide uppercase">KKM UMC 2026</span>
                <span class="text-emerald-100 font-medium">Program Kerja Digitalisasi & Branding UMKM Desa Kamarang - Kelompok 26</span>
            </div>
            <div class="flex items-center gap-3 text-emerald-200">
                <span class="flex items-center gap-1.5 font-medium">
                    <i class="fa-solid fa-location-dot text-amber-400"></i> Desa Kamarang, Kec. Greged
                </span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo & Brand Title -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 flex items-center justify-center text-white shadow-md shadow-emerald-600/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-store text-xl"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-extrabold text-slate-900 tracking-tight">Katalog UMKM</span>
                            <span class="text-xs font-semibold px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-md">Kamarang</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">Kec. Greged, Kab. Cirebon</p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-50' }}">
                        Beranda
                    </a>
                    <a href="{{ route('catalog.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('catalog.*') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-50' }}">
                        Katalog Produk
                    </a>
                    <a href="{{ route('umkm.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('umkm.*') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-50' }}">
                        Direktori UMKM
                    </a>
                    <a href="{{ route('contact.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('contact.*') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-50' }}">
                        Kontak
                    </a>
                </nav>

                <!-- Action Button & Search Trigger -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl font-semibold text-sm shadow-md shadow-emerald-600/20 hover:shadow-emerald-600/30 transition-all">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span>Belanja Produk</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center gap-2 md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2.5 rounded-xl text-slate-700 hover:bg-slate-100 focus:outline-none" aria-label="Menu">
                        <i class="fa-solid text-xl" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2 shadow-lg">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-house w-6 text-emerald-600"></i> Beranda
            </a>
            <a href="{{ route('catalog.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('catalog.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-boxes-stacked w-6 text-emerald-600"></i> Katalog Produk
            </a>
            <a href="{{ route('umkm.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('umkm.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-store w-6 text-emerald-600"></i> Direktori UMKM
            </a>
            <a href="{{ route('contact.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('contact.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-envelope w-6 text-emerald-600"></i> Hubungi Kami
            </a>
        </div>
    </header>

    <!-- Flash Messages / Notifications -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-xs" x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-xs" x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-600 hover:text-rose-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-24 md:pb-12 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Column 1: Info Desa & KKM -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <div>
                            <span class="text-lg font-bold text-white tracking-tight">Katalog UMKM</span>
                            <span class="text-xs block text-emerald-400 font-semibold">Desa Kamarang</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Platform e-katalog dan promosi digital produk usaha mikro, kecil, dan menengah di Desa Kamarang, Kecamatan Greged, Kabupaten Cirebon, Jawa Barat.
                    </p>
                    <div class="bg-slate-800/80 p-3 rounded-xl border border-slate-700/60 text-xs text-slate-300">
                        <span class="text-amber-400 font-semibold block mb-1">KKM Kelompok 26 UMC 2026</span>
                        <span>Universitas Muhammadiyah Cirebon<br>Penulis: <strong>Khotibul Umam</strong> (230511122)</span>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">Navigasi Cepat</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-emerald-500"></i> Beranda</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-emerald-500"></i> Semua Produk UMKM</a></li>
                        <li><a href="{{ route('umkm.index') }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-emerald-500"></i> Direktori Pelaku Usaha</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-emerald-500"></i> Kontak & Pengaduan</a></li>
                    </ul>
                </div>

                <!-- Column 3: Kategori Populer -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">Kategori Produk</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('catalog.index', ['category' => 'makanan-ringan']) }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-cookie-bite text-xs text-amber-400"></i> Makanan Ringan</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'olahan-pangan']) }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-bowl-rice text-xs text-amber-400"></i> Olahan Pangan</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'minuman']) }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-glass-water text-xs text-amber-400"></i> Minuman</a></li>
                    </ul>
                </div>

                <!-- Column 4: Kontak Kantor Desa -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">Kantor Desa Kamarang</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-emerald-400 mt-1"></i>
                            <span>Desa Kamarang, Kec. Greged, Kab. Cirebon, Jawa Barat 45181</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                            <a href="https://wa.me/6282119876543" target="_blank" class="hover:text-emerald-400">0821-1987-6543</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-emerald-400"></i>
                            <span>desakamarang.greged@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="mt-12 pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Website Katalog UMKM Desa Kamarang. Dikelola oleh Tim KKM UMC 2026 & Pemerintah Desa Kamarang.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('contact.index') }}" class="hover:text-slate-300">Kontak & Pelayanan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Sticky Navigation Bar -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200 px-2 py-1.5 shadow-2xl flex justify-around items-center">
        <a href="{{ route('home') }}" class="flex flex-col items-center py-1 px-2 rounded-lg text-xs font-medium {{ request()->routeIs('home') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-house text-base mb-0.5"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('catalog.index') }}" class="flex flex-col items-center py-1 px-2 rounded-lg text-xs font-medium {{ request()->routeIs('catalog.*') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-boxes-stacked text-base mb-0.5"></i>
            <span>Katalog</span>
        </a>
        <a href="{{ route('umkm.index') }}" class="flex flex-col items-center py-1 px-2 rounded-lg text-xs font-medium {{ request()->routeIs('umkm.*') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-store text-base mb-0.5"></i>
            <span>UMKM</span>
        </a>
        <a href="{{ route('contact.index') }}" class="flex flex-col items-center py-1 px-2 rounded-lg text-xs font-medium {{ request()->routeIs('contact.*') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-envelope text-base mb-0.5"></i>
            <span>Kontak</span>
        </a>
    </div>

    @stack('scripts')
</body>
</html>
