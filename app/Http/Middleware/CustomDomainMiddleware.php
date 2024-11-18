<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomDomainMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Get the full host from the request
            $host = $request->getHost();
            
            // Parse domain components
            $parts = explode('.', $host);
            $extension = implode('.', array_slice($parts, -2));
            $name = implode('.', array_slice($parts, 0, -2));
            
            // Find the domain in our database
            $domain = Domain::with('user')
                ->where('name', $name)
                ->where('extension', $extension)
                ->approved()
                ->first();

            if (!$domain || !$domain->user) {
                abort(404);
            }

            // Set the asset URL for the current domain
            config(['app.url' => $request->getScheme() . '://' . $host]);
            config(['asset_url' => $request->getScheme() . '://' . $host]);
            
            // Set the username parameter
            $request->route()->setParameter('username', $domain->user->username);
            
            return $next($request);
        } catch (\Exception $e) {
            Log::error('CustomDomainMiddleware: Error', [
                'message' => $e->getMessage(),
                'host' => $host ?? null
            ]);
            abort(404);
        }
    }
}
