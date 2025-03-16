<?php

namespace App\PetStore\Models;

use App\Contracts\PetStore\ICategory;

class Category implements ICategory
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
