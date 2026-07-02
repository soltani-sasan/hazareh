<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Conference;
use App\Models\User;

class ApiHomeController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'sliders' => Slider::where('is_active', 1)->orderBy('sort_order')->get(),
                'latest_news' => News::published()->orderByDesc('published_at')->take(5)->get(),
                'announcements' => Announcement::where('is_active', 1)->latest()->take(10)->get(),
                'conference' => Conference::where('is_active', 1)->latest()->first(),
            ],
        ]);
    }

    public function sliders()
    {
        return response()->json(['success' => true, 'data' => Slider::where('is_active', 1)->orderBy('sort_order')->get()]);
    }

    public function stats()
    {
        return response()->json(['success' => true, 'data' => [
            'students' => 69,
            'fields' => 3,
            'partners' => 3,
            'founded_year' => 1404,
            'total_students_registered' => User::where('role', 'student')->count(),
        ]]);
    }
}
