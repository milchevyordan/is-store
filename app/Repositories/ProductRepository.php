<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class ProductRepository
{
    /**
     * Get the latest 3 products for the homepage.
     *
     * @return mixed
     */
    public static function getOfferings(): mixed
    {
        return Cache::remember('products.offerings', now()->addMinutes(60), function () {
            return Product::whereNotNull('image')->latest()->take(3)->get();
        });
    }

    /**
     * Get the products in all products page.
     *
     * @param  int       $perPage
     * @return Paginator
     */
    public static function getPaginatedWithCategory(int $perPage = 6): Paginator
    {
        $page = request()->query('page', 1);

        $cacheKey = "products.paginated.page_{$page}_perPage_{$perPage}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($perPage) {
            return Product::with('category:id,title')->latest()->paginate($perPage);
        });
    }

    /**
     * Get paginated products by given category in query.
     *
     * @return mixed
     */
    public static function getPaginatedByCategory(int $perPage = 6): Paginator
    {
        $categoryId = request()->query('category_id');
        $page = request()->query('page', 1);

        $cacheKey = "products.by_category.category_{$categoryId}_page_{$page}_perPage_{$perPage}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($categoryId, $perPage) {
            return Product::where('category_id', $categoryId)
                ->latest()
                ->paginate($perPage);
        });
    }
}
