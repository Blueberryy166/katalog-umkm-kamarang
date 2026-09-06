<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Umkm::where('is_active', true)->withCount('products');

        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('owner_name', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%")
                  ->orWhere('dusun', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('dusun')) {
            $query->where('dusun', $request->input('dusun'));
        }

        $umkms = $query->orderBy('name')->paginate(9)->withQueryString();
        
        $dusuns = Umkm::whereNotNull('dusun')->distinct()->pluck('dusun');

        return view('frontend.umkm-directory', compact('umkms', 'dusuns'));
    }

    public function show($slug)
    {
        $umkm = Umkm::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = $umkm->products()->with('category')->latest()->paginate(8);

        return view('frontend.umkm-detail', compact('umkm', 'products'));
    }
}
