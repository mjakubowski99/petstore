<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e) {
            if ($e instanceof PetStoreApiException) {
                if ($e->getStatusCode() === 400) {
                    return redirect()->to(route('pets.index'))->withErrors([
                        'error' => Arr::get($e->getBody(), 'message') ?? 'Bad request.',
                    ]);
                }
                if ($e->getStatusCode() === 404) {
                    return redirect()->to(route('pets.index'))->withErrors([
                        'error' => Arr::get($e->getBody(), 'message') ?? 'Resource not found.',
                    ]);
                }
                else {
                    return redirect()->to(route('pets.index'))->withErrors([
                        'error' => 'Unexpected error. Please try again later.',
                    ]);
                }
            }
        });
    }
}
