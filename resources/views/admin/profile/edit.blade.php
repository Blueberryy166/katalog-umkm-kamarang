@extends('layouts.admin')

@section('title', 'Pengaturan Akun Pengelola')
@section('page_title', 'Pengaturan Akun Pengelola')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Profil & Keamanan Akun</h2>
            <p class="text-xs text-slate-500">Perbarui identitas administrator dan ganti password login.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs space-y-1">
            <span class="font-bold block">Terdapat kesalahan:</span>
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Administrator <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Login <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div class="pt-4 border-t border-slate-100 space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Ganti Password (Opsional)</h3>
                <p class="text-[11px] text-slate-500">Biarkan kosong jika tidak ingin mengubah password saat ini.</p>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Saat Ini</label>
                    <input type="password" name="current_password" placeholder="••••••••" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Baru</label>
                    <input type="password" name="new_password" placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" placeholder="Ulangi password baru" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
