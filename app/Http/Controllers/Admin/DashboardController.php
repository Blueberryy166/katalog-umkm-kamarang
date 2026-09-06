<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Umkm;
use App\Models\VillageInfo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalUmkms = Umkm::count();
        $totalCategories = Category::count();
        $totalViews = Product::sum('view_count');
        $featuredCount = Product::where('is_featured', true)->count();

        $topProducts = Product::with(['umkm', 'category'])
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $recentProducts = Product::with(['umkm', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recentUmkms = Umkm::withCount('products')
            ->latest()
            ->take(4)
            ->get();

        $villageInfo = VillageInfo::first();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalUmkms',
            'totalCategories',
            'totalViews',
            'featuredCount',
            'topProducts',
            'recentProducts',
            'recentUmkms',
            'villageInfo'
        ));
    }
}
