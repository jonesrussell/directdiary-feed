<?php

declare(strict_types=1);

test('top_level_domains function returns an array', function () {
    expect(top_level_domains())->toBeArray();
});

test('top_level_domains function returns expected number of TLDs', function () {
    expect(top_level_domains())->toHaveCount(277);
});

test('top_level_domains function contains common TLDs', function () {
    $tlds = top_level_domains();
    $commonTlds = ['com', 'org', 'net', 'edu', 'gov', 'co.uk', 'co.jp', 'us'];

    foreach ($commonTlds as $tld) {
        expect($tlds)->toHaveKey($tld);
    }
});

test('top_level_domains function returns correct descriptions for common TLDs', function () {
    $tlds = top_level_domains();
    
    expect($tlds['com'])->toBe('commercial');
    expect($tlds['org'])->toBe('organization');
    expect($tlds['net'])->toBe('network');
    expect($tlds['us'])->toBe('United States');
});

test('top_level_domains function handles country-specific TLDs correctly', function () {
    $tlds = top_level_domains();
    
    expect($tlds['fr'])->toBe('France');
    expect($tlds['de'])->toBe('Germany');
    expect($tlds)->not->toHaveKey('jp');
    expect($tlds['co.jp'])->toBe('Japan');
});
