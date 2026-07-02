<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * بررسی نقش کاربر — استفاده: middleware('role:admin,teacher')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'شما اجازه دسترسی به این بخش را ندارید.');
        }

        return $next($request);
    }
}
