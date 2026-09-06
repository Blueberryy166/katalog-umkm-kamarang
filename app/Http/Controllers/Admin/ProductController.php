<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['umkm', 'category']);

        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->where('name', 'like', "%{$keyword}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('umkm_id')) {
            $query->where('umkm_id', $request->input('umkm_id'));
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        $umkms = Umkm::all();

        return view('admin.products.index', compact('products', 'categories', 'umkms'));
    }

    public function create()
    {
        $categories = Category::all();
        $umkms = Umkm::where('is_active', true)->get();

        if ($categories->isEmpty() || $umkms->isEmpty()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Silakan tambahkan Kategori dan Data UMKM terlebih dahulu sebelum membuat produk.');
        }

        return view('admin.products.create', compact('categories', 'umkms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'umkm_id' => 'required|exists:umkms,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:50',
            'variants' => 'nullable|array',
            'variants.*' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:300',
            'full_description' => 'nullable|string',
            'pirt_number' => 'nullable|string|max:100',
            'stock_status' => 'required|in:available,preorder,out_of_stock',
            'is_featured' => 'boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);
        $validated['is_featured'] = $request->has('is_featured');

        // Clean variants
        if ($request->has('variants')) {
            $variants = array_filter(array_map('trim', (array)$request->input('variants')));
            $validated['variants'] = array_values($variants);
        } else {
            $validated['variants'] = null;
        }

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('products', 'public');
            $validated['main_image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk "' . $validated['name'] . '" berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $umkms = Umkm::all();

        return view('admin.products.edit', compact('product', 'categories', 'umkms'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'umkm_id' => 'required|exists:umkms,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:50',
            'variants' => 'nullable|array',
            'variants.*' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:300',
            'full_description' => 'nullable|string',
            'pirt_number' => 'nullable|string|max:100',
            'stock_status' => 'required|in:available,preorder,out_of_stock',
            'is_featured' => 'boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);
        }

        // Clean variants
        if ($request->has('variants')) {
            $variants = array_filter(array_map('trim', (array)$request->input('variants')));
            $validated['variants'] = array_values($variants);
        } else {
            $validated['variants'] = null;
        }

        if ($request->hasFile('main_image')) {
            if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                Storage::disk('public')->delete($product->main_image);
            }
            $path = $request->file('main_image')->store('products', 'public');
            $validated['main_image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Data produk "' . $product->name . '" berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
            Storage::disk('public')->delete($product->main_image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk "' . $name . '" berhasil dihapus.');
    }

    public function toggleFeatured(Product $product)
    {
        $product->is_featured = !$product->is_featured;
        $product->save();

        $status = $product->is_featured ? 'dijadikan Produk Unggulan' : 'dihapus dari Produk Unggulan';
        return back()->with('success', 'Produk "' . $product->name . '" berhasil ' . $status . '.');
    }
}
