<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBackup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('backup_authorized') !== true) {
            return redirect()->route('admin.backup.index')->with('message', 'Unauthorized access');
        }

        return $next($request);
    }
}
