<?php

namespace App\Http\Controllers;

use App\Contracts\PetStore\IPetStoreApi;
use App\Http\Request\IndexPetByStatusRequest;
use App\Http\Request\StorePetRequest;

class PetStoreController extends Controller
{
    public function indexByStatus(IndexPetByStatusRequest $request, IPetStoreApi $api)
    {
        $pets = $api->findPetsByStatus($request->getPetStatus());

        return view('pets.index', ['pets' => $pets]);
    }

    public function store(StorePetRequest $request, IPetStoreApi $api)
    {
        $api->addPet($request);
    }
}
