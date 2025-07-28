<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ProductRepository;
use Inertia\Inertia;

class ProductFrontService
{
    public static function getPaginatedByCategory(): array
    {
        $currentCategory = request()->query('category_id');
        $previousCategory = session('last_category_id');

        $products = ProductRepository::getPaginatedByCategory();

        session(['last_category_id' => $currentCategory]);

        $useMerge = $previousCategory == $currentCategory;

        return [
            'products' => $useMerge
                ? Inertia::merge(fn () => $products->items())
                : $products->items(),
            'current' => $products->currentPage(),
            'last'    => $products->lastPage(),
        ];
    }
}
