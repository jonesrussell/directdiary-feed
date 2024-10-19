<?php

use App\Enums\DomainApproval;

test('domain approval enum has correct cases', function () {
    expect(DomainApproval::cases())->toHaveCount(3);
    expect(DomainApproval::New->value)->toBe('new');
    expect(DomainApproval::Approved->value)->toBe('approved');
    expect(DomainApproval::Denied->value)->toBe('denied');
});
