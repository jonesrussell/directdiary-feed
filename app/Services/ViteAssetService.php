<?php

namespace App\Services;

use Illuminate\Support\Facades\Vite;

class ViteAssetService
{
    public function render(): string
    {
        $baseUrl = rtrim(config('app.url'), '/');
        
        // Get the manifest entries
        $manifestEntries = [
            'resources/js/app.js',
            'resources/css/app.css',
        ];

        // Add the current page component
        if (request()->inertia()) {
            $page = request()->get('page');
            $manifestEntries[] = "resources/js/Pages/{$page['component']}.vue";
        }

        // Generate tags with the correct base URL
        $tags = Vite::useHotFile(public_path('hot'))
            ->useBuildDirectory('build')
            ->withEntryPoints($manifestEntries);

        // Replace the asset URLs with the current domain
        return preg_replace(
            '/(href|src)="([^"]+)"/', 
            '$1="' . $baseUrl . '$2"',
            $tags
        );
    }
} 