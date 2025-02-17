<?php

namespace App\Owner\Domain\Model;

use App\User\Domain\Model\User;

final class Owner extends User
{
    public const string ROLE = "ROLE_OWNER";
}
