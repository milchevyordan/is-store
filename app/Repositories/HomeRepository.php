<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;

class HomeRepository
{
    /**
     * Get the latest 3 products for the homepage.
     *
     * @return mixed
     */
    public static function getOfferings(): mixed
    {
        return Product::whereNotNull('image')->latest()->take(3)->get();
    }

    /**
     * Get products by given category in query.
     *
     * @return mixed
     */
    public static function getProductsByCategory()
    {
        $categoryId = request()->query('category_id');

        return Product::where('category_id', $categoryId)->latest()->get();
    }
}
