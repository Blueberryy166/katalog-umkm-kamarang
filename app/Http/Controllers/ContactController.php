<?php

namespace App\Http\Controllers;

use App\Models\VillageInfo;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $villageInfo = VillageInfo::first();
        return view('frontend.contact', compact('villageInfo'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim kepada pengelola website UMKM Desa Kamarang.');
    }
}
