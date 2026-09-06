<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order_num')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:300',
            'link_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'order_num' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order_num'] = $validated['order_num'] ?? 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sliders', 'public');
            $validated['image_path'] = $path;
        }

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Banner slider berhasil ditambahkan.');
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:300',
            'link_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'order_num' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order_num'] = $validated['order_num'] ?? 0;

        if ($request->hasFile('image')) {
            if ($slider->image_path && Storage::disk('public')->exists($slider->image_path)) {
                Storage::disk('public')->delete($slider->image_path);
            }
            $path = $request->file('image')->store('sliders', 'public');
            $validated['image_path'] = $path;
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Banner slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image_path && Storage::disk('public')->exists($slider->image_path)) {
            Storage::disk('public')->delete($slider->image_path);
        }
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Banner slider berhasil dihapus.');
    }
}
