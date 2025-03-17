<?php

declare(strict_types=1);

namespace App\PetStore\Models;

use App\Contracts\PetStore\ICategory;
use App\Contracts\PetStore\IPet;
use App\Contracts\PetStore\ITag;
use App\Descriptors\PetStatus;

class Pet implements IPet
{
    public function __construct(
        private int $id,
        private string $name,
        private PetStatus $status,
        private array $photo_urls,
        private ?ICategory $category,
        private array $tags,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): PetStatus
    {
        return $this->status;
    }

    /** @return string[] */
    public function getPhotoUrls(): array
    {
        return $this->photo_urls;
    }

    public function getCategory(): ?ICategory
    {
        return $this->category;
    }

    /** @return ITag[] */
    public function getTags(): array
    {
        return $this->tags;
    }
}
