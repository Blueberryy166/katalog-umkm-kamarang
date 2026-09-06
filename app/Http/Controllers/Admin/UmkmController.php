<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = Umkm::withCount('products');

        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('owner_name', 'like', "%{$keyword}%")
                  ->orWhere('dusun', 'like', "%{$keyword}%");
            });
        }

        $umkms = $query->latest()->paginate(10)->withQueryString();

        return view('admin.umkms.index', compact('umkms'));
    }

    public function create()
    {
        return view('admin.umkms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'owner_name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:25',
            'dusun' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:300',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'maps_url' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'instagram_url' => 'nullable|string|max:200',
            'facebook_url' => 'nullable|string|max:200',
            'is_active' => 'boolean',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);
        $validated['is_active'] = $request->has('is_active');

        // Auto generate Google Maps URL if coordinates given but maps_url empty
        if (!empty($validated['latitude']) && !empty($validated['longitude']) && empty($validated['maps_url'])) {
            $validated['maps_url'] = "https://www.google.com/maps?q={$validated['latitude']},{$validated['longitude']}";
        }

        if ($request->hasFile('logo_image')) {
            $path = $request->file('logo_image')->store('umkms', 'public');
            $validated['logo_image'] = $path;
        }

        Umkm::create($validated);

        return redirect()->route('admin.umkms.index')
            ->with('success', 'Data UMKM "' . $validated['name'] . '" berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm)
    {
        return view('admin.umkms.edit', compact('umkm'));
    }

    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'owner_name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:25',
            'dusun' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:300',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'maps_url' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'instagram_url' => 'nullable|string|max:200',
            'facebook_url' => 'nullable|string|max:200',
            'is_active' => 'boolean',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($umkm->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);
        }

        // Auto generate Google Maps URL if coordinates given but maps_url empty
        if (!empty($validated['latitude']) && !empty($validated['longitude']) && empty($validated['maps_url'])) {
            $validated['maps_url'] = "https://www.google.com/maps?q={$validated['latitude']},{$validated['longitude']}";
        }

        if ($request->hasFile('logo_image')) {
            if ($umkm->logo_image && Storage::disk('public')->exists($umkm->logo_image)) {
                Storage::disk('public')->delete($umkm->logo_image);
            }
            $path = $request->file('logo_image')->store('umkms', 'public');
            $validated['logo_image'] = $path;
        }

        $umkm->update($validated);

        return redirect()->route('admin.umkms.index')
            ->with('success', 'Data UMKM "' . $umkm->name . '" berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm)
    {
        $name = $umkm->name;
        if ($umkm->logo_image && Storage::disk('public')->exists($umkm->logo_image)) {
            Storage::disk('public')->delete($umkm->logo_image);
        }

        $umkm->delete();

        return redirect()->route('admin.umkms.index')
            ->with('success', 'Data UMKM "' . $name . '" berhasil dihapus.');
    }
}
