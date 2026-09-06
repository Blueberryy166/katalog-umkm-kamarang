@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')
@section('page_title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('admin.products.index') }}" class="hover:text-emerald-600">Daftar Produk</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-700 font-bold">Tambah Baru</span>
            </nav>
            <h2 class="text-xl font-extrabold text-slate-900">Formulir Tambah Produk</h2>
        </div>
        <a href="{{ route('admin.products.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs space-y-1">
            <span class="font-bold block">Terdapat kesalahan pengisian data:</span>
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- UMKM Pemilik -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">UMKM Pemilik / Penjual <span class="text-rose-500">*</span></label>
                <select name="umkm_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">-- Pilih Toko UMKM --</option>
                    @foreach($umkms as $u)
                        <option value="{{ $u->id }}" {{ old('umkm_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->owner_name }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Produk <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Produk -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Produk <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Keripik Singkong Pedas Manis Balado" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- Harga Minimum / Dasar -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Harga Dasar / Minimum (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" name="price" value="{{ old('price') }}" required min="0" step="100" placeholder="Contoh: 10000" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                <p class="text-[11px] text-slate-500 mt-1">Harga satuan atau harga batas bawah produk.</p>
            </div>

            <!-- Harga Maksimum / Rentang Estimasi -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700">Harga Maksimum / Estimasi (Rp)</label>
                    <span class="text-[10px] text-slate-400 font-semibold bg-slate-100 px-2 py-0.5 rounded-md">Opsional</span>
                </div>
                <input type="number" name="price_max" value="{{ old('price_max') }}" min="0" step="100" placeholder="Contoh: 20000" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                <p class="text-[11px] text-slate-500 mt-1">Isi jika harga berupa rentang (contoh: <strong>Rp 10.000 - Rp 20.000</strong>). Kosongkan jika harga pas.</p>
            </div>

            <!-- Satuan Kemasan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Satuan / Kemasan <span class="text-rose-500">*</span></label>
                <input type="text" name="unit" value="{{ old('unit', 'pouch 250gr') }}" required placeholder="pouch 250gr, toples 300gr, pack, kg, pcs" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- Status Stok -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Ketersediaan <span class="text-rose-500">*</span></label>
                <select name="stock_status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="available" {{ old('stock_status') == 'available' ? 'selected' : '' }}>Tersedia (Ready Stock)</option>
                    <option value="preorder" {{ old('stock_status') == 'preorder' ? 'selected' : '' }}>Pre-Order</option>
                    <option value="out_of_stock" {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                </select>
            </div>

            <!-- Varian Produk (Rasa, Ukuran, Kemasan) -->
            <div class="sm:col-span-2 bg-slate-50 p-5 rounded-2xl border border-slate-200" x-data="{ 
                variants: {{ json_encode(old('variants', [])) ?: '[]' }}, 
                newVariant: '',
                addVariant(text = null) {
                    const val = (text || this.newVariant).trim();
                    if (val && !this.variants.includes(val)) {
                        this.variants.push(val);
                        this.newVariant = '';
                    }
                },
                removeVariant(index) {
                    this.variants.splice(index, 1);
                }
            }">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-900">Opsi Varian Produk (Rasa, Ukuran, Kemasan)</label>
                        <p class="text-[11px] text-slate-500">Tambahkan beberapa variasi produk yang dapat dipilih oleh pembeli.</p>
                    </div>
                    <span class="text-[10px] text-slate-400 font-semibold bg-white border border-slate-200 px-2 py-0.5 rounded-md">Opsional</span>
                </div>

                <!-- Input & Add Button -->
                <div class="flex gap-2 mb-3">
                    <input type="text" x-model="newVariant" @keydown.enter.prevent="addVariant()" placeholder="Ketik nama varian (contoh: Original, Pedas Manis, Ukuran 500gr)..." class="flex-1 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    <button type="button" @click="addVariant()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-colors shrink-0 flex items-center gap-1.5">
                        <i class="fa-solid fa-plus text-xs"></i> Tambah
                    </button>
                </div>

                <!-- Quick Suggestion Tags -->
                <div class="flex flex-wrap items-center gap-1.5 mb-3 text-[11px] text-slate-500">
                    <span class="font-medium text-slate-400">Saran Cepat:</span>
                    <button type="button" @click="addVariant('Original')" class="px-2 py-0.5 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 rounded-md transition-colors">+ Original</button>
                    <button type="button" @click="addVariant('Pedas Manis')" class="px-2 py-0.5 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 rounded-md transition-colors">+ Pedas Manis</button>
                    <button type="button" @click="addVariant('Balado')" class="px-2 py-0.5 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 rounded-md transition-colors">+ Balado</button>
                    <button type="button" @click="addVariant('Keju')" class="px-2 py-0.5 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 rounded-md transition-colors">+ Keju</button>
                    <button type="button" @click="addVariant('Kemasan 250gr')" class="px-2 py-0.5 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 rounded-md transition-colors">+ 250gr</button>
                    <button type="button" @click="addVariant('Kemasan 500gr')" class="px-2 py-0.5 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 rounded-md transition-colors">+ 500gr</button>
                    <button type="button" @click="addVariant('Kemasan 1kg')" class="px-2 py-0.5 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 rounded-md transition-colors">+ 1kg</button>
                </div>

                <!-- Variant List Container -->
                <div class="flex flex-wrap gap-2 min-h-[36px] p-2 bg-white border border-slate-200 rounded-xl">
                    <template x-if="variants.length === 0">
                        <span class="text-xs text-slate-400 italic self-center">Belum ada varian ditambahkan (produk merupakan varian tunggal).</span>
                    </template>
                    <template x-for="(v, index) in variants" :key="index">
                        <div class="inline-flex items-center gap-1.5 bg-emerald-50 border border-emerald-200 text-emerald-800 px-3 py-1 rounded-lg text-xs font-semibold">
                            <input type="hidden" name="variants[]" :value="v">
                            <span x-text="v"></span>
                            <button type="button" @click="removeVariant(index)" class="text-emerald-600 hover:text-rose-600 ml-1">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Nomor P-IRT / Izin Halal -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Izin P-IRT / Sertifikasi Halal</label>
                <input type="text" name="pirt_number" value="{{ old('pirt_number') }}" placeholder="Contoh: P-IRT: 2153209010123-26" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- Foto Utama -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Produk (Format: JPG, PNG, WEBP, Maks: 3MB)</label>
                <input type="file" name="main_image" accept="image/*" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
            </div>

            <!-- Deskripsi Singkat -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                <textarea name="short_description" rows="2" placeholder="Ringkasan singkat produk dalam 1-2 kalimat..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">{{ old('short_description') }}</textarea>
            </div>

            <!-- Deskripsi Lengkap -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Lengkap / Keunggulan / Komposisi</label>
                <textarea name="full_description" rows="5" placeholder="Tuliskan komposisi bahan, rasa, keunggulan olahan, cara pemesanan atau penyimpanan..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">{{ old('full_description') }}</textarea>
            </div>

            <!-- Toggle Produk Unggulan -->
            <div class="sm:col-span-2 bg-amber-50/60 border border-amber-200 p-4 rounded-2xl flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-900 block">Jadikan Produk Unggulan Desa (Featured)?</span>
                    <span class="text-[11px] text-slate-500">Produk akan tampil di halaman depan beranda dengan badge khusus.</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all">
                Simpan Produk
            </button>
        </div>
    </form>
</div>
@endsection
