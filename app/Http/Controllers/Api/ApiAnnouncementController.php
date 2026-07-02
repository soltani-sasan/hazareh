<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class ApiAnnouncementController extends Controller
{
    public function index()
    {
        $data = Announcement::where('is_active', 1)->orderByDesc('priority')->orderByDesc('created_at')->get()
            ->groupBy('section');

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function show(int $id)
    {
        $item = Announcement::where('is_active', 1)->find($id);
        if (!$item) return response()->json(['success' => false, 'message' => 'یافت نشد'], 404);
        return response()->json(['success' => true, 'data' => $item]);
    }
}
