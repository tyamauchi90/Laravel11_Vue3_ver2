<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole extends Middleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): $next
   */
  public function handle(Request $request, Closure $next)
  {
    $user = Auth::user();

    if ($user && ($user->role == 'admin' || $user->role == 'master')) {
      return $next($request);
    }

    return response()->json(['message' => '操作権限がありません'], 403);
  }
}
