<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;

class ProductRepository
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
     * Get the products in all products page.
     *
     * @param  int       $perPage
     * @return Paginator
     */
    public static function getPaginatedWithCategory(int $perPage = 6): Paginator
    {
        return Product::with('category:id,title')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get paginated products by given category in query.
     *
     * @return mixed
     */
    public static function getPaginatedByCategory(int $perPage = 6): Paginator
    {
        $categoryId = request()->query('category_id');

        return Product::where('category_id', $categoryId)->latest()->paginate($perPage);
    }
}
