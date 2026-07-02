<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\ConferenceRegistration;
use App\Models\Paper;
use Illuminate\Http\Request;

class ApiConferenceController extends Controller
{
    public function index()
    {
        $conference = Conference::where('is_active', 1)->latest()->first();
        return response()->json(['success' => true, 'data' => $conference]);
    }

    public function schedule()
    {
        $conference = Conference::where('is_active', 1)->latest()->first();
        return response()->json(['success' => true, 'data' => $conference]);
    }

    public function results()
    {
        $accepted = Paper::where('status', 'accepted')->select('id','title','track','author_id')
            ->with('author:id,name')->get()->groupBy('track');

        return response()->json(['success' => true, 'data' => $accepted]);
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
        ]);

        $data['user_id'] = $request->user()?->id;
        $registration = ConferenceRegistration::create($data);

        return response()->json(['success' => true, 'message' => 'ثبت‌نام شما انجام شد.', 'data' => $registration], 201);
    }

    public function submitPaper(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string|min:50',
            'keywords' => 'nullable|string|max:255',
            'track' => 'required|in:instrumentation,mechanical,electrical,innovation',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $request->file('file')->store('papers', 'public');

        $paper = Paper::create([
            'author_id' => $request->user()->id,
            'title' => $data['title'],
            'abstract' => $data['abstract'],
            'keywords' => $data['keywords'] ?? null,
            'track' => $data['track'],
            'file_path' => $path,
            'status' => 'submitted',
        ]);

        return response()->json(['success' => true, 'message' => 'مقاله ارسال شد.', 'data' => $paper], 201);
    }

    public function myPaper(Request $request)
    {
        $papers = $request->user()->papers()->with('reviews')->latest()->get();
        return response()->json(['success' => true, 'data' => $papers]);
    }
}
