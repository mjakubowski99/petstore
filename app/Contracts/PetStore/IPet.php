<?php

declare(strict_types=1);

namespace App\Contracts\PetStore;

use App\Descriptors\PetStatus;

interface IPet
{
    public function getId(): int;
    public function getName(): string;
    public function getStatus(): PetStatus;
    public function getCategory(): ?ICategory;
    /** @return ITag[] */
    public function getTags(): array;
    public function getPhotoUrls(): array;
}
