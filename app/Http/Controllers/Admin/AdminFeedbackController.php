<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::latest();
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $feedbacks = $query->paginate(20)->withQueryString();
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function show(int $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update(['is_read' => true]);
        return view('admin.feedback.show', compact('feedback'));
    }

    public function destroy(int $id)
    {
        Feedback::findOrFail($id)->delete();
        return back()->with('success', 'پیام حذف شد.');
    }
}