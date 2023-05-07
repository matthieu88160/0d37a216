<?php

declare(strict_types=1);

namespace App\Entity\Dto;

class UserDto
{
    public ?string $name = null;

    public array $roles = [];

    public ?string $password = null;
}
