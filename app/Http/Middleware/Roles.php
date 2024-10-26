<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!Auth::check()) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
        }

        $user = Auth::user();
        if(!$user->hasRole($role)) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 401);
        }

        return $next($request);
    }
}