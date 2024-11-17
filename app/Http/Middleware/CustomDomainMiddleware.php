<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;

class CustomDomainMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        
        // Skip if accessing through main application domain
        if ($host === config('app.url')) {
            return $next($request);
        }

        // Find domain in database
        $domain = Domain::approved()
            ->where('name', explode('.', $host)[0])
            ->where('extension', implode('.', array_slice(explode('.', $host), 1)))
            ->with('user')
            ->first();

        if ($domain && $domain->user) {
            // Set the username for the route parameter
            $request->route()->setParameter('username', $domain->user->username);
            return $next($request);
        }

        abort(404);
    }
}
