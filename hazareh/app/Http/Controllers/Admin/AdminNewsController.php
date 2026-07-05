<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::latest();
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }
        $news = $query->paginate(15)->withQueryString();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.form', ['news' => new News()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }
        $data['author_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();

        if ($request->boolean('is_published')) {
            $data['is_published'] = true;
            $data['published_at'] = now();
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'خبر با موفقیت ایجاد شد.');
    }

    public function edit(int $id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.form', compact('news'));
    }

    public function update(Request $request, int $id)
    {
        $news = News::findOrFail($id);
        $data = $this->validateData($request, $id);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $wasPublished = $news->is_published;
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && !$wasPublished) {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'خبر با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(int $id)
    {
        News::findOrFail($id)->delete();
        return back()->with('success', 'خبر حذف شد.');
    }

    public function publish(int $id)
    {
        $news = News::findOrFail($id);
        $news->is_published = !$news->is_published;
        if ($news->is_published && !$news->published_at) {
            $news->published_at = now();
        }
        $news->save();

        return back()->with('success', $news->is_published ? 'خبر منتشر شد.' : 'خبر از حالت انتشار خارج شد.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'required|in:general,electrical,mechanical,instrumentation,extra',
            'grade' => 'required|in:all,10,11,12',
            'type' => 'required|in:news,notice',
            'image' => 'nullable|image|max:2048',
        ], ['required' => 'این فیلد الزامی است.']);
    }
}
