<?php

namespace App\PetStore;

enum PetStatus: string
{
    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case SOLD = 'sold';
}
