<?php

declare(strict_types=1);

namespace App\PetStore\Models;

use App\Contracts\PetStore\ITag;

class Tag implements ITag
{
    public function __construct(
        private int $id,
        private string $name
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
