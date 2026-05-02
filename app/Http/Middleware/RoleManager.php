<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $roleName)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        };

        $user = Auth::user();

        if ($user->role && $user->role->role_name === $roleName) {
            return $next($request);
        };

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');


    }
}
