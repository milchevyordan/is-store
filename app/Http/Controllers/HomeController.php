<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Show welcome page.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Welcome', [
            'offerings' => ProductRepository::getOfferings(),
        ]);
    }

    /**
     * Show all the products in one page.
     *
     * @return Response
     */
    public function products(): Response
    {
        $products = ProductRepository::getPaginatedWithCategory();

        return Inertia::render('ProductsList', [
            'products' => Inertia::merge(fn () => $products->items()),
            'current'  => $products->currentPage(),
            'last'     => $products->lastPage(),
        ]);
    }

    /**
     * Show the specific product page.
     *
     * @param           $slug
     * @return Response
     */
    public function product($slug): Response
    {
        return Inertia::render('Product', [
            'product' => Product::with('category')->where('slug', $slug)->first(),
        ]);
    }

    public function categories(): Response
    {
        $currentCategory = request()->query('category_id');
        $previousCategory = session('last_category_id');

        $products = ProductRepository::getPaginatedByCategory();

        session(['last_category_id' => $currentCategory]);

        $useMerge = $previousCategory == $currentCategory;

        return Inertia::render('CategoriesList', [
            'categories' => fn () => Category::all(),
            'products'   => $useMerge
                ? Inertia::merge(fn () => $products->items())
                : $products->items(),
            'current' => $products->currentPage(),
            'last'    => $products->lastPage(),
        ]);
    }
}
