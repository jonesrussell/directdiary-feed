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
        $host = $request->getHost();
        $mainDomain = str_replace(['https://', 'http://'], '', config('app.url'));
        
        Log::debug('CustomDomainMiddleware: Starting middleware execution', [
            'host' => $host,
            'main_domain' => $mainDomain,
            'route_name' => $request->route()?->getName(),
            'all_parameters' => $request->route()?->parameters() ?? []
        ]);
        
        // Skip middleware for main application domain
        if ($host === $mainDomain) {
            Log::debug('CustomDomainMiddleware: Main domain detected, skipping middleware', [
                'host' => $host,
                'main_domain' => $mainDomain
            ]);
            return $next($request);
        }
        
        try {
            // Parse domain components
            $name = explode('.', $host)[0];
            $extension = implode('.', array_slice(explode('.', $host), 1));
            
            Log::debug('CustomDomainMiddleware: Looking up domain', [
                'name' => $name,
                'extension' => $extension
            ]);
            
            // Query for domain
            $domain = Domain::approved()
                ->where('name', $name)
                ->where('extension', $extension)
                ->with('user')
                ->first();

            if (!$domain || !$domain->user) {
                Log::warning('CustomDomainMiddleware: Domain not found or no user', [
                    'subdomain' => $name,
                    'domain_found' => (bool)$domain,
                    'has_user' => (bool)$domain?->user
                ]);
                abort(404);
            }

            Log::debug('CustomDomainMiddleware: Domain found', [
                'domain_id' => $domain->id,
                'username' => $domain->user->username
            ]);

            // Set the username parameter
            $request->route()->setParameter('username', $domain->user->username);
            
            return $next($request);
            
        } catch (\Exception $e) {
            Log::error('CustomDomainMiddleware: Error', [
                'message' => $e->getMessage(),
                'subdomain' => $name ?? null
            ]);
            abort(404);
        }
    }
}
