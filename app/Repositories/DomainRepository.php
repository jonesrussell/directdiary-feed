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
        return (new Domain)->create($data);
    }

    public function getDomainsForUser(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return Domain::where('user_id', $userId)->get();
    }
}
