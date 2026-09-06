<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard') - CMS Katalog UMKM Kamarang</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS CDN -->
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
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Backdrop for Mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs lg:hidden" style="display: none;"></div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out flex flex-col justify-between shadow-xl">
        <div>
            <!-- Brand Header -->
            <div class="h-20 flex items-center gap-3 px-6 bg-slate-950 border-b border-slate-800">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold shadow-md shadow-emerald-500/20">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <div>
                    <span class="text-base font-bold text-white tracking-tight">Admin Katalog</span>
                    <span class="text-xs block text-emerald-400 font-semibold">Desa Kamarang</span>
                </div>
            </div>

            <!-- Nav Links -->
            <div class="px-4 py-6 space-y-1.5 overflow-y-auto max-h-[calc(100vh-10rem)]">
                <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Menu Utama</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.products.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-boxes-stacked w-5 text-center"></i>
                    <span>Kelola Produk</span>
                </a>

                <a href="{{ route('admin.umkms.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.umkms.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-store w-5 text-center"></i>
                    <span>Data UMKM</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-tags w-5 text-center"></i>
                    <span>Kategori Produk</span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Tampilan Web</div>

                <a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.sliders.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-images w-5 text-center"></i>
                    <span>Banner Slider</span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Bantuan & Akun</div>

                <a href="{{ route('admin.guide.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.guide.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-amber-400 hover:bg-slate-800 hover:text-amber-300' }}">
                    <i class="fa-solid fa-book-open-reader w-5 text-center text-amber-400"></i>
                    <span>Panduan Pengelolaan</span>
                </a>

                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.profile.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-gear w-5 text-center"></i>
                    <span>Akun Pengelola</span>
                </a>
            </div>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 bg-slate-950/80 border-t border-slate-800 text-xs">
            <div class="flex items-center justify-between text-slate-400">
                <span class="truncate">{{ Auth::user()->name ?? 'Administrator' }}</span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Logout" class="text-rose-400 hover:text-rose-300 transition-colors p-1">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Admin Content Area -->
    <div class="flex-1 flex flex-col min-h-screen lg:pl-64">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 shadow-xs">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 lg:hidden">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg sm:text-xl font-extrabold text-slate-900">@yield('page_title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-500">Panel CMS Pengelolaan Katalog UMKM Desa Kamarang</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors border border-emerald-200">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span class="hidden sm:inline">Lihat Website</span>
                </a>

                <div class="flex items-center gap-2 pl-3 border-l border-slate-200">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <span class="text-xs font-bold text-slate-900 block leading-tight">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <span class="text-[10px] text-emerald-600 font-semibold">Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mx-4 sm:mx-8 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl flex items-center justify-between shadow-xs" x-data="{ show: true }" x-show="show">
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
            <div class="mx-4 sm:mx-8 mt-6">
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl flex items-center justify-between shadow-xs" x-data="{ show: true }" x-show="show">
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

        <!-- Main Workspace -->
        <main class="p-4 sm:p-8 flex-1">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
