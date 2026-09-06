<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - CMS Katalog UMKM Desa Kamarang</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 sm:p-10 relative z-10 border border-slate-100">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex items-center justify-center mx-auto text-2xl mb-4 shadow-lg shadow-emerald-600/20">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Login Pengelola</h1>
            <p class="text-xs text-slate-500 mt-1">CMS Katalog UMKM Desa Kamarang</p>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email Administrator</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="email" name="email" required class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <i class="fa-solid fa-key absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-600 pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3.5 px-4 rounded-xl text-sm shadow-md shadow-emerald-600/30 transition-all hover:scale-[1.01] mt-2">
                Masuk ke Panel Admin
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <a href="{{ route('home') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Website Utama</span>
            </a>
        </div>
    </div>
</body>
</html>
