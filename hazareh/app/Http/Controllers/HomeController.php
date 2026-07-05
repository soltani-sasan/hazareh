<?php
namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Conference;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', 1)->orderBy('sort_order')->get();

        if ($sliders->isEmpty()) {
            // اسلایدر پیش‌فرض در صورت نبود داده (جلوگیری از صفحه خالی هنگام نصب اولیه)
            $sliders = collect([
                (object) ['title' => 'هنرستان هزاره صنعت', 'subtitle' => 'اولین هنرستان جوار صنعت غرب کشور', 'image' => 'placeholder.jpg'],
            ]);
        }

        $featuredNews = News::published()->orderByDesc('published_at')->first();
        $latestNews = News::published()->orderByDesc('published_at')
            ->when($featuredNews, fn($q) => $q->where('id', '!=', $featuredNews->id))
            ->take(5)->get();

        $announcements = Announcement::where('is_active', 1)
            ->orderByDesc('priority')->orderByDesc('created_at')->take(15)->get();

        $conference = Conference::where('is_active', 1)->latest()->first();

        return view('home.index', compact('sliders', 'featuredNews', 'latestNews', 'announcements', 'conference'));
    }
}
