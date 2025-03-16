<?php

namespace App\PetStore;

use App\Contracts\PetStore\ICategory;
use App\Contracts\PetStore\IPet;
use App\Contracts\PetStore\IPetStoreApi;
use App\Exceptions\PetStoreApiException;
use App\PetStore\Contracts\IPetStoreApiClient;
use App\PetStore\Models\Category;
use App\PetStore\Models\Pet;
use App\PetStore\Models\Tag;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class PetStoreApi implements IPetStoreApi
{
    private const FIND_PETS_BY_STATUS = '/v2/pet/findByStatus';
    private const ADD_PET = '/v2/pets';
    private const UPDATE_PET = '/v2/pets/{petId}';
    private const UPLOAD_PET_IMAGE = '/v2/pets/{petId}/uploadImage';
    private const DELETE_PET = '/v2/pets/{petId}';

    public function __construct(private IPetStoreApiClient $client) {}

    /** @return IPet[] */
    public function findPetsByStatus(PetStatus $status): array
    {
        $response = $this->client->get(self::FIND_PETS_BY_STATUS, [
            'status' => $status->value,
        ]);

        if (!$response->success()) {
            throw new PetStoreApiException($response->getStatusCode(), json_encode($response->getBody()));
        }

        return array_map(function (array $data) {
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
        }, $response->getBody());
    }

    public function addPet(IPet $pet): bool
    {
        $response = $this->client->post(self::ADD_PET, [
            'name' => $pet->getName(),
            'photoUrls' => $pet->getPhotoUrls(),
            'status' => $pet->getStatus(),
            'category' => $pet->getCategory() ? [
                'id' => $pet->getCategory()->getId(),
                'name' => $pet->getCategory()->getName(),
            ] : null,
            'tags' => array_map(function (Tag $tag) {
                return [
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                ];
            }, $pet->getTags())
        ]);

        if (!$response->success()) {
            throw new PetStoreApiException($response->getStatusCode(), json_encode($response->getBody()));
        }

        return true;
    }

    public function updatePet(IPet $pet): bool
    {
        $route = str_replace('petId', $pet->getId(), self::UPDATE_PET);

        $response = $this->client->put($route, [
            'name' => $pet->getName(),
            'photoUrls' => $pet->getPhotoUrls(),
            'status' => $pet->getStatus(),
            'category' => $pet->getCategory() ? [
                'id' => $pet->getCategory()->getId(),
                'name' => $pet->getCategory()->getName(),
            ] : null,
            'tags' => array_map(function (Tag $tag) {
                return [
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                ];
            }, $pet->getTags())
        ]);

        if (!$response->success()) {
            throw new PetStoreApiException($response->getStatusCode(), json_encode($response->getBody()));
        }

        return true;
    }

    public function deletePet(int $id): bool
    {
        $route = str_replace('petId', $id, self::DELETE_PET);

        $response = $this->client->delete($route);

        if (!$response->success()) {
            throw new PetStoreApiException($response->getStatusCode(), json_encode($response->getBody()));
        }

        return true;
    }

    public function uploadPetImage(int $id, UploadedFile $file): bool
    {
        $route = str_replace('petId', $id, self::UPLOAD_PET_IMAGE);

        $response = $this->client->postUpload($route, $file);

        if (!$response->success()) {
            throw new PetStoreApiException($response->getStatusCode(), json_encode($response->getBody()));
        }

        return true;
    }

    private function parseCategory(array $category): ICategory
    {
        return new Category(Arr::get($category, 'id'), Arr::get($category, 'name'));
    }

    private function parseTags(array $tags): array
    {
        $parsed_tags = [];

        foreach ($tags as $tag) {
            $parsed_tags[] = new Tag(
                Arr::get($tag, 'id'),
                Arr::get($tag, 'name')
            );
        }

        return $parsed_tags;
    }
}
