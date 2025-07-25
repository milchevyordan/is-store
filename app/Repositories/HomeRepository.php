<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;

class HomeRepository
{
    public static function getOfferings()
    {
        return Product::whereNotNull('image')->latest()->take(3)->get();
    }
}
