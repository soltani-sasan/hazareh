<?php
namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Staff;

class PageController extends Controller
{
    private function renderPage(string $slug, string $fallbackTitle)
    {
        $page = Page::where('slug', $slug)->first();
        if (!$page) {
            $page = new Page(['slug' => $slug, 'title' => $fallbackTitle, 'body' => '<p>محتوای این صفحه به‌زودی تکمیل می‌شود.</p>']);
        }
        return view('pages.static', compact('page'));
    }

    public function about()       { return $this->renderPage('about', 'درباره هنرستان'); }
    public function goals()       { return $this->renderPage('goals', 'اهداف و رسالت'); }
    public function facilities()  { return $this->renderPage('facilities', 'امکانات هنرستان'); }
    public function history()     { return $this->renderPage('history', 'تاریخچه'); }

    public function pta()
    {
        $members = Staff::where('department', 'pta')->where('is_active', 1)->orderBy('sort_order')->get();
        return view('pages.pta', compact('members'));
    }

    public function staffTeaching()
    {
        $staff = Staff::where('department', 'teaching')->where('is_active', 1)->orderBy('sort_order')->get();
        return view('pages.staff', ['staff' => $staff, 'title' => 'کادر آموزشی', 'department' => 'teaching']);
    }

    public function staffResearch()
    {
    $staff = Staff::where('department', 'research')
                  ->where('is_active', 1)->orderBy('sort_order')->get();
    return view('pages.staff', [
        'staff'      => $staff,
        'title'      => 'کادر اجرایی هنرستان',
        'department' => 'research',
    ]);
    }

    public function staffAdmin()
    {
        $staff = Staff::where('department', 'admin')->where('is_active', 1)->orderBy('sort_order')->get();
        return view('pages.staff', ['staff' => $staff, 'title' => 'کادر اداری', 'department' => 'admin']);
    }

    public function topStudents()
    {
        return view('pages.top-students');
    }

    public function extraActivities()
    {
        return view('pages.extra-activities');
    }

    public function appDownload()
    {
        return view('pages.app-download');
    }
}
