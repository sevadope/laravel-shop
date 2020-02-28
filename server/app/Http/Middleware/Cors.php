<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    private $allowed_origins = [
        'http://localhost:3000',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $req_origin = $request->headers->get('origin');

        info([$request]);

        if (in_array($req_origin, $this->allowed_origins)) {
            return $next($request)
                ->header('Access-Control-Allow-Origin', $req_origin)
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        return $next($request);
    }
}
