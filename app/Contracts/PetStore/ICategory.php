<?php

namespace App\Contracts\PetStore;

interface ICategory
{
    public function getId(): int;
    public function getName(): string;
}
