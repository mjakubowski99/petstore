<?php

namespace App\Contracts\PetStore;

interface ITag
{
    public function getId(): int;
    public function getName(): string;
}
