<?php

namespace App\Owner\Domain\Exception;

use App\Shared\Domain\Exception\AbstractException;

class CatAlreadyAssignedToOwner extends AbstractException
{
    public function __construct(int $ownerId, int $catId)
    {
        $message = sprintf('Cat with id %d is already assigned to owner with id %d', $catId, $ownerId);
        $code = 400;
        $parameters = [
            'ownerId' => $ownerId,
            'catId' => $catId,
        ];

        parent::__construct($message, $code, $parameters);
    }
}
