@extends('layouts.admin')

@section('title', 'Kategori Produk')
@section('page_title', 'Kelola Kategori Produk')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8" x-data="{ editMode: false, editId: null, editName: '', editDesc: '', editIcon: '' }">
    <!-- Left: Add/Edit Category Form -->
    <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 h-fit">
        <h2 class="text-base font-extrabold text-slate-900 mb-1" x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori Baru'">Tambah Kategori Baru</h2>
        <p class="text-xs text-slate-500 mb-6" x-text="editMode ? 'Ubah informasi kelompok kategori produk.' : 'Kelompokkan produk UMKM agar mudah dicari.'">Kelompokkan produk UMKM agar mudah dicari.</p>

        <!-- Form Store -->
        <form :action="editMode ? '{{ url('admin/categories') }}/' + editId : '{{ route('admin.categories.store') }}'" method="POST" class="space-y-4">
            @csrf
            <template x-if="editMode">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                <input type="text" name="name" x-model="editName" required placeholder="Contoh: Makanan Ringan & Camilan" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Ikon Kategori (FontAwesome class atau kata kunci)</label>
                <input type="text" name="icon" x-model="editIcon" placeholder="cookie, wheat, coffee, palette" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                <textarea name="description" x-model="editDesc" rows="3" placeholder="Penjelasan singkat kategori..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"></textarea>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs shadow-xs transition-colors" x-text="editMode ? 'Simpan Perubahan' : 'Tambah Kategori'">
                    Tambah Kategori
                </button>
                <button type="button" x-show="editMode" @click="editMode = false; editId = null; editName = ''; editDesc = ''; editIcon = '';" class="px-4 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Right: Categories List Table -->
    <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <h2 class="text-base font-extrabold text-slate-900 mb-1">Daftar Kategori Aktif</h2>
        <p class="text-xs text-slate-500 mb-6">Total terdapat {{ $categories->count() }} kelompok kategori.</p>

        <div class="divide-y divide-slate-100">
            @forelse($categories as $cat)
                <div class="py-4 flex items-center justify-between gap-4 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base shrink-0">
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
                            <span class="text-sm font-bold text-slate-900 block">{{ $cat->name }}</span>
                            <span class="text-xs text-slate-400 block line-clamp-1">{{ $cat->description ?? 'Tidak ada deskripsi' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-emerald-800 bg-emerald-100 px-2.5 py-1 rounded-full whitespace-nowrap">
                            {{ $cat->products_count }} Produk
                        </span>
                        <button type="button" @click="editMode = true; editId = '{{ $cat->id }}'; editName = '{{ addslashes($cat->name) }}'; editDesc = '{{ addslashes($cat->description) }}'; editIcon = '{{ addslashes($cat->icon) }}';" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Menghapus kategori ini akan mempengaruhi produk di dalamnya. Lanjutkan?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold" title="Hapus">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-6 text-center">Belum ada kategori yang ditambahkan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
