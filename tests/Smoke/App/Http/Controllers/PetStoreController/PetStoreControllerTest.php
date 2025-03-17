<?php

declare(strict_types=1);

namespace Tests\Smoke\App\Http\Controllers\PetStoreController;

use App\Descriptors\PetStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PetStoreControllerTest extends TestCase
{
    use DatabaseTransactions;
    use PetStoreControllerTrait;

    public function test__indexByStatus_success(): void
    {
        // GIVEN
        $expected_id = 1;
        $this->fakePetStoreApi('*', [
            [
                'id' => $expected_id,
                'name' => 'Name',
                'status' => PetStatus::AVAILABLE,
                'photoUrls' => ['http://test'],
                'tags' => [],
                'category' => null,
            ]
        ]);

        // WHEN
        $response = $this->get(route('pets.index'));

        // THEN
        $response->assertSuccessful();
        $pets = $response->viewData('pets');

        $this->assertCount(1, $pets);
        $this->assertSame($expected_id, $pets[0]->getId());
    }

    public function test__addPet_success(): void
    {
        // GIVEN
        $expected_id = 1;
        $this->fakePetStoreApi('*', [
            'id' => $expected_id,
            'name' => 'Name',
            'status' => PetStatus::AVAILABLE,
            'photoUrls' => ['http://test'],
            'tags' => [
                [
                    'id' => 1,
                    'name' => 'tag1'
                ],
                [
                    'id' => 1,
                    'name' => 'tag2'
                ],
            ],
            'category' => [
                'id' => 1,
                'name' => 'Test',
            ]
        ]);

        // WHEN
        $response = $this->post(route('pets.store'), [
            'name' => 'NameX',
            'status' => PetStatus::PENDING->value,
            'photos' => 'http://test,http://test2',
            'tags' => 'tag1,tag2',
            'category_name' => 'Test',
        ]);

        // THEN
        $response->assertRedirect(route('pets.edit', ['petId' => $expected_id]));
    }

    public function test__updatePet_success(): void
    {
        // GIVEN
        $expected_id = 12;
        $this->fakePetStoreApi('*', [
            'id' => $expected_id,
            'name' => 'Name',
            'status' => PetStatus::AVAILABLE,
            'photoUrls' => ['http://test'],
            'tags' => [
                [
                    'id' => 1,
                    'name' => 'tag1'
                ],
                [
                    'id' => 1,
                    'name' => 'tag2'
                ],
            ],
            'category' => [
                'id' => 1,
                'name' => 'Test',
            ]
        ]);

        // WHEN
        $response = $this->put(route('pets.update', ['petId' => $expected_id]), [
            'name' => 'NameX',
            'status' => PetStatus::PENDING->value,
            'photos' => 'http://test,http://test2',
            'tags' => 'tag1,tag2',
            'category_name' => 'Test',
        ]);

        // THEN
        $response->assertRedirect(route('pets.edit', ['petId' => $expected_id]));
    }

    public function test__updatePet_WhenPetNotFound_redirectToIndexPageWithMessage(): void
    {
        // GIVEN
        $expected_id = 12;
        $this->fakePetStoreApi('*', [
            'code' => 404,
            'message' => 'Pet not found.',
        ], 404);

        // WHEN
        $response = $this->put(route('pets.update', ['petId' => $expected_id]), [
            'name' => 'NameX',
            'status' => PetStatus::PENDING->value,
            'photos' => 'http://test,http://test2',
            'tags' => 'tag1,tag2',
            'category_name' => 'Test',
        ]);

        // THEN
        $response->assertRedirect(route('pets.index'));
    }

    public function test__deletePet_success(): void
    {
        // GIVEN
        $expected_id = 12;
        $this->fakePetStoreApi('*', []);

        // WHEN
        $response = $this->delete(route('pets.destroy', ['petId' => $expected_id]));

        // THEN
        $response->assertRedirect(route('pets.index'));
    }

    public function test__deletePet_WhenPetNotFound_redirectToIndexPageWithMessage(): void
    {
        // GIVEN
        $expected_id = 12;
        $this->fakePetStoreApi('*', ['code' => 404, 'message' => 'Pet not found'], 404);

        // WHEN
        $response = $this->delete(route('pets.destroy', ['petId' => $expected_id]));

        // THEN
        $response->assertRedirect(route('pets.index'));
    }
}
