<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private array $fieldLabels = [
        'electrical' => 'برق صنعتی',
        'mechanical' => 'تاسیسات مکانیکی',
        'instrumentation' => 'تعمیرکار ابزار دقیق',
    ];

    public function index(Request $request)
    {
        $query = News::published()->orderByDesc('published_at');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('grade')) {
            $query->where(function ($q) use ($request) {
                $q->where('grade', $request->grade)->orWhere('grade', 'all');
            });
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $news = $query->paginate(9)->withQueryString();
        $fieldLabels = $this->fieldLabels;

        return view('news.index', compact('news', 'fieldLabels'));
    }

    public function show(string $slug)
    {
        $news = News::where('slug', $slug)->published()->firstOrFail();
        $related = News::published()
            ->where('category', $news->category)
            ->where('id', '!=', $news->id)
            ->take(4)->get();

        return view('news.show', compact('news', 'related'));
    }

    public function byField(string $field)
    {
        abort_unless(array_key_exists($field, $this->fieldLabels), 404);
        $news = News::published()->where('category', $field)
            ->orderByDesc('published_at')->paginate(9);

        return view('news.index', [
            'news' => $news,
            'fieldLabels' => $this->fieldLabels,
            'activeField' => $field,
            'pageTitle' => 'اخبار رشته ' . $this->fieldLabels[$field],
        ]);
    }

    public function byGrade(string $grade)
    {
        abort_unless(in_array($grade, ['10', '11', '12']), 404);
        $news = News::published()
            ->where(fn($q) => $q->where('grade', $grade)->orWhere('grade', 'all'))
            ->orderByDesc('published_at')->paginate(9);

        return view('news.index', [
            'news' => $news,
            'fieldLabels' => $this->fieldLabels,
            'activeGrade' => $grade,
            'pageTitle' => 'اخبار پایه ' . ['10'=>'دهم','11'=>'یازدهم','12'=>'دوازدهم'][$grade],
        ]);
    }
}
