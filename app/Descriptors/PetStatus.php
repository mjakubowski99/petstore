<?php

declare(strict_types=1);

namespace App\Descriptors;

enum PetStatus: string
{
    public const DEFAULT = self::AVAILABLE;

    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case SOLD = 'sold';

    public static function toStringCases(): array
    {
        return array_map(function (PetStatus $status){
            return $status->value;
        }, PetStatus::cases());
    }
}
