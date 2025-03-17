<?php

use App\Http\Controllers\PetStoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PetStoreController::class, 'indexByStatus'])->name('pets.index');
Route::get('/pets/create', [PetStoreController::class, 'create'])->name('pets.create');
Route::post('/pets', [PetStoreController::class, 'store'])->name('pets.store');
Route::get('/pets/{petId}/edit', [PetStoreController::class, 'edit'])->name('pets.edit');
Route::put('/pets/{petId}', [PetStoreController::class, 'update'])->name('pets.update');
Route::post('/pets/{petId}/uploadImage', [PetStoreController::class, 'uploadImage'])->name('pets.upload-image');
Route::delete('/pets/{petId}', [PetStoreController::class, 'destroy'])->name('pets.destroy');
