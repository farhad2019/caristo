<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Http\Request;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];


    public function handle($request, Closure $next)
    {
        //dd($request->ip(), $request->all(), $request->route()->toJson());
        if ($request->route()->uri == 'admin/notification' || $request->route()->uri == 'admin/alert' || $request->route()->uri == 'admin/tradealert') {
            //DB::table('logs')->insert(['logs' => $request->route()->uri, 'created_at' => now()->format('Y-m-d H:i:s')]);
            return abort(403, 'Unauthorized action . ');
        } else {
            //DB::table('logs')->insert(['logs' => $request->route()->uri, 'created_at' => now()->format('Y-m-d H:i:s')]);
            return $next($request);
        }
    }
}
