<?php

namespace App\Http\Request;

use App\Contracts\PetStore\ICategory;
use App\Contracts\PetStore\IPet;
use App\Contracts\PetStore\ITag;
use App\Descriptors\PetStatus;
use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest implements IPet
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'status' => ['required', 'string'],
            'photos' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
            'category_name' => ['nullable', 'string'],
        ];
    }

    public function getId(): int
    {
        return 0;
    }

    public function getName(): string
    {
        return $this->input('name');
    }

    public function getStatus(): PetStatus
    {
        return PetStatus::from($this->input('status'));
    }

    public function getCategory(): ?ICategory
    {
        return $this->input('category_name') ? new class ($this->input('category_name')) implements ICategory
        {
            public function __construct(
                private string $category_name
            ) {}

            public function getId(): int
            {
                return 0;
            }

            public function getName(): string
            {
                return $this->category_name;
            }
        } : null;
    }

    public function getTags(): array
    {
        $tags = explode(',', $this->input('tags', []));
        $result = [];

        foreach ($tags as $tag) {
            $result[] = new class ($tag) implements ITag
            {
                public function __construct(private string $tag) {}
                public function getId(): int
                {
                    return 0;
                }

                public function getName(): string
                {
                    return $this->tag;
                }
            };
        }

        return $result;
    }

    public function getPhotoUrls(): array
    {
        return explode(',', $this->input('photos'));
    }
}
