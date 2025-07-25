<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\HomeRepository;
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
            'offerings' => HomeRepository::getOfferings(),
        ]);
    }

    /**
     * Show all the products in one page.
     *
     * @return Response
     */
    public function products(): Response
    {
        return Inertia::render('ProductsList', [
            'products' => Product::with('category:id,title')->latest()->get(),
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
        return Inertia::render('CategoriesList', [
            'categories' => fn () => Category::all(),
            'products'   => fn () => HomeRepository::getProductsByCategory(),
        ]);
    }
}
