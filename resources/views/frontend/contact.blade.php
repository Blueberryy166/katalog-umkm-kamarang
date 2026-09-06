@extends('layouts.app')

@section('title', 'Kontak & Bantuan - UMKM Desa Kamarang')

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <nav class="flex items-center justify-center sm:justify-start gap-2 text-xs text-emerald-300 mb-2">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-white font-bold">Kontak & Layanan</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Hubungi Pengelola & Kantor Desa</h1>
        <p class="text-sm text-emerald-100 mt-1">Kami siap membantu pertanyaan seputar produk UMKM, pemesanan, maupun kemitraan.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left: Contact Details -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-xs space-y-6">
                <h2 class="text-xl font-extrabold text-slate-900">Informasi Kantor Desa</h2>
                
                <div class="space-y-4 text-sm text-slate-600">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block text-xs uppercase tracking-wide text-slate-400">Alamat</span>
                            <span>Kantor Kepala Desa Kamarang, Kecamatan Greged, Kabupaten Cirebon, Jawa Barat 45181</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block text-xs uppercase tracking-wide text-slate-400">WhatsApp Pelayanan</span>
                            <a href="https://wa.me/6282119876543" target="_blank" class="text-emerald-700 font-bold hover:underline">0821-1987-6543</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block text-xs uppercase tracking-wide text-slate-400">Email Resmi</span>
                            <span>desakamarang.greged@gmail.com</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block text-xs uppercase tracking-wide text-slate-400">Tim KKM Pendamping</span>
                            <span>KKM Kelompok 26 Universitas Muhammadiyah Cirebon 2026</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fast WhatsApp Banner -->
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white rounded-3xl p-6 shadow-md flex items-center justify-between">
                <div>
                    <h3 class="font-extrabold text-sm mb-1">Punya Usaha di Kamarang?</h3>
                    <p class="text-xs text-emerald-100">Daftarkan produk UMKM Anda ke katalog desa secara gratis.</p>
                </div>
                <a href="https://wa.me/6282119876543?text=Halo%20Admin,%20saya%20warga%20Desa%20Kamarang%20ingin%20mendaftarkan%20produk%20UMKM%20ke%20website" target="_blank" class="px-4 py-2.5 bg-white text-slate-950 rounded-xl text-xs font-bold shrink-0 hover:bg-emerald-50 transition-colors shadow-xs">
                    Daftar Sekarang
                </a>
            </div>
        </div>

        <!-- Right: Message Form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-xs">
                <h2 class="text-xl font-extrabold text-slate-900 mb-2">Kirim Pesan / Masukan</h2>
                <p class="text-xs text-slate-500 mb-6">Sampaikan pesan, masukan, atau pertanyaan Anda kepada tim pengelola website desa.</p>

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone" required placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Subjek Pesan <span class="text-rose-500">*</span></label>
                        <input type="text" name="subject" required placeholder="Contoh: Pertanyaan Produk / Kerjasama Toko" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Isi Pesan <span class="text-rose-500">*</span></label>
                        <textarea name="message" rows="4" required placeholder="Tuliskan pesan Anda secara jelas di sini..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl text-sm shadow-md shadow-emerald-600/20 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Pesan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
