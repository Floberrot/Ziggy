<?php

namespace App\Owner\Application\Command\RegisterOwner;

use App\Shared\Application\Command\Command;

class RegisterOwnerMessage implements Command
{
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $phone;
}
