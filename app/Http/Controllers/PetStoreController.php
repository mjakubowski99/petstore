<?php

namespace App\Http\Controllers;

use App\Contracts\PetStore\IPetStoreApi;
use App\Descriptors\PetStatus;
use App\Exceptions\PetStoreApiException;
use App\Http\Request\EditPetRequest;
use App\Http\Request\IndexPetByStatusRequest;
use App\Http\Request\StorePetRequest;
use App\Http\Request\UpdatePetRequest;
use App\Http\Request\UploadImageRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PetStoreController extends Controller
{
    public function __construct(
        private IPetStoreApi $api
    ) {}

    public function indexByStatus(IndexPetByStatusRequest $request): View
    {
        try {
            $pets = $this->api->findPetsByStatus($request->getPetStatus());
        } catch (PetStoreApiException $exception) {
            $pets = [];
            $error_message = 'Failed to fetch pets. Please try again later.';
        }

        return view('pets.index', [
            'pets' => $pets,
            'statuses' => array_map(function (PetStatus $status){
                return $status->value;
            }, PetStatus::cases()),
            'current_status' => $request->getPetStatus()->value,
            'error_message' => $error_message ?? null,
        ]);
    }

    public function create(): View
    {
        return view('pets.create', [
            'statuses' => PetStatus::toStringCases(),
        ]);
    }

    public function store(StorePetRequest $request): RedirectResponse
    {
        $pet = $this->api->addPet($request);

        return redirect()->to(route('pets.edit', ['petId' => $pet->getId()]));
    }

    public function edit(EditPetRequest $request)
    {
        $pet = $this->api->findById($request->getId());

        return view('pets.edit', [
            'pet' => $pet,
            'statuses' => PetStatus::toStringCases(),
        ]);
    }

    public function update(UpdatePetRequest $request): RedirectResponse
    {
        $this->api->updatePet($request);

        return redirect()->to(route('pets.edit', ['petId' => $request->getId()]));
    }

    public function uploadImage(UploadImageRequest $request): RedirectResponse
    {
        $this->api->uploadPetImage($request->getId(), $request->getFile());

        return redirect()->to(route('pets.edit', ['petId' => $request->getId()]));
    }

    public function destroy(EditPetRequest $request): RedirectResponse
    {
        $this->api->deletePet($request->getId());

        return redirect()->back();
    }
}
