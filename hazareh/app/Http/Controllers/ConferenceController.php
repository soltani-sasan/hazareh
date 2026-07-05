<?php
namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\ConferenceRegistration;
use App\Models\ConferencePartner;
use App\Models\Paper;
use App\Models\PaperReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConferenceController extends Controller
{
    public array $tracks = [
        'instrumentation' => [
            'name' => 'تعمیر و نگهداری ابزار دقیق',
            'icon' => 'gauge',
            'topics' => ['فناوری‌های نوین در ابزار دقیق', 'اتوماسیون صنعتی', 'نگهداری پیشگیرانه'],
        ],
        'mechanical' => [
            'name' => 'تاسیسات مکانیکی',
            'icon' => 'settings-2',
            'topics' => ['طراحی سیستم‌های تاسیساتی', 'بهینه‌سازی مصرف انرژی', 'ارزیابی عملکرد تجهیزات'],
        ],
        'electrical' => [
            'name' => 'برق صنعتی',
            'icon' => 'bolt',
            'topics' => ['انرژی‌های تجدیدپذیر', 'توزیع و انتقال برق صنعتی', 'اینترنت اشیا (IoT) صنعتی'],
        ],
        'innovation' => [
            'name' => 'نوآوری و ایده‌های جدید',
            'icon' => 'bulb',
            'topics' => ['ایده‌های هنرجویان برای بهبود صنایع', 'پروژه‌های کارآفرینی', 'راهکارهای خلاقانه صنعتی'],
        ],
    ];

    public function index()
    {
        $conference = Conference::where('is_active', 1)->latest()->first();
        $partners = ConferencePartner::orderBy('sort_order')->get();
        $tracks = $this->tracks;

        return view('conference.index', compact('conference', 'partners', 'tracks'));
    }

    public function schedule()
    {
        $conference = Conference::where('is_active', 1)->latest()->first();
        return view('conference.schedule', compact('conference'));
    }

    public function results()
    {
        $accepted = Paper::with('author')->where('status', 'accepted')
            ->orderBy('track')->get()->groupBy('track');
        $tracks = $this->tracks;

        return view('conference.results', compact('accepted', 'tracks'));
    }

    public function registerForm()
    {
        return view('conference.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:120',
            'national_id' => 'nullable|digits:10',
            'organization' => 'nullable|string|max:150',
            'email' => 'required|email|max:180',
            'phone' => 'required|regex:/^09[0-9]{9}$/',
            'participant_type' => 'required|in:student,teacher,industry,public,other',
        ], ['required' => 'این فیلد الزامی است.']);

        $data['user_id'] = Auth::id();
        ConferenceRegistration::create($data);

        return back()->with('success', 'ثبت‌نام شما در همایش با موفقیت انجام شد.');
    }

    public function submitForm()
    {
        $tracks = $this->tracks;
        return view('conference.submit', compact('tracks'));
    }

    public function submitPaper(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string|min:50',
            'keywords' => 'nullable|string|max:255',
            'track' => 'required|in:instrumentation,mechanical,electrical,innovation',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'required' => 'این فیلد الزامی است.',
            'abstract.min' => 'چکیده مقاله باید حداقل ۵۰ کاراکتر باشد.',
            'file.mimes' => 'فایل مقاله باید با فرمت PDF یا Word باشد.',
            'file.max' => 'حجم فایل نباید بیشتر از ۱۰ مگابایت باشد.',
        ]);

        $path = $request->file('file')->store('papers', 'public');

        Paper::create([
            'author_id' => Auth::id(),
            'title' => $data['title'],
            'abstract' => $data['abstract'],
            'keywords' => $data['keywords'] ?? null,
            'track' => $data['track'],
            'file_path' => $path,
            'status' => 'submitted',
        ]);

        return redirect()->route('conference.my-paper')
            ->with('success', 'مقاله شما با موفقیت ارسال شد و در صف داوری قرار گرفت.');
    }

    public function myPaper()
    {
        $papers = Auth::user()->papers()->latest()->get();
        return view('conference.my-paper', compact('papers'));
    }

    // ── پنل داوران ────────────────────────────────────────
    public function judgePanel()
    {
        $user = Auth::user();
        $judgeTrack = optional($user->judge)->track ?? 'all';

        $query = Paper::with('author')->whereIn('status', ['submitted', 'under_review']);
        if ($judgeTrack !== 'all') {
            $query->where('track', $judgeTrack);
        }

        $papers = $query->latest('submitted_at')->get();
        $reviewedIds = PaperReview::where('judge_id', $user->id)->pluck('paper_id');

        return view('conference.judge-panel', compact('papers', 'reviewedIds'));
    }

    public function reviewForm(int $id)
    {
        $paper = Paper::with('author')->findOrFail($id);
        $existingReview = PaperReview::where('paper_id', $id)->where('judge_id', Auth::id())->first();

        return view('conference.review-form', compact('paper', 'existingReview'));
    }

    public function submitReview(Request $request, int $id)
    {
        $paper = Paper::findOrFail($id);

        $data = $request->validate([
            'originality' => 'required|integer|min:0|max:20',
            'quality' => 'required|integer|min:0|max:20',
            'relevance' => 'required|integer|min:0|max:20',
            'presentation' => 'required|integer|min:0|max:20',
            'comments' => 'nullable|string',
            'decision' => 'required|in:accept,reject,revision',
        ], ['required' => 'این فیلد الزامی است.']);

        PaperReview::updateOrCreate(
            ['paper_id' => $id, 'judge_id' => Auth::id()],
            $data
        );

        $paper->status = match ($data['decision']) {
            'accept' => 'accepted',
            'reject' => 'rejected',
            'revision' => 'revision',
        };
        $paper->save();

        return redirect()->route('conference.judge')
            ->with('success', 'داوری شما با موفقیت ثبت شد.');
    }
}
