<?php

declare(strict_types=1);

use App\Rules\ValidDomainName;
use Illuminate\Support\Facades\Validator;

test('valid domain name passes validation', function () {
    $validator = Validator::make(['domain' => 'example-domain'], [
        'domain' => new ValidDomainName(),
    ]);

    expect($validator->passes())->toBeTrue();
});

test('invalid domain name fails validation', function () {
    $validator = Validator::make(['domain' => 'invalid domain'], [
        'domain' => new ValidDomainName(),
    ]);

    expect($validator->fails())->toBeTrue();
});
