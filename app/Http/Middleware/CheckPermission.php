<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $permission
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        
        if (!Auth::check()) {
            // User is not authenticated
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userPermission = $user->getAllPermissions()->pluck('name')->toArray();
        
        // Check if the user has the required permission
        if (in_array($permission, $userPermission)) {
            return $next($request);
        }

        // User does not have the required permission
        return Inertia::render('Response/403');
    }
}
