<?php

declare(strict_types=1);

namespace App\Doctrine\DBAL\Types;

use App\ValueObject\UserId;

final class UserIdType extends AbstractIdType
{
    public function getName(): string
    {
        return 'user_id';
    }

    protected function getIdClass(): string
    {
        return UserId::class;
    }
}
