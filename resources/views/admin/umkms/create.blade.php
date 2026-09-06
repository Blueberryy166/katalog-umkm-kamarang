@extends('layouts.admin')

@section('title', 'Tambah UMKM Baru')
@section('page_title', 'Tambah Pelaku UMKM')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('admin.umkms.index') }}" class="hover:text-emerald-600">Daftar UMKM</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-700 font-bold">Tambah Baru</span>
            </nav>
            <h2 class="text-xl font-extrabold text-slate-900">Formulir Data UMKM</h2>
        </div>
        <a href="{{ route('admin.umkms.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.umkms.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Nama Usaha -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Usaha / Toko <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: UMKM Keripik Ibu Siti" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- Nama Pemilik -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Pemilik Usaha <span class="text-rose-500">*</span></label>
                <input type="text" name="owner_name" value="{{ old('owner_name') }}" required placeholder="Contoh: Ibu Siti Rohanah" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- No WhatsApp -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp</label>
                    <span class="text-[10px] text-slate-400 font-semibold bg-slate-100 px-2 py-0.5 rounded-md">Opsional</span>
                </div>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 082119876543 (Kosongkan jika tidak ada)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                <p class="text-[11px] text-slate-500 mt-1">Kosongkan jika UMKM belum memiliki WhatsApp. Pembeli akan diarahkan membeli langsung di tempat / lokasi toko.</p>
            </div>

            <!-- Dusun -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Dusun / Blok Wilayah di Desa Kamarang</label>
                <input type="text" name="dusun" value="{{ old('dusun') }}" placeholder="Contoh: Dusun Manis, Dusun Pahing, Dusun Kliwon, Dusun Wage" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- Alamat Lengkap -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lengkap Usaha</label>
                <input type="text" name="address" value="{{ old('address') }}" placeholder="Jl. Desa Kamarang RT 02 / RW 01, Dusun Manis, Desa Kamarang" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- Integrasi Titik Lokasi Peta (Latitude & Longitude) -->
            <div class="sm:col-span-2 bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-emerald-600 text-sm"></i>
                            <label class="block text-xs font-bold text-slate-900">Titik Koordinat Lokasi UMKM (Google Maps)</label>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-0.5">Klik pada peta atau geser pin untuk menentukan titik lokasi toko secara akurat.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" id="btn-center-kamarang" class="px-3 py-1.5 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 border border-slate-200 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1.5">
                            <i class="fa-solid fa-landmark text-emerald-600"></i> Desa Kamarang
                        </button>
                        <button type="button" id="btn-detect-gps" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5 shadow-xs">
                            <i class="fa-solid fa-location-crosshairs"></i> Lokasi GPS Saya
                        </button>
                    </div>
                </div>

                <!-- Input Koordinat Lat & Lng -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Latitude (Garis Lintang)</label>
                        <input type="text" id="latitude" name="latitude" value="{{ old('latitude', '-6.84667744') }}" placeholder="-6.84667744" class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Longitude (Garis Bujur)</label>
                        <input type="text" id="longitude" name="longitude" value="{{ old('longitude', '108.54561525') }}" placeholder="108.54561525" class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                </div>

                <!-- Interactive Map Container -->
                <div class="rounded-xl overflow-hidden border border-slate-200 shadow-inner bg-slate-200 relative">
                    <div id="map-picker" style="height: 280px; width: 100%; z-index: 10;"></div>
                </div>

                <!-- Tautan Google Maps Manual / Otomatis -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Link Google Maps (Opsional / Terisi Otomatis)</label>
                    <input type="text" id="maps_url" name="maps_url" value="{{ old('maps_url') }}" placeholder="https://maps.google.com/?q=..." class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    <p class="text-[10px] text-slate-400 mt-1">Jika dikosongkan, tautan Google Maps akan otomatis dibuat dari koordinat Latitude & Longitude.</p>
                </div>
            </div>

            <!-- Logo / Foto Toko -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Toko / Logo Usaha (JPG/PNG, Maks: 3MB)</label>
                <input type="file" name="logo_image" accept="image/*" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
            </div>

            <!-- Deskripsi Usaha -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Profil Usaha</label>
                <textarea name="description" rows="4" placeholder="Ceritakan produk yang diproduksi, keunggulan bahan baku, sejarah singkat usaha, jam operasional..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">{{ old('description') }}</textarea>
            </div>

            <!-- Status Aktif -->
            <div class="sm:col-span-2 bg-slate-50 p-4 rounded-2xl flex items-center justify-between border border-slate-200">
                <div>
                    <span class="text-xs font-bold text-slate-900 block">Status Toko Aktif</span>
                    <span class="text-[11px] text-slate-500">Toko dan produknya akan tampil secara publik di website.</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.umkms.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all">
                Simpan UMKM
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const defaultLat = parseFloat(document.getElementById('latitude').value) || -6.84667744;
        const defaultLng = parseFloat(document.getElementById('longitude').value) || 108.54561525;

        const map = L.map('map-picker').setView([defaultLat, defaultLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        function updateInputs(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);
            document.getElementById('maps_url').value = `https://www.google.com/maps?q=${lat.toFixed(8)},${lng.toFixed(8)}`;
        }

        marker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            updateInputs(pos.lat, pos.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });

        // Center on Desa Kamarang button
        document.getElementById('btn-center-kamarang').addEventListener('click', function() {
            const lat = -6.84667744;
            const lng = 108.54561525;
            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);
            updateInputs(lat, lng);
        });

        // GPS Geolocation button
        document.getElementById('btn-detect-gps').addEventListener('click', function() {
            if (navigator.geolocation) {
                const btn = this;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mendeteksi...';
                navigator.geolocation.getCurrentPosition(function(pos) {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    map.setView([lat, lng], 17);
                    marker.setLatLng([lat, lng]);
                    updateInputs(lat, lng);
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Lokasi Terdeteksi';
                    setTimeout(() => {
                        btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Lokasi GPS Saya';
                    }, 3000);
                }, function(err) {
                    alert('Gagal mendeteksi lokasi GPS: ' + err.message);
                    btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Lokasi GPS Saya';
                }, { enableHighAccuracy: true });
            } else {
                alert('Browser Anda tidak mendukung fitur Geolocation.');
            }
        });

        // Manual Input Change listener
        function syncMapFromInputs() {
            const lat = parseFloat(document.getElementById('latitude').value);
            const lng = parseFloat(document.getElementById('longitude').value);
            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                marker.setLatLng([lat, lng]);
                map.panTo([lat, lng]);
            }
        }
        document.getElementById('latitude').addEventListener('input', syncMapFromInputs);
        document.getElementById('longitude').addEventListener('input', syncMapFromInputs);
    });
</script>
@endpush
