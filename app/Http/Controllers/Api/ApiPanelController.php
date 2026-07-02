<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use App\Models\Notification;
use Illuminate\Http\Request;

class ApiPanelController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user()->load('student');
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function registrationStatus(Request $request)
    {
        $student = $request->user()->student;
        return response()->json(['success' => true, 'data' => $student]);
    }

    public function myCounseling(Request $request)
    {
        $items = CounselingRequest::where('national_id', $request->user()->national_id)
            ->orderByDesc('created_at')->get();

        return response()->json(['success' => true, 'data' => $items]);
    }

    public function notifications(Request $request)
    {
        $items = Notification::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')->paginate(20);

        return response()->json(['success' => true, 'data' => $items]);
    }

    public function markRead(Request $request, int $id)
    {
        $note = Notification::where('user_id', $request->user()->id)->findOrFail($id);
        $note->is_read = true;
        $note->save();

        return response()->json(['success' => true]);
    }
}
