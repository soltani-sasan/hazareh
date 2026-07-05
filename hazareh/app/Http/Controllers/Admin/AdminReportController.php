<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query();
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $reports = $query->latest()->paginate(20)->withQueryString();
        return view('admin.reports.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'type' => 'required|in:action,visit,future,general',
            'report_date' => 'nullable|date',
        ], ['required' => 'این فیلد الزامی است.']);

        $data['author_id'] = Auth::id();
        Report::create($data);

        return back()->with('success', 'گزارش با موفقیت ثبت شد.');
    }
}
