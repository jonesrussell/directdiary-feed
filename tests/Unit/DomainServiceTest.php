<?php

declare(strict_types=1);

use App\Services\DomainService;
use App\Models\Domain;

test('domain price is formatted correctly', function () {
    $service = new DomainService();
    
    /** @var Domain $domain */
    $domain = \Mockery::mock(Domain::class);
    $domain->shouldReceive('getAttribute')->with('price')->andReturn(1000000);
    
    expect($service->formatPrice($domain))->toBe('$10,000.00');
});

// Add this to clean up Mockery after each test
afterEach(function () {
    \Mockery::close();
});
