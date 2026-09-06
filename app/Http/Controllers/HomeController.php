<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Umkm;
use App\Models\VillageInfo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)->orderBy('order_num')->get();
        $categories = Category::withCount('products')->get();
        
        $featuredProducts = Product::with(['umkm', 'category'])
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        $latestProducts = Product::with(['umkm', 'category'])
            ->latest()
            ->take(8)
            ->get();

        $umkms = Umkm::where('is_active', true)
            ->withCount('products')
            ->take(6)
            ->get();

        $villageInfo = VillageInfo::first();
        $totalProducts = Product::count();
        $totalUmkm = Umkm::where('is_active', true)->count();

        return view('frontend.home', compact(
            'sliders',
            'categories',
            'featuredProducts',
            'latestProducts',
            'umkms',
            'villageInfo',
            'totalProducts',
            'totalUmkm'
        ));
    }
}
