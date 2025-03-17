<?php

declare(strict_types=1);

namespace App\Contracts\PetStore;

interface ITag
{
    public function getId(): int;
    public function getName(): string;
}
