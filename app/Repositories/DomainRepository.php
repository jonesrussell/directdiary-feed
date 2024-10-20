<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class DomainRepository
{
    public function getLatestForUser(User $user): Collection
    {
        return $user->domains()->latest()->get();
    }

    public function delete(Domain $domain): void
    {
        $domain->delete();
    }

    public function create(array $data): Domain
    {
        $fullDomain = $data['name'];
        
        // Extract the extension (TLD)
        $parts = explode('.', $fullDomain);
        $extension = '';
        
        // Handle special cases like .co.uk, .com.au, etc.
        if (count($parts) > 2 && strlen($parts[count($parts) - 2]) <= 3) {
            $extension = implode('.', array_slice($parts, -2));
            $name = implode('.', array_slice($parts, 0, -2));
        } else {
            $extension = array_pop($parts);
            $name = implode('.', $parts);
        }

        // Add the extracted data to the $data array
        $data['extension'] = $extension;
        $data['name'] = $name;

        return (new Domain)->create($data);
    }

    public function getDomainsForUser(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return Domain::where('user_id', $userId)->get();
    }
}
