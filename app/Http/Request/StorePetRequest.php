<?php

namespace App\Http\Request;

use App\Contracts\PetStore\ICategory;
use App\Contracts\PetStore\IPet;
use App\Contracts\PetStore\ITag;
use App\PetStore\PetStatus;
use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest implements IPet
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'photoUrls' => ['required', 'array'],
            'status' => ['required', 'string'],
            'tags' => ['nullable', 'array'],
            'tags.*.id' => ['required', 'integer'],
            'tags.*.name' => ['required', 'string'],
            'category.id' => ['required', 'integer'],
            'category.name' => ['required', 'string'],
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
        return $this->input('category') ? new class ($this->input('category')) implements ICategory
        {
            public function __construct(
                private array $category
            ) {}

            public function getId(): int
            {
                return $this->category['id'];
            }

            public function getName(): string
            {
                return $this->category['name'];
            }
        } : null;
    }

    public function getTags(): array
    {
        $tags = $this->input('tags');
        $result = [];

        foreach ($tags as $tag) {
            $result[] = new class ($tag) implements ITag
            {
                public function __construct(private array $tag) {}
                public function getId(): int
                {
                    return $this->tag['id'];
                }

                public function getName(): string
                {
                    return $this->tag['name'];
                }
            };
        }

        return $result;
    }

    public function getPhotoUrls(): array
    {
        return $this->input('photoUrls');
    }
}
