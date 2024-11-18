<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Enums\DomainApproval;

class CustomDomainMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Get the full host from the request
            $host = $request->getHost();
            
            Log::info('CustomDomainMiddleware: Processing request', [
                'host' => $host,
                'scheme' => $request->getScheme(),
                'url' => $request->url()
            ]);
            
            // Parse domain components
            $parts = explode('.', $host);
            
            // Ensure we have enough parts
            if (count($parts) < 2) {
                Log::warning('CustomDomainMiddleware: Invalid domain format', [
                    'host' => $host,
                    'parts' => $parts
                ]);
                abort(404);
            }
            
            // Handle domain parsing based on number of parts
            if (count($parts) === 2) {
                // For domains like "example.com"
                $name = $parts[0];
                $extension = $parts[1];
            } else {
                // For domains like "subdomain.example.com"
                $extension = implode('.', array_slice($parts, -2));
                $name = implode('.', array_slice($parts, 0, -2));
            }
            
            Log::debug('CustomDomainMiddleware: Parsed domain', [
                'name' => $name,
                'extension' => $extension,
                'parts' => $parts,
                'parts_count' => count($parts)
            ]);
            
            // Find the domain in our database
            $domain = Domain::with('user')
                ->where('name', $name)
                ->where('extension', $extension)
                ->where('approval', DomainApproval::Approved)
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

            // Set the base URL for the current domain
            $baseUrl = $request->getScheme() . '://' . $host;
            config(['app.url' => $baseUrl]);
            config(['asset_url' => $baseUrl]);
            
            // Set the username parameter
            $request->route()->setParameter('username', $domain->user->username);
            
            return $next($request);
        } catch (\Exception $e) {
            Log::error('CustomDomainMiddleware: Error', [
                'message' => $e->getMessage(),
                'host' => $host ?? null,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(404);
        }
    }
}
