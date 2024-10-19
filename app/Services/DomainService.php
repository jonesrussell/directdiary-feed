<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Domain;

class DomainService
{
    public function formatPrice(Domain $domain): string
    {
        // Convert cents to dollars and format with 2 decimal places
        $formattedPrice = number_format($domain->price / 100, 2, '.', ',');
        
        // Add dollar sign
        return '$' . $formattedPrice;
    }
}
