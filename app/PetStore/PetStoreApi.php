<?php

declare(strict_types=1);

namespace App\PetStore;

use App\Contracts\PetStore\ICategory;
use App\Contracts\PetStore\IPet;
use App\Contracts\PetStore\IPetStoreApi;
use App\Contracts\PetStore\ITag;
use App\Descriptors\PetStatus;
use App\Exceptions\PetStoreApiException;
use App\PetStore\Contracts\IPetStoreApiClient;
use App\PetStore\Contracts\IResponse;
use App\PetStore\Models\Category;
use App\PetStore\Models\Pet;
use App\PetStore\Models\Tag;
use Illuminate\Support\Arr;

class PetStoreApi implements IPetStoreApi
{
    private const FIND_PETS_BY_STATUS = '/v2/pet/findByStatus';
    private const FIND_PET = '/v2/pet/{petId}';
    private const ADD_PET = '/v2/pet';
    private const UPDATE_PET = '/v2/pet';
    private const DELETE_PET = '/v2/pet/{petId}';

    public function __construct(private IPetStoreApiClient $client) {}

    /** @return IPet[] */
    public function findPetsByStatus(PetStatus $status): array
    {
        $response = $this->client->get(self::FIND_PETS_BY_STATUS, [
            'status' => $status->value,
        ]);

        $this->throwIfResponseNotSuccessful($response);

        return array_map(function (array $data) {
            return $this->parsePet($data);
        }, $response->getBody());
    }

    public function findById(int $id): IPet
    {
        $route = str_replace('{petId}', (string) $id, self::FIND_PET);

        $response = $this->client->get($route);

        $this->throwIfResponseNotSuccessful($response);

        return $this->parsePet($response->getBody());
    }

    public function addPet(IPet $pet): IPet
    {
        $response = $this->client->post(self::ADD_PET, [
            'name' => $pet->getName(),
            'photoUrls' => $pet->getPhotoUrls(),
            'status' => $pet->getStatus(),
            'category' => $pet->getCategory() ? [
                'id' => $pet->getCategory()->getId(),
                'name' => $pet->getCategory()->getName(),
            ] : null,
            'tags' => array_map(function (ITag $tag) {
                return [
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                ];
            }, $pet->getTags())
        ]);

        $this->throwIfResponseNotSuccessful($response);

        return $this->parsePet($response->getBody());
    }

    public function updatePet(IPet $pet): bool
    {
        $response = $this->client->put(self::UPDATE_PET, [
            'id' => $pet->getId(),
            'name' => $pet->getName(),
            'photoUrls' => $pet->getPhotoUrls(),
            'status' => $pet->getStatus(),
            'category' => $pet->getCategory() ? [
                'id' => $pet->getCategory()->getId(),
                'name' => $pet->getCategory()->getName(),
            ] : null,
            'tags' => array_map(function (ITag $tag) {
                return [
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                ];
            }, $pet->getTags())
        ]);

        $this->throwIfResponseNotSuccessful($response);

        return true;
    }

    public function deletePet(int $id): bool
    {
        $route = str_replace('{petId}', (string) $id, self::DELETE_PET);

        $response = $this->client->delete($route);

        $this->throwIfResponseNotSuccessful($response);

        return true;
    }

    private function throwIfResponseNotSuccessful(IResponse $response): void
    {
        if (!$response->success()) {
            throw new PetStoreApiException($response->getStatusCode(), 'Error', $response->getBody());
        }
    }

    private function parsePet(array $data): Pet
    {
        $category = Arr::get($data, 'category');
        $tags = Arr::get($data, 'tags') ?? [];

        return new Pet(
            Arr::get($data, 'id'),
            Arr::get($data, 'name') ?? '',
            PetStatus::from(Arr::get($data, 'status')),
            Arr::get($data, 'photoUrls') ? Arr::get($data, 'photoUrls') : [],
            $category ? $this->parseCategory($category) : null,
            $this->parseTags($tags),
        );
    }

    private function parseCategory(array $category): ?ICategory
    {
        $id = Arr::get($category, 'id');
        //sometimes api do not return string value here. don't know why
        $name = Arr::get($category, 'name');

        if (!$name) {
            return null;
        }

        return new Category($id??0, $name);
    }

    private function parseTags(array $tags): array
    {
        $parsed_tags = [];

        foreach ($tags as $tag) {
            $parsed_tags[] = new Tag(
                Arr::get($tag, 'id') ?? 0,
                Arr::get($tag, 'name')
            );
        }

        return $parsed_tags;
    }
}
