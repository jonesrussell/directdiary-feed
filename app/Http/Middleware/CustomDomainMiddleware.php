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
            $extension = implode('.', array_slice($parts, -2)); // Gets last two parts (e.g., "com", "co.uk")
            $name = implode('.', array_slice($parts, 0, -2)); // Gets everything before the extension
            
            Log::info('CustomDomainMiddleware: Processing request', [
                'host' => $host,
                'name' => $name,
                'extension' => $extension
            ]);

            // Find the domain in our database
            $domain = Domain::with('user')
                ->where('name', $name)
                ->where('extension', $extension)
                ->approved()
                ->first();

            if (!$domain || !$domain->user) {
                Log::info('CustomDomainMiddleware: Domain not found or no user', [
                    'host' => $host,
                    'name' => $name,
                    'extension' => $extension,
                    'domain_found' => (bool)$domain,
                    'has_user' => (bool)$domain?->user
                ]);
                abort(404);
            }

            Log::info('CustomDomainMiddleware: Domain found', [
                'domain_id' => $domain->id,
                'username' => $domain->user->username
            ]);

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
