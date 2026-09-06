<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['umkm', 'category']);

        // Search by keyword
        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('short_description', 'like', "%{$keyword}%")
                  ->orWhere('full_description', 'like', "%{$keyword}%");
            });
        }

        // Filter by category slug
        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        // Filter by UMKM slug
        if ($request->filled('umkm')) {
            $umkmSlug = $request->input('umkm');
            $query->whereHas('umkm', function ($q) use ($umkmSlug) {
                $q->where('slug', $umkmSlug);
            });
        }

        // Filter by stock status
        if ($request->filled('stock') && in_array($request->input('stock'), ['available', 'preorder', 'out_of_stock'])) {
            $query->where('stock_status', $request->input('stock'));
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $umkms = Umkm::where('is_active', true)->withCount('products')->get();

        $selectedCategory = $request->filled('category') ? Category::where('slug', $request->input('category'))->first() : null;
        $selectedUmkm = $request->filled('umkm') ? Umkm::where('slug', $request->input('umkm'))->first() : null;

        return view('frontend.catalog', compact(
            'products',
            'categories',
            'umkms',
            'selectedCategory',
            'selectedUmkm'
        ));
    }

    public function show($slug)
    {
        $product = Product::with(['umkm', 'category'])->where('slug', $slug)->firstOrFail();

        // Increment view count
        $product->increment('view_count');

        // Related products
        $relatedProducts = Product::with(['umkm', 'category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }
}
