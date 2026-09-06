@extends('layouts.admin')

@section('title', 'Buku Panduan Pengelolaan Website')
@section('page_title', 'Panduan Pengelolaan Mandiri')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header Card -->
    <div class="bg-gradient-to-br from-amber-500 via-amber-600 to-emerald-700 text-white rounded-3xl p-6 sm:p-8 shadow-sm">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-12 h-12 rounded-2xl bg-white/20 text-white flex items-center justify-center text-2xl backdrop-blur-xs">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider bg-white/20 px-2.5 py-0.5 rounded-full">Modul Pelatihan Mandiri</span>
                <h2 class="text-2xl font-extrabold tracking-tight">Panduan Pengelolaan Website UMKM Desa Kamarang</h2>
            </div>
        </div>
        <p class="text-xs sm:text-sm text-amber-50 leading-relaxed max-w-2xl">
            Modul panduan praktis ini disusun oleh <strong>Khotibul Umam</strong> (KKM Kelompok 26 Universitas Muhammadiyah Cirebon 2026) untuk memandu perangkat desa dan pengelola dalam mengoperasikan website katalog secara mandiri dan berkelanjutan.
        </p>
    </div>

    <!-- Steps & Guides -->
    <div class="space-y-6">
        <!-- Step 1 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">
                    1
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Cara Mendaftarkan Pelaku UMKM Baru</h3>
            </div>
            <div class="text-xs text-slate-600 leading-relaxed space-y-2 pl-11">
                <p>1. Buka menu <strong>Data UMKM</strong> pada menu navigasi samping sebelah kiri.</p>
                <p>2. Klik tombol hijau <strong>+ Tambah UMKM Baru</strong> di pojok kanan atas.</p>
                <p>3. Isi formulir data:
                    <ul class="list-disc pl-5 mt-1 space-y-1 text-slate-500">
                        <li><strong>Nama Usaha/Toko</strong>: Nama merek atau usaha rumahan (contoh: <em>UMKM Keripik Ibu Siti</em>).</li>
                        <li><strong>Nama Pemilik</strong>: Nama penanggung jawab/pembuat produk.</li>
                        <li><strong>Nomor WhatsApp (Opsional)</strong>: Masukkan nomor HP aktif jika ada (format: <code>08xxxxxxxxxx</code>). <em>Jika UMKM belum memiliki WhatsApp, kosongkan kolom ini. Sistem akan otomatis mengarahkan pembeli untuk datang langsung ke alamat toko.</em></li>
                        <li><strong>Dusun & Alamat Lengkap</strong>: Lokasi dusun di Desa Kamarang (Manis, Pahing, Kliwon, atau Wage).</li>
                        <li><strong>Titik Koordinat Google Maps (Latitude & Longitude)</strong>:
                            <div class="mt-1 pl-2 text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                                <em>Cara mudah menentukan titik peta:</em>
                                <ul class="list-circle pl-4 mt-1 space-y-0.5 text-[11px] text-slate-500">
                                    <li>Klik tombol <strong>"Lokasi GPS Saya"</strong> saat Anda sedang berada di lokasi toko untuk mendeteksi koordinat secara otomatis.</li>
                                    <li>Atau klik langsung pada kotak peta interaktif dan geser pin penunjuk lokasi ke titik toko yang tepat.</li>
                                    <li>Nilai Latitude, Longitude, dan Tautan Google Maps akan otomatis terisi secara akurat.</li>
                                </ul>
                            </div>
                        </li>
                        <li><strong>Foto Toko / Logo</strong>: Upload foto usaha atau logo (opsional).</li>
                    </ul>
                </p>
                <p>4. Klik tombol <strong>Simpan UMKM</strong>. Toko kini siap diisi dengan produk-produk buatannya.</p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">
                    2
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Cara Menambahkan Produk, Varian & Estimasi Rentang Harga</h3>
            </div>
            <div class="text-xs text-slate-600 leading-relaxed space-y-2 pl-11">
                <p>1. Buka menu <strong>Kelola Produk</strong> lalu klik <strong>+ Tambah Produk Baru</strong>.</p>
                <p>2. Pilih <strong>UMKM Pemilik</strong> dan <strong>Kategori Produk</strong> yang sesuai.</p>
                <p>3. Pengaturan Harga & Rentang Estimasi:
                    <ul class="list-disc pl-5 mt-1 space-y-1 text-slate-500">
                        <li><strong>Harga Dasar / Minimum (Rp)</strong>: Masukkan harga satuan atau harga terendah (contoh: <code>10000</code>).</li>
                        <li><strong>Harga Maksimum / Estimasi (Rp)</strong>: Kosongkan jika harga pas. Isi jika harga berupa rentang (contoh: <code>20000</code>). Di website akan tampil sebagai <strong>Rp 10.000 - Rp 20.000</strong>.</li>
                    </ul>
                </p>
                <p>4. Pengaturan Pilihan Varian Produk:
                    <ul class="list-disc pl-5 mt-1 space-y-1 text-slate-500">
                        <li>Gunakan kotak <strong>Opsi Varian Produk</strong> untuk menambahkan pilihan rasa (Original, Pedas, Balado, Keju) atau ukuran kemasan (250gr, 500gr, 1kg).</li>
                        <li>Klik saran cepat atau ketik varian lalu tekan tombol <strong>Tambah</strong>.</li>
                        <li>Pembeli di katalog dapat mengklik varian pilihan dan pesan WhatsApp otomatis akan menyertakan varian tersebut.</li>
                    </ul>
                </p>
                <p>5. Masukkan <strong>Satuan Kemasan</strong> (contoh: <em>pouch 250gr</em>), <strong>Nomor Izin P-IRT / Halal</strong>, dan upload <strong>Foto Produk</strong> yang menarik.</p>
                <p>6. Klik <strong>Simpan Produk</strong>. Produk langsung otomatis terbit dan dapat diakses pembeli.</p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">
                    3
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Alur Pemesanan Calon Pembeli (Online WA & Pembelian Langsung)</h3>
            </div>
            <div class="text-xs text-slate-600 leading-relaxed space-y-2 pl-11">
                <p>1. <strong>Untuk UMKM yang Memiliki WhatsApp:</strong> Pembeli memilih varian dan menekan tombol hijau <strong>"Pesan via WhatsApp"</strong>. WhatsApp pembeli langsung terbuka otomatis dengan draft pesan berisi nama produk, varian, dan harga.</p>
                <p>2. <strong>Untuk UMKM yang Tidak Memiliki WhatsApp:</strong> Website akan menampilkan kotak petunjuk <strong>"Pemesanan Langsung di Tempat"</strong> lengkap dengan alamat dusun, nama pemilik, dan tombol rute Google Maps agar pembeli dapat berkunjung langsung.</p>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">
                    4
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Akses Login Admin Pengelola Terproteksi</h3>
            </div>
            <div class="text-xs text-slate-600 leading-relaxed space-y-2 pl-11">
                <p>1. Tautan login admin sengaja <strong>disembunyikan dari pengunjung umum</strong> agar tampilan website lebih bersih dan profesional.</p>
                <p>2. Pengelola dapat masuk ke panel admin kapan saja dengan mengetik URL <code>/admin</code> di address bar peramban (browser) Anda (contoh: <code>http://nama-website.desa.id/admin</code>).</p>
                <p>3. Masukkan email dan kata sandi akun administrator untuk mengelola data katalog.</p>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">
                    5
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Keamanan Akun Pengelola & Pengaturan Banner</h3>
            </div>
            <div class="text-xs text-slate-600 leading-relaxed space-y-2 pl-11">
                <p>1. Menu <strong>Banner Slider</strong> digunakan untuk memperbarui spanduk visual promosi atau pengumuman produk UMKM di bagian paling atas halaman beranda.</p>
                <p>2. Menu <strong>Akun Pengelola</strong> digunakan untuk mengganti nama administrator, email, serta mengganti kata sandi (password) login secara berkala demi menjaga keamanan data katalog.</p>
            </div>
        </div>
    </div>
</div>
@endsection
