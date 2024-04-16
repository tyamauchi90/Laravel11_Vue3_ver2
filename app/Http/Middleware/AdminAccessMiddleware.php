<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->role == 'master')) {
      return $next($request);
    }

    // return response()->json(['message' => 'アクセス権限がありません'], 403);
    return redirect('/login')->with([
      'message' => 'アクセス権限がありません。',
      'status' => 'error'
    ]);
  }
}
