<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class ApiNewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()->orderByDesc('published_at');
        if ($request->filled('category')) $query->where('category', $request->category);
        if ($request->filled('grade')) $query->where(fn($q) => $q->where('grade', $request->grade)->orWhere('grade', 'all'));

        return response()->json(['success' => true, 'data' => $query->paginate(10)]);
    }

    public function show(string $slug)
    {
        $news = News::where('slug', $slug)->published()->first();
        if (!$news) return response()->json(['success' => false, 'message' => 'خبر یافت نشد'], 404);

        return response()->json(['success' => true, 'data' => $news]);
    }

    public function byField(string $field)
    {
        $news = News::published()->where('category', $field)->orderByDesc('published_at')->paginate(10);
        return response()->json(['success' => true, 'data' => $news]);
    }
}
