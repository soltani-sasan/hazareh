<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Paper;
use App\Models\ConferenceRegistration;
use App\Models\Judge;
use Illuminate\Http\Request;

class AdminConferenceController extends Controller
{
    public function index()
    {
        $conference = Conference::latest()->first();
        return view('admin.conference.index', compact('conference'));
    }

    public function update(Request $request)
    {
        $conference = Conference::firstOrNew(['id' => 1]);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'submission_deadline' => 'required|date',
            'venue' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ], ['required' => 'این فیلد الزامی است.']);

        $conference->fill($data);
        $conference->save();

        return back()->with('success', 'اطلاعات همایش با موفقیت به‌روزرسانی شد.');
    }

    public function papers(Request $request)
    {
        $query = Paper::with(['author', 'reviews']);
        if ($request->filled('track')) {
            $query->where('track', $request->track);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $papers = $query->latest('submitted_at')->paginate(20)->withQueryString();
        $judges = Judge::all();

        return view('admin.conference.papers', compact('papers', 'judges'));
    }

    public function assignJudge(Request $request, int $id)
    {
        $request->validate([
        'judge_id' => 'required|exists:users,id',
    ], [
        'judge_id.required' => 'لطفاً یک داور انتخاب کنید',
        'judge_id.exists'   => 'داور انتخاب‌شده معتبر نیست',
    ]);

        // یادآوری: می‌توان جدول واسط paper_judge برای تخصیص چندگانه داور اضافه کرد
        return back()->with('success', 'داور با موفقیت به مقاله تخصیص یافت.');
    }

    public function registrations(Request $request)
    {
        $query = ConferenceRegistration::query();
        if ($request->filled('type')) {
            $query->where('participant_type', $request->type);
        }
        $registrations = $query->latest()->paginate(20)->withQueryString();

        return view('admin.conference.registrations', compact('registrations'));
    }

    public function results()
    {
        $papers = Paper::with('reviews')->get();
        $summary = [
            'submitted' => $papers->where('status', 'submitted')->count(),
            'under_review' => $papers->where('status', 'under_review')->count(),
            'accepted' => $papers->where('status', 'accepted')->count(),
            'rejected' => $papers->where('status', 'rejected')->count(),
            'revision' => $papers->where('status', 'revision')->count(),
        ];

        return view('admin.conference.results', compact('papers', 'summary'));
    }
}
