<?php

declare(strict_types=1);

namespace App\ValueObject;

final class UserId implements Id
{
    use UuidTrait;
}
