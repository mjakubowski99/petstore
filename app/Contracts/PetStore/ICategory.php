<?php

declare(strict_types=1);

namespace App\Contracts\PetStore;

interface ICategory
{
    public function getId(): int;
    public function getName(): string;
}
