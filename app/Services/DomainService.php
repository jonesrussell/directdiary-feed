<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Support\Str;

class DomainService
{
    public function formatPrice(Domain $domain): string
    {
        // Convert cents to dollars and format with 2 decimal places
        $formattedPrice = number_format($domain->price / 100, 2, '.', ',');
        
        // Add dollar sign
        return '$' . $formattedPrice;
    }

    public function createDomain(User $user, string $domainName): void
    {
        $parts = explode('.', $domainName);
        $tld = Str::lower(array_pop($parts));
        $name = implode('.', $parts);

        $validTlds = array_keys(top_level_domains());
        if (!in_array($tld, $validTlds)) {
            throw new \InvalidArgumentException('Invalid top-level domain.');
        }

        $user->domains()->create([
            'name' => $name,
            'extension' => $tld,
        ]);
    }
}
