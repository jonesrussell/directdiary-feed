<?php

namespace App\Enums;

enum DomainApproval: string
{
    case New = 'new';
    case Approved = 'approved';
    case Denied = 'denied';
}
