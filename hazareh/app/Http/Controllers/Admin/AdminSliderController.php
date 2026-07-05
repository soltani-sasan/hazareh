<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create() { return view('admin.sliders.form', ['slider' => new Slider()]); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|max:3072',
            'link' => 'nullable|url',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ], ['required' => 'تصویر اسلایدر الزامی است.']);

        $data['image'] = $request->file('image')->store('sliders', 'public');
        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'اسلاید با موفقیت اضافه شد.');
    }

    public function edit(int $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, int $id)
    {
        $slider = Slider::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:3072',
            'link' => 'nullable|url',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }
        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'اسلاید با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(int $id)
    {
        Slider::findOrFail($id)->delete();
        return back()->with('success', 'اسلاید حذف شد.');
    }
}
